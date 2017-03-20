<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

class home extends CI_Controller {
    
    function __construct() {
        
        parent::__construct();
        
        $this->session->set_userdata('pagina_anterior', current_url()); 
        $this->session->set_userdata('pagina_anterior_login', current_url()); 
        
        $this->load->model(array(
            $this->config->item('ws') . 'website_model',
            $this->config->item('ws') . 'categoria_model'));
        
        $this->load->config('submissao');
        
        $this->load->helper('tk_folder');
        $this->load->helper('tk_process_helper');
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios', 'mensagens'); 
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        
        $this->load->language($arquivos, $idioma);
        
        
    }
    
    function index() {
        
        $dados = array();
        $dados['website']    = $this->website_model->get_dados();
        $dados['categorias']    = $this->categoria_model->get_all();

        //view a ser carregada
        $dados['conteudo'] = 'home/index';
        
        $dados['pagina'] = 'home';
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }

}