<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class badge extends MY_Controller {
    
   
    public function __construct() {
        
        parent::__construct('badge', 42, array('data'));

        $this->load->config('arquivo');
        
        // Carrega o Model da aplicação
        $this->load->model($this->config->item('admin') . 'badge_model');
    }

   
    public function index() {
        
           // 'Delega' para o método all() logo abaixo
            $this->all();
    }

    public function all($apartir_de = 0) {
        
        $model = 'badge_model';
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

    public function novo() {
        
        $this->load->config('badge');
        
        $dados = array();
        $dados['regras'] = $this->config->item('regras_concessao_badge');
        
        $dados['url']          = $this->config->item('admin') . $this->controller . '/cadastrar';
        $dados['url_cancelar'] = $this->config->item('admin') . $this->controller;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/badge.js';        
        $dados['assets_js'][] = 'ajax/badge.js';   
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        $dados['template_js'][] = 'form/bootstrap-fileupload.min.js';
        $dados['template_js'][] = 'lib/select2/select2.min.js'; 
        $dados['template_js'][] = 'lib/select2/select2_locale_' . $this->session->userdata('idioma') . '.js';
        
        $titulo       = _lang('form_novo') . '&nbsp;' . _lang('menu_badge');
        $conteudo     = $this->config->item('admin') . $this->controller . '/editar';
        
        parent::view($titulo, $conteudo, $dados);
    }

    public function cadastrar() {
        
        $registro = $this->get_post();
        
        parent::cadastrar($registro);
    }
    
    public function editar($id) {
        
        $this->load->config('badge');
        
        $badge = $this->badge_model->get_by_id($id);
        
        $dados = array();
        $dados['regras'] = $this->config->item('regras_concessao_badge');
        
        // Acessa o Model
        $dados['badge'] = $badge;
        $dados['url']          = $this->config->item('admin') . $this->controller . '/atualizar';
        $dados['url_cancelar'] = $this->config->item('admin') . $this->controller;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/badge.js';
        $dados['assets_js'][] = 'ajax/badge.js';  
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        $dados['template_js'][] = 'form/bootstrap-fileupload.min.js';
        $dados['template_js'][] = 'lib/select2/select2.min.js'; 
        $dados['template_js'][] = 'lib/select2/select2_locale_' . $this->session->userdata('idioma') . '.js';
        
        $titulo       = _lang('form_editar') . '&nbsp;' . _lang('menu_badge');
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
        
        $dados->nome       = $this->input->post('nome');
        $dados->descricao  = $this->input->post('descricao');
        $dados->regra_concessao = $this->input->post('regra_concessao');
        $dados->parametro_concessao = $this->input->post('parametro_concessao');
        
        return $dados;
    }
    
    function do_upload() {
        
        $config['upload_path'] = $this->config->item('badge_url');
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = true;
        //$config['max_size']	= '100';
        //$config['max_width']  = '1024';
        //$config['max_height']  = '768';

        $this->load->library('upload', $config);

        $data = array();
        
        if ( ! $this->upload->do_upload('arquivo')) {
                $data = array('error' => $this->upload->display_errors());
        }
        else {
            $data = $this->upload->data();
            
            $config['image_library'] = 'gd2';
            $config['source_image']  = $data['full_path'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']	= 50;
            $config['height']	= 50;
            //apt-get install php5-gd
            $this->load->library('image_lib', $config); 
            $this->image_lib->resize();
        }
        
        echo json_encode($data);
    }
    
    public function get_parametros_concessao($regra){
        
        $this->load->config('badge');
        
        $parametros = array();
        
        //Ao utilizar pela primeira vez determinada funcionalidade
        if($regra == 1){
            $parametros = $this->config->item('funcionalidades_regras_concessao_badge');
        }
        //Ao resolver pela primeira vez um problema de um determinado nível
        //Ao atingir o nível
        if($regra == 3 || $regra == 5){
            
            $this->load->model($this->config->item('admin') . 'nivel_model');
            
            $niveis = $this->nivel_model->get_all();
            
            foreach ($niveis as $nivel){
                $parametros[$nivel->id] = $nivel->descricao;
            }
            
        }
        //Ao resolver pela primeira vez um problema de uma determinada categoria
        if($regra == 4){
            
            $this->load->model($this->config->item('admin') . 'categoria_model');
            $parametros = $this->categoria_model->get_array_categorias();
        }
        
        //Ao resolver determinada quantidade de problemas
        if($regra == 2){
            $parametros = false;
        }
        
        echo json_encode($parametros);
    }
}

?>
