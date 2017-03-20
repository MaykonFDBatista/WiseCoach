<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Controller responsável pelo gerenciamento dos modulos do sistema
 * 
 * @package Controllers/adm
 * @name Modulo
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Modulo extends CI_Controller {
    
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
        _access_admin(2);

        // Carrega as Models da aplicação
        $this->load->model($this->config->item('admin') . 'modulo_model');
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios','mensagens','data'); 
        
        $this->load->language($arquivos, $this->session->userdata('idioma'));
    }

    /**
     * Index. Redireciona para 'modulo/all'
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
     * Exibe todos os modulos
     * 
     * @name all
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param int $apartir_de A partir de quantos registros começa a seleção
     * @return void
     */
    public function all($apartir_de = 0) {
        
        $this->load->library('filtro_library');

        $controladora = 'modulo';
        $model = 'modulo_model';
        $url = $this->config->item('admin') . 'modulo/all';
        $por_pagina = $this->input->post('por_pagina');
        $campos = array(
            'id'    => _lang('form_id'),
            'nome'  => _lang('form_nome'),
            'ordem' => _lang('form_ordem'),
        );

        $this->filtro_library->init($controladora, $model, $url, $por_pagina, $campos,'data_registro', $Status = array('1' => _lang('form_ativo'), '0' => _lang('form_inativo')));

        // Campo a ser filtrado
        $filtro['campo'] = $this->input->post('campo');
        // Valor ao qual vai ocorrer a filtragem
        $filtro['valor']['value'] = $this->input->post('valor');
        // Rotulo que aparecera na tela para esse valor
        $filtro['valor']['label'] = $this->input->post('valor');
        
        $data['inicial'] = $this->input->post('data_inicial');
        $data['final']   = $this->input->post('data_final');
        
         // Se esta setado para utilizar o filtro por status
        $status = $this->input->post('status');
        
        $dados['filtro'] = $this->filtro_library->gerar_filtro($apartir_de, $filtro,$data,$status);   
        $dados['menu']   = $this->menu_library->menu_admin();
        
        $fnd = $this->menu_model->get_by_id(2);
        $dados['titulo']   = $fnd->nome;
        $dados['conteudo'] = $this->config->item('admin') . $fnd->url;
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 2;
                
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Mostra o formulario de cadastro de novo modulo
     * 
     * @name novo
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function novo() {
       
        $dados['menu'] = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_novo') . '&nbsp;' . _lang('menu_modulo');
        $dados['conteudo']     = $this->config->item('admin') . 'modulo/editar';
        $dados['url']          = $this->config->item('admin') . 'modulo/cadastrar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'modulo';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 2;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/modulo.js';          
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Insere um novo modulo
     * 
     * @name cadastrar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function cadastrar() {
        
        $dados = new stdClass();
        $dados->nome  = $this->input->post('mod_nome');
        $dados->ativo = $this->input->post('mod_ativo');
        $dados->ordem = $this->input->post('mod_ordem');

        $resultado = $this->modulo_model->insert($dados);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_insert-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'modulo', 'refresh');
    }
    
    /**
     * Metodo de edição
     * 
     * @name editar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param int $id Id do modulo
     * @return void
     */
    public function editar($id) {
        
        // Acessa o Model
        $dados['modulos'] = $this->modulo_model->get_by_id($id);
        $dados['menu']   = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_editar') . '&nbsp;' . _lang('menu_modulo');
        $dados['conteudo']     = $this->config->item('admin') . 'modulo/editar';
        $dados['url']          = $this->config->item('admin') . 'modulo/atualizar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'modulo';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 2;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/modulo.js';          
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Processa uma atualização
     * 
     * @name atualizar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function atualizar() {

        // Cria um objeto que recebe os dados enviados via post
        $dados = new stdClass();
        $dados->id    = (int)$this->input->post('mod_id');
        $dados->nome  = $this->input->post('mod_nome');
        $dados->ativo = $this->input->post('mod_ativo');
        $dados->ordem = $this->input->post('mod_ordem');
       
        // Chama o Model e pede para atualizar o modulo
        $resultado = $this->modulo_model->update($dados);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_update-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'modulo', 'refresh');
    }

    /**
     * Remove um Modulo
     * 
     * @name remover
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param string/array $ids ids dos modulos a serem removidos
     * @return void
     */
    public function remover($ids) {
        
        // Transforma a string recebida em array
        if(is_string($ids)) {
            
            $ids = explode('-', $ids);
        }
        $resultado = $this->modulo_model->delete($ids);

        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_delete-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'modulo', 'refresh');
    }

}

?>
