<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * Controller inicial da administracao da aplicacao
 * 
 * @package Controllers/adm
 * @name Index
 * @author Maykon Filipe Dacioli Batista<maykon.batista@tellks.com.br>
 * @copyright Copyright (c) 2015, Tellks - Solucoes em tecnologia ltda
 * @since 20/01/2015
 * 
 */

class Login extends CI_Controller {
    
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
        
        $this->session->set_userdata('pagina_anterior', current_url()); 
        
        _login_ws(false);
        
        $this->load->model(array(
            $this->config->item('ws') . 'website_model',
            $this->config->item('ws') . 'competidor_model'));
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios', 'mensagens'); 
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        
        $this->load->language($arquivos, $idioma);
    }
    
    /**
     * Carrega os dados do site
     * 
     * @name index
     * @author Maykon Filipe Dacioli Batista<maykon.batista@tellks.com.br>
     * @since 20/01/2015
     * @param void
     * @return void
     */
    function index() {
        
        $dados = array();
        $dados['website']    = $this->website_model->get_dados();
        
        $dados['url'] = 'login/autenticar';

        //view a ser carregada
        $dados['conteudo'] = 'login/index';
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }
    
    public function autenticar() {
        
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');
        
        $competidor = $this->competidor_model->get_by_email($email);
        
        if($competidor) {
            
            // Carrega o helper que criptografa a senha
            $this->load->helper('tk_joomla_encrypt_password');
            
            // Separa a senha e o salt
            $parts = explode(':', $competidor->senha);
            $senha_banco_crypt = $parts[0];
            $salt = $parts[1];
            
            //Criptografa a senha informada pelo usuario com o salt obtido no banco
            $senha_informada_crypt = getCryptedPassword($senha, $salt);

            // Se a senha informada depois de criptografada for igual a senha criptografada no banco
            // o usuario deve ser autenticado
            if ($senha_banco_crypt == $senha_informada_crypt) {
                
                $this->salva_dados_sessao($competidor);
                
                // Redireciona
                $redireciona = $this->session->userdata('pagina_anterior_login');
                if($redireciona == ''){
                    $redireciona = base_url('ws');
                }
                    
                redirect($redireciona, 'refresh');
            }
            else {
                $this->session->set_flashdata('msg', 'msg_senha_incorreta');
                $this->session->set_flashdata('email', $email);
            }
            
        }
        else {
            $this->session->set_flashdata('msg', 'msg_email_incorreto');
            $this->session->set_flashdata('email', $email);
        }
        
        // Redireciona
        redirect($this->config->item('ws') . 'login', 'refresh');
    }
    
    private function salva_dados_sessao($competidor){
        
        $this->session->set_userdata(array(
            'id'     => $competidor->id,
            'nome'   => $competidor->nome,
            'email'  => $competidor->email,
            'idioma' => $competidor->idioma
        ));
        
    }

}