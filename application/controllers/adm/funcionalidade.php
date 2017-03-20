<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Controller responsável pelo gerenciamento das funcionalidades do sistema
 * 
 * @package Controllers/adm
 * @name Funcionalidade
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class funcionalidade extends CI_Controller {

    /**
     * Método construtor
     * 
     * @name _construct
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function __construct() {
        
        parent::__construct();

        _login_admin();
        _access_admin(3);

        // Carrega o Model da aplicação
        $this->load->model($this->config->item('admin') . 'funcionalidade_model');
        
        $this->load->helper('array_helper');
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios','mensagens','grupos_usuario','data'); 
        
        $this->load->language($arquivos, $this->session->userdata('idioma'));
    }
    
    /**
     * Index. Redireciona para 'funcionalidade/all' 
     * 
     * @name index
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function index() {
        // 'Delega' para o método all() logo abaixo
        $this->all();
    }

    /**
     * Exibe todos os funcionalidades
     * 
     * @name all
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param int $apartir_de A partir de quantos registros começa a seleção
     * @return void
     */
    public function all($apartir_de = 0) {

        $this->load->library('filtro_library');

        $controladora = 'funcionalidade';
        $model = 'funcionalidade_model';
        $url = $this->config->item('admin') . 'funcionalidade/all';
        $por_pagina = $this->input->post('por_pagina');
        
        $campos = array(
            'id'     => _lang('form_id'),
            'nome'   => _lang('form_nome'),
            'acesso' => _lang('form_acesso'),
        );

        $this->filtro_library->init($controladora, $model, $url, $por_pagina, $campos, 'data_registro', $Status = array('1' => _lang('form_ativa'), '0' => _lang('form_inativa')));

        // Campo a ser filtrado
        $filtro['campo'] = $this->input->post('campo');
        // Valor ao qual vai ocorrer a filtragem
        $filtro['valor']['value'] = $this->input->post('valor');
        // Rotulo que aparecera na tela para esse valor
        $filtro['valor']['label'] = $this->input->post('valor');
        
        // Filtro de data
        $data['inicial'] = $this->input->post('data_inicial');
        $data['final']   = $this->input->post('data_final');

        // Se esta setado para utilizar o filtro por status
        $status = $this->input->post('status');
        
        $dados['filtro']   = $this->filtro_library->gerar_filtro($apartir_de, $filtro,$data,$status);
        $dados['menu']     = $this->menu_library->menu_admin();
        $fnd               = $this->menu_model->get_by_id(3);
        $dados['titulo']   = $fnd->nome;
        $dados['conteudo'] = $this->config->item('admin') . $fnd->url;
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 3;
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }
    
    /**
     * Mostra o formulario de cadastro de novo funcionalidade
     * @name novo
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function novo() {
       
        $this->load->model(array($this->config->item('admin') . 'modulo_model',
                                 $this->config->item('admin') . 'grupo_model'));
        
        // Busca todos os grupos de usuario cadastrados
        $dados['grupos'] = $this->grupo_model->get_all_where();
        
        if(element($this->config->item('super_users'), $dados['grupos']) != NULL) {
            
            for($i=0; $i,sizeof($dados['grupos']); $i++) {
                
                if($dados['grupos'][$i]->id == $this->config->item('super_users')) {
                    
                    unset($dados['grupos'][$i]);
                    break;
                }
            }
        }
        
        $dados['modulos']      = $this->modulo_model->get_array_modulos();
        $dados['menu']         = $this->menu_library->menu_admin();
                      
        $dados['titulo']       = _lang('form_nova') . '&nbsp;' . _lang('menu_funcionalidade');
        $dados['conteudo']     = $this->config->item('admin') . 'funcionalidade/editar';
        $dados['url']          = $this->config->item('admin') . 'funcionalidade/cadastrar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'funcionalidade';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 3;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/funcionalidade.js';
        // Carrega o javascript de eventos do formulario de edicao
        $dados['assets_js'][] = 'ajax/funcionalidade.js';
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Insere uma nova funcionalidade
     * @name cadastrar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function cadastrar() {
        
        $dados = new stdClass();
        $dados->nome      = $this->input->post('fun_nome');
        $dados->modulo_id = $this->input->post('fun_modulo');
        $dados->url       = $this->input->post('fun_url');
        $dados->ativo     = $this->input->post('fun_ativo');
        $dados->ordem     = $this->input->post('fun_ordem');
        
        $grupos = $this->input->post('fun_grupos');
        
        $grupos[] = $this->config->item('super_users');
        
        $resultado = $this->funcionalidade_model->insert($dados,$grupos);
        
        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_insert-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'funcionalidade', 'refresh');
    }
    
    /**
     * Metodo de edição
     * @name editar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param int $id id da funcionalidade
     * @return void
     */
    public function editar($id) {
       
        $this->load->model(array($this->config->item('admin') . 'modulo_model',
                                 $this->config->item('admin') . 'grupo_model'));
        
        // Busca todos os grupos de usuario cadastrados
        $dados['grupos'] = $this->grupo_model->get_all_where();
        
        if(element($this->config->item('super_users'), $dados['grupos']) != NULL) {
            
            for($i=0; $i,sizeof($dados['grupos']); $i++) {
                
                if($dados['grupos'][$i]->id == $this->config->item('super_users')) {
                    
                    unset($dados['grupos'][$i]);
                    break;
                }
            }
        }
        
        $dados['modulos']        = $this->modulo_model->get_array_modulos();
        
        $dados['com_acesso']     = $this->funcionalidade_model->get_grupos_acesso($id);
        
        $dados['funcionalidade'] = $this->funcionalidade_model->get_by_id($id);
        
        $dados['menu']           = $this->menu_library->menu_admin();
        
        $dados['titulo']         = _lang('form_editar') . '&nbsp;' . _lang('menu_funcionalidade');
        $dados['conteudo']       = $this->config->item('admin') . 'funcionalidade/editar';
        $dados['url']            = $this->config->item('admin') . 'funcionalidade/atualizar';
        $dados['url_cancelar']   = $this->config->item('admin') . 'funcionalidade';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 3;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/funcionalidade.js';          
        // Carrega o javascript de eventos do formulario de edicao
        $dados['assets_js'][] = 'ajax/funcionalidade.js';
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Processa uma atualização
     * @name atualizar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function atualizar() {

        // Cria um objeto que recebe os dados enviados via post
        $dados = new stdClass();
        
        $dados->id        = (int)$this->input->post('fun_id');
        $dados->nome      = $this->input->post('fun_nome');
        $dados->modulo_id = $this->input->post('fun_modulo');
        $dados->url       = $this->input->post('fun_url');
        $dados->ativo     = $this->input->post('fun_ativo');
        $dados->ordem     = $this->input->post('fun_ordem');
        
        $grupos = $this->input->post('fun_grupos');
        
        $grupos[] = $this->config->item('super_users');
       
        // Chama o Model e pede para atualizar a funcionalidade
        $resultado = $this->funcionalidade_model->update($dados,$grupos);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_update-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'funcionalidade', 'refresh');
    }
    
    /**
     * Remove uma funcionalidade
     * @name remover
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param array/string $ids ids das funcionalidade a serem removidas
     * @return void
     */
    public function remover($ids) {
        
         // Transforma a string recebida em array
        if(is_string($ids)) {
            
            $ids = explode('-', $ids);
        }
        $resultado = $this->funcionalidade_model->delete($ids);

        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_delete-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'funcionalidade', 'refresh');
    }

}

?>
