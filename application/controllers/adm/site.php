<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Controller responsável pelo gerenciamento dos grupos de usuarios do sistema
 * 
 * @package Controllers/adm
 * @name Grupo
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class site extends CI_Controller {
    
    /**
     * Método construtor
     * 
     * @name _construct
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
     * @since 07/01/2015
     * @param void
     * @return void
     */
    public function __construct() {
        
        parent::__construct();

        _login_admin();
        _access_admin(36);

        // Carrega o Model da aplicação
        $this->load->model($this->config->item('admin') . 'site_model');
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios','mensagens','data'); 
        
        $this->load->language($arquivos, $this->session->userdata('idioma'));
    }

    /**
     * Index. Redireciona para 'site/editar' 
     * 
     * @name Index
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
     * @since 07/01/2015
     * @param void
     * @return void
     */
    public function index() {
        
           // 'Delega' para o método editar() logo abaixo
            $this->editar();
    }
    
    /**
     * Metodo de edição
     * 
     * @name editar
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
     * @since 07/01/2015
     * @param void
     * @return void
     */
    public function editar() {
        
        // Acessa o Model
        $dados['site'] = $this->site_model->get_all();
        $dados['menu']  = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_editar') . '&nbsp;' . _lang('menu_website');
        $dados['conteudo']     = $this->config->item('admin') . 'site/editar';
        $dados['url']          = $this->config->item('admin') . 'site/atualizar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'site';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 30;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/site.js';  
        $dados['assets_js'][] = 'ajax/site.js'; 
        
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js';
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/ckeditor/ckeditor.js';       
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Processa uma atualização
     * 
     * @name atualizar
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
     * @since 07/01/2015
     * @param void
     * @return void
     */
    public function atualizar() {

        // Cria um objeto que recebe os dados enviados via post
        $dados = new stdClass();
        $dados->titulo             = $this->input->post('site_titulo');
        $dados->video              = $this->input->post('site_video_institucional');
        $dados->texto_apresentacao = $this->input->post('site_texto_apresentacao');
        $dados->descricao          = $this->input->post('site_descricao');
        $dados->ativo              = $this->input->post('site_status');
        $dados->palavras_chave     = $this->input->post('site_palavras_chave');
        $dados->email              = $this->input->post('site_email');
        $dados->telefone           = $this->input->post('site_telefone');
        $dados->endereco           = $this->input->post('site_endereco');
        $dados->facebook           = $this->input->post('site_facebook');
        $dados->twitter            = $this->input->post('site_twitter');
        $dados->google_plus        = $this->input->post('site_google_plus');
        
        // Chama o Model e pede para atualizar o grupo
        $resultado = $this->site_model->update($dados);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_update-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'site', 'refresh');
    }
    
}

?>
