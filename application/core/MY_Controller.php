<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Classe Controller que extende os recursos disponibilizados pela CI_Controller
 * 
 * @package Core
 * @name TK_Controller
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2014, Tellks - Solucoes em tecnologia ltda
 * @since 17/03/2014
 * 
 */
class MY_Controller extends CI_Controller{

    protected $funcionalidade;

    protected $controller;

    /**
     * Constroi uma instancia de uma controller
     * 
     * @name __construct
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 17/03/2014
     * @param string $controller Controladora nome da controladora
     * @param int $funcionalidade_id Id da funcionalidade da qual se refere
     * @param string $acesso
     */
    function __construct($controller, $funcionalidade_id = NULL, $linguagens = array()) {
        
        parent::__construct();
        
        $this->controller = $controller;
        
        $this->funcionalidade = ($funcionalidade_id != NULL) ? $funcionalidade_id : 0;
        
        if($this->funcionalidade > 0){
            _login_admin();
            _access_admin($this->funcionalidade);
        }
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array_merge($linguagens, array('formularios','mensagens')); 
        
        $idioma = ($this->session->userdata('idioma') != '')? $this->session->userdata('idioma') : $this->config->item('language');
        
        $this->load->language($arquivos, $idioma);
    }
    
    /**
     * Recebe os parametros da filtragem dos dados e encapsula a filtragem
     * 
     * @name filtrar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 17/03/2014
     * @param string $model Nome da model com a consulta em banco responsavel pela filtragem
     * @param string $url Url utilizada para criar a paginacao
     * @param array $campos Array contendo os campos em que serao aplicadas as clausulas de filtragem
     * @param int $apartir_de Registro inicial da pagina
     * @param int $status Status a ser filtrado
     * @param string $campo_data Nome do campo em que a data sera filtrada
     * @return Array Contendo os dados filtrados
     */
    function filtrar($model, $url, $campos, $apartir_de, $status = '', $campo_data = 'data_registro',$tipos_status = false){
        
        $this->load->library('filtro_library');
        
        $por_pagina = $this->input->post('por_pagina');
        
        $this->filtro_library->init($this->controller,$model,$url,$por_pagina,$campos, $campo_data, $tipos_status);
        
        // Campo a ser filtrado
        $filtro['campo'] = $this->input->post('campo');
        // Valor ao qual vai ocorrer a filtragem
        $filtro['valor']['value'] = $this->input->post('valor');
        // Rotulo que aparecera na tela para esse valor
        $filtro['valor']['label'] = $this->input->post('valor');

        $data['inicial'] = $this->input->post('data_inicial');
        $data['final'] = $this->input->post('data_final');

        // Se esta setado para utilizar o filtro por status
        if($status == ''){
            
            $status = $this->input->post('status');
        }
        
        return $this->filtro_library->gerar_filtro($apartir_de, $filtro,$data,$status);
    }

    /**
     * Encapsula as acoes comuns que deve ser usadas sempre antes de carregar uma view
     * 
     * @name view
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 17/03/2014
     * @param string $titulo Titulo da view a ser carregada
     * @param string $conteudo View com o conteudo a ser carregado numa view default
     * @param array $dados Array contendo os dados usados para popular elementos da view
     * @param string $masterPage View a ser carregada no lugar da view default
     */
    function view($titulo, $conteudo, $dados, $masterPage = ''){
        
        $dados['menu']   = $this->menu_library->menu();
        
        $dados['titulo'] = $titulo;
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = $this->funcionalidade;
        
        // Verifica se foi informada a view Master. Se foi utiliza esta view informada
        // Senao verifica o acesso e utiliza a Master default da area acessada pelo usuario
        if($masterPage == ''){
            
            $dados['conteudo'] = $conteudo;

            $masterPage = $this->config->item('tpl_admin');

        }
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($masterPage, $dados);
    }
    
    /**
     * Encapsula o cadastramento dos dados no banco de dados e a captura do resultado 
     * da operacao
     * 
     * @name cadastrar
     * @author Joao Claudio Dias Araujo<joao.araujo@tellks.com.br>
     * @since 17/03/2014
     * @param Object $registro Objeto contendo os dados a serem cadastrados
     * @return Void
     */
    function cadastrar($registro){
        
        $model = $this->controller . '_model';
        
        $resultado = $this->$model->insert($registro);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_insert-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona para index
        $this->to_index();
    }


    /**
     * Encapsula a atualizacao de um registro no banco e a captura do resultado da operacao
     * 
     * @name atualizar
     * @author Joao Claudio Dias Araujo<joao.araujo@tellks.com.br>
     * @since 17/03/2014
     * @param Object $registro Objeto contendo os dados a serem atualizados
     * @return Void
     */
    function atualizar($registro){
        
        $model = $this->controller . '_model';
        
        // Chama o Model e pede para atualizar o grupo
        $resultado = $this->$model->update($registro);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_update-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona para index
        $this->to_index();
    }


    /**
     * Remove os registros cujos Ids foram recebidos por parametro
     * 
     * @name remover
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 17/03/2014
     * @param string/array $ids ids dos grupos a serem removidos
     * @return void
     */
     function remover($ids) {

        $model = $this->controller . '_model';
        
        // Transforma a string recebida em array
        if(is_string($ids)) {
            
            $ids = explode('-', $ids);
        }
        
        $resultado = $this->$model->delete($ids);

        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_delete-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona para a index
        $this->to_index();
    }
    
    /**
     * Redireciona para o metodo index da controladora
     * 
     * @name to_index
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 17/03/2014
     * @param void
     * @return void
     */
    protected function to_index(){
        // Redireciona para a index da controladora
        redirect($this->config->item('admin') . $this->controller, 'refresh');
    }
}