<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class objeto_aprendizagem extends MY_Controller {
    
   
    public function __construct() {
        
        parent::__construct('objeto_aprendizagem', 41, array('data','estilo_aprendizagem'));

        // Carrega o Model da aplicação
        $this->load->model($this->config->item('admin') . 'objeto_aprendizagem_model');
    }

   
    public function index() {
        
           // 'Delega' para o método all() logo abaixo
            $this->all();
    }

    public function all($apartir_de = 0) {
        
        $model = 'objeto_aprendizagem_model';
        $url = $this->config->item('admin') . $this->controller . '/all';
        
        $campos = array(
            'id'     => _lang('form_id'),
            'titulo'   => _lang('form_titulo')
        );
        
        $dados = array();
        $dados['filtro']   = parent::filtrar($model, $url, $campos, $apartir_de, $status = '', $campo_data = 'data',$tipos_status = false);
        
        $fnd = $this->menu_model->get_by_id($this->funcionalidade);
        
        parent::view($fnd->nome, $this->config->item('admin') . $fnd->url, $dados);
    }

    public function novo() {
       
        $this->load->model(array($this->config->item('admin') . 'linguagem_model',
                                 $this->config->item('admin') . 'pais_model',
                                 $this->config->item('admin') . 'tipo_objeto_aprendizagem_model',
                                ));
        
        $dados = array();
        
        $dados['linguagens']  = $this->linguagem_model->get_all();
        $dados['paises']      = $this->pais_model->get_all();
        $dados['tipos']       = $this->tipo_objeto_aprendizagem_model->get_all();
        $dados['formatos']    = array();
        
        $dados['url']          = $this->config->item('admin') . $this->controller . '/cadastrar';
        $dados['url_cancelar'] = $this->config->item('admin') . $this->controller;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/objeto_aprendizagem.js';        
        $dados['assets_js'][] = 'ajax/objeto_aprendizagem.js';   
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        $dados['template_js'][] = 'form/bootstrap-fileupload.min.js';
        $dados['template_js'][] = 'lib/select2/select2.min.js'; 
        $dados['template_js'][] = 'lib/select2/select2_locale_' . $this->session->userdata('idioma') . '.js';
        
        $titulo       = _lang('form_novo') . '&nbsp;' . _lang('menu_objeto_aprendizagem');
        $conteudo     = $this->config->item('admin') . $this->controller . '/editar';
        
        parent::view($titulo, $conteudo, $dados);
    }

    public function cadastrar() {
        
        $registro = $this->get_post();
        
        parent::cadastrar($registro);
    }
    
    public function editar($id) {
        
        $this->load->model(array($this->config->item('admin') . 'linguagem_model',
                                 $this->config->item('admin') . 'pais_model',
                                 $this->config->item('admin') . 'tipo_objeto_aprendizagem_model',
                                 $this->config->item('admin') . 'formato_objeto_aprendizagem_model'));
        
        $objeto_aprendizagem = $this->objeto_aprendizagem_model->get_by_id($id);
        
        $dados = array();
        
        $dados['linguagens']  = $this->linguagem_model->get_all();
        $dados['paises']      = $this->pais_model->get_all();
        $dados['tipos']       = $this->tipo_objeto_aprendizagem_model->get_all();
        $dados['formatos']    = $this->formato_objeto_aprendizagem_model->get_by_tipo_objeto_aprendizagem($objeto_aprendizagem->tipo_id);
        
        // Acessa o Model
        $dados['objeto_aprendizagem'] = $objeto_aprendizagem;
        $dados['url']          = $this->config->item('admin') . $this->controller . '/atualizar';
        $dados['url_cancelar'] = $this->config->item('admin') . $this->controller;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/objeto_aprendizagem.js';
        $dados['assets_js'][] = 'ajax/objeto_aprendizagem.js';  
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        $dados['template_js'][] = 'form/bootstrap-fileupload.min.js';
        $dados['template_js'][] = 'lib/select2/select2.min.js'; 
        $dados['template_js'][] = 'lib/select2/select2_locale_' . $this->session->userdata('idioma') . '.js';
        
        $titulo       = _lang('form_editar') . '&nbsp;' . _lang('menu_objeto_aprendizagem');
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
        $idioma = $this->input->post('linguagem') . '-' . $this->input->post('pais');
        
        $dados->autor           = $this->input->post('autor');
        $dados->editor          = $this->input->post('editor');
        $dados->colaborador     = $this->input->post('colaborador');
        $dados->cobertura       = $this->input->post('cobertura');
        $data                   = $this->input->post('data');
        if($data != '') {
            $d = DateTime::createFromFormat('!' . _lang('formato_data'), $data);
            $dados->data = $d->format('Y-m-d');
        }
        else {
            $dados->data = NULL;
        }
        $dados->descricao       = $this->input->post('descricao');
        $dados->direito_autoral = $this->input->post('direito_autoral');
        $dados->fonte           = $this->input->post('fonte');
        $formato = $this->input->post('formato');
        $dados->formato_id = ($formato > 0) ? $formato : NULL;
        $dados->cobertura       = $this->input->post('cobertura');
        $dados->relacao         = $this->input->post('relacao');
        $tipo = $this->input->post('tipo');
        $dados->tipo_id         = ($tipo > 0) ? $tipo : NULL;
        $dados->titulo          = $this->input->post('titulo');
        $dados->idioma          = ($idioma != '-' ? $idioma : '');
        $dados->identificador   = $this->input->post('identificador');
        $dados->materias        = explode(',', $this->input->post('materia'));
        $dados->estilos         = explode(',', $this->input->post('estilo_aprendizagem'));
        
        return $dados;
    }
    
    function do_upload()
    {
        $this->load->config('arquivo');
        
        $this->load->model(array($this->config->item('admin') . 'formato_objeto_aprendizagem_model',
            $this->config->item('admin') . 'estilo_aprendizagem_model'));
        
        $config['upload_path'] = $this->config->item('objeto_aprendizagem_url');
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
                $formato = $this->formato_objeto_aprendizagem_model->get_by_extensao_mime_type($data['file_ext'],$data['file_type']);
                if(isset($formato->id)) {
                    $estilos = $this->estilo_aprendizagem_model->get_by_tipo_objeto_aprendizagem($formato->tipo_objeto_aprendizagem_id);
                    $opcoes = array();
                    foreach ($estilos as $i => $e) {
                    
                        $opcoes[$i]['id'] = $e->estilo_aprendizagem_id;
                        $opcoes[$i]['text'] = _lang($e->nome);
                    }

                    $data['estilos_aprendizagem'] = $opcoes;
                    $data['tipo_objeto_aprendizagem'] = $formato->tipo_objeto_aprendizagem_id;
                    $data['formato_objeto_aprendizagem'] = $formato->id;
                }
        }
        
        echo json_encode($data);
    }
}

?>
