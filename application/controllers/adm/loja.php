<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class loja extends MY_Controller {
       
    public function __construct() {
        
        parent::__construct('loja', 44, array('data'));
        
        // Carrega o Model da aplicação
        $this->load->model($this->config->item('admin') . 'loja_model');
    }
   
    public function index() {
        
           // 'Delega' para o método all() logo abaixo
            $this->all();
    }

    public function all($apartir_de = 0) {
        
        $model = 'loja_model';
        $url = $this->config->item('admin') . $this->controller . '/all';
        
        $campos = array(
            'id'     => _lang('form_id'),
            'descricao'   => _lang('form_descricao')
        );
        
        $dados = array();
        $dados['filtro']   = parent::filtrar($model, $url, $campos, $apartir_de, $status = '', $campo_data = 'data_registro',$tipos_status = false);
        
        $fnd = $this->menu_model->get_by_id($this->funcionalidade);
        
        parent::view($fnd->nome, $this->config->item('admin') . $fnd->url, $dados);
    }
 
    public function editar($id) {
        
        $loja = $this->loja_model->get_by_id($id);
        
        $dados = array();
        
        // Acessa o Model
        $dados['loja'] = $loja;
        $dados['url']          = $this->config->item('admin') . $this->controller . '/atualizar';
        $dados['url_cancelar'] = $this->config->item('admin') . $this->controller;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/loja.js'; 
        
        $titulo       = _lang('form_editar') . '&nbsp;' . _lang('menu_loja');
        $conteudo     = $this->config->item('admin') . $this->controller . '/editar';
        
        parent::view($titulo, $conteudo, $dados);
    }

    public function atualizar() {

        $registro = $this->get_post();
       
        parent::atualizar($registro);
    }
    
    private function get_post() {
        
        $dados = new stdClass();
        
        $id = (int)$this->input->post('id');
        
        if(($id > 0) && ($id != null)) {
            $dados->id          = $id;
        }
        
        $dados->descricao  = $this->input->post('descricao');
        $dados->pontos = $this->input->post('pontos');
        
        return $dados;
    }
}

?>
