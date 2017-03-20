<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

class Perfil extends CI_Controller {
    
    /**
     * Método construtor
     * 
     * @name _construct
     * @author Alex Santini<alex.santini@tellks.com.br>
     * @since 20/01/2015
     * @param void
     * @return void
     */
    function __construct() {
        
        parent::__construct();
        
        _login_ws();
        
        $this->load->model(array(
            $this->config->item('ws') . 'website_model',
            $this->config->item('ws') . 'categoria_model',
            $this->config->item('ws') . 'materia_model',
            $this->config->item('ws') . 'competidor_model',
            $this->config->item('ws') . 'badge_model'
            ));
        
        $this->load->config('problema');
        $this->load->config('arquivo');
        $this->load->config('estilo_aprendizagem');
        
        // Carrega o helper de criptografia de senhas
        $this->load->helper('tk_joomla_encrypt_password');
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios', 'mensagens','estilo_aprendizagem'); 
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        
        $this->load->language($arquivos, $idioma);
    }
    
    /**
     * Carrega a view com os dados do competidor
     * 
     * @name index
     * @author Claudia dos Reis Silva <claudia.silva@tellks.com.br>
     * @since 04/08/2015
     * @param void
     * @return void
     */
    function index() {
        
        $competidor_id = $this->session->userdata('id');
        
        $dados = array();
        $dados['competidor'] = $this->competidor_model->get_by_id($competidor_id);
        $dados['competidor_categorias'] = $this->competidor_model->get_competidor_categorias($competidor_id);
        $dados['competidor_materias']   = $this->competidor_model->get_competidor_materias($competidor_id);
        $dados['competidor_estilos']    = $this->competidor_model->get_competidor_estilos($competidor_id);
        $dados['competidor_badges']     = $this->badge_model->get_all($competidor_id);
        
        $dados['idiomas']    = $this->config->item('sis_idiomas');
        $dados['website']    = $this->website_model->get_dados();
        $dados['categorias'] = $this->categoria_model->get_all();
        $dados['materias']   = $this->materia_model->get_all();
        
        $dados['url'] = base_url($this->config->item('ws') . 'perfil/atualizar');

        //view a ser carregada
        $dados['conteudo'] = 'perfil/index';
        
        $dados['assets_js'][] = 'plugins/peity-master/jquery.peity.min.js';
        $dados['assets_js'][] = 'plugins/icheck/icheck.min.js';
        $dados['assets_js'][] = 'plugins/d3-master/d3.min.js';
        $dados['assets_js'][] = 'validacao/perfil_ws.js';
        $dados['assets_js'][] = 'ajax/perfil_ws.js';
        
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }
    
     /**
     * Edita dados do competidor
     * 
     * @name atualizar
     * @author Claudia dos Reis Silva <claudia.silva@tellks.com.br>
     * @since 04/08/2015
     * @return boolean 
     */
    public function atualizar() {
        
        $foto = $this->do_upload();
        
        if($foto !== FALSE) {
            
            $dados = new stdClass();

            $dados->id = $this->input->post('com_id');

            $dados->nome = $this->input->post('com_nome');

            // Pega a senha informada pelo competidor
            $senha = $this->input->post('com_senha');

            if(($senha != null) && (!empty($senha))) {

                // Gera um salt randomico
                $salt = genRandomPassword(32);

                // Criptografa a senha informada com o salt gerado randomicamente
                $crypt = getCryptedPassword($senha, $salt);

                // Salva a senha criptorafada concatenada com o salt
                $dados->senha = $crypt . ':' . $salt;
            }
            
            if(($foto != null) && ($foto != '')){
                $dados->foto = $foto;
            }

            $dados->telefone = $this->input->post('com_telefone');
            $dados->celular  = $this->input->post('com_celular');
            $dados->email    = $this->input->post('com_email');
            $dados->idioma   = $this->input->post('com_idioma');

            $categorias = $this->input->post('com_categorias');
            $materias = $this->input->post('com_materias');

            $resultado = $this->competidor_model->update($dados, $categorias, $materias);
            
            // Seta uma sessão com o resultado do Update ( True ou False )
            if ((bool)$resultado == TRUE) {

                $this->session->set_flashdata('msg', 'msg_update-ok');
                $this->session->set_flashdata('email', $dados->email);
            } else {

                $this->session->set_flashdata('msg', 'msg_error');
            }

            $this->session->set_userdata('idioma', $dados->idioma);
        }
        
        // Redireciona
        redirect($this->config->item('ws') . 'perfil', 'refresh');

    }
    
    private function do_upload() {
        
        $foto = '';
                
        // Se o usuario enviou uma foto
        if($_FILES['foto']['name'] != '') {

            $this->load->config('arquivo');
            $this->load->config('imagem');

            $novo_nome = $this->session->userdata('id') . substr($_FILES['foto']['name'] , -4);
                    
            $config = $this->config->item('imagem');

            $config['upload_path']  = $this->config->item('competidor_url');
            $config['file_name']    = $novo_nome;
            $config['overwrite']    = TRUE;
            $config['encrypt_name'] = FALSE;
            
            $this->load->library('upload', $config);

            // Se o upload foi realizado
            if($this->upload->do_upload('foto')) {

                $foto = $this->upload->data();

                // Redimensiona a imagem
                _redimensionar($config['upload_path'] . $foto['file_name'], 150, 150, FALSE);

                $foto = $novo_nome;

            }
            else {

                $this->session->set_flashdata('msg', strip_tags($this->upload->display_errors()));
                $this->session->set_flashdata('tp', 'alert alert-error');

                $foto = FALSE;
            }
        }
        
        return $foto;
    }
}