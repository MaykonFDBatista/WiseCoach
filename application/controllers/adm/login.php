<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * Controller de Login da aplicacao
 * 
 * @package Controllers/adm
 * @name Login
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Login extends CI_Controller {
    
    /**
     * Método construtor
     * 
     * @name _construct
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function __construct() {

        parent::__construct();
        
        
        
        // Carrega a library de autenticacao e recaptcha
        $this->load->library(array('autenticacao_library','recaptcha'));
        
        $this->load->config('autenticacao');
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios','mensagens','my_form_validation'); 
        
        $this->load->language($arquivos);

        $form_login = array(
                array(
                    'field'     => 'email',
                    'label'     => 'Email',
                    'rules'     => 'required|trim|valid_email'
                ),

                array(
                    'field'     => 'senha',
                    'label'     => 'Senha',
                    'rules'     => 'required|trim|min_length[5]|callback_autenticar'
                )
        );

        $this->form_validation->set_rules($form_login);

        $this->form_validation->set_error_delimiters('<p class="login-msg">', '</p>');
    }

    /**
     * Método index
     * 
     * @name index
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function index() {
        
        // Verifica se o usuario ja esta logado. Caso ja esteja redireciona para o 
        // controlador default
        _login_admin();
        
        $this->load->model($this->config->item('admin') . 'sistema_model');

        $status = $this->sistema_model->get_status();

        if ($status->ativo == 1) {

            $data['titulo'] = 'Login';
            $data['url']    = $this->config->item('admin') . 'login/validacao';

            $this->load->view($this->config->item('admin') . 'login', $data);
        }
        else {
            
            redirect($this->config->item('admin') . 'desativado');
        }
    }

    /**
     * Verifica se as regras de validacao foram cumpridas
     * 
     * @name validacao
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function validacao() {

        $rules = $this->form_validation->run();

        //Se as regras nao foram cumpridas, carrega novamente o formulario
        if ($rules == FALSE) {

            // Se o limite de tentativas frustradas for ultrapassado exibe o recaptcha
            if($this->autenticacao_library->get_n_tentativas() >= $this->config->item('limite_tentativas')) {
                
                $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
            }
            $data['titulo'] = 'Login';
            $data['url']    = $this->config->item('admin') . 'login/validacao';
            
            $this->load->view($this->config->item('admin') . 'login', $data);
        } 
        else {
            //Senao redireciona para o controller padrao
            redirect($this->config->item('admin') . $this->config->item('fn_default'));
        }
    }

    /**
     * Instancia a model para consulta ao banco de dados
     * 
     * @name autenticar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param type $senha senha digitada pelo usuário em md5
     * @return boolean
     */
    function autenticar($senha = NULL) {
        
        $email = $this->input->post('email');
        
        // Se o limite de tentativas de login foi atingido e o usuario informou o captcha errado  
        if($this->autenticacao_library->get_n_tentativas()  >= $this->config->item('limite_tentativas')){
                
            // Verifica a resposta
            $this->recaptcha->recaptcha_check_answer();
            
            // Se a resposta for invalida nao autentica o usuario
            if( !$this->recaptcha->getIsValid()) {

                $this->form_validation->set_message('autenticar', _lang('captcha_incorreto'));

                return FALSE;
            }
        }
        
        // Usa a library de autenticacao para autenticar o usuario
        $autenticacao = $this->autenticacao_library->autenticar($email,$senha, 'adm');

        // Se usuario autenticado
        if ($autenticacao) {

            return TRUE;
        } else {

            $this->form_validation->set_message('autenticar', _lang('usuario_senha_incorreto'));
            return FALSE;
        }
    }
    
    /**
     * Permite o login do usuario mesmo com o sistema desativado
     * 
     * @name   login_offline
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  01/07/2013
     * @return void
     */
    function login_offline() {
        
        $this->load->model($this->config->item('admin') . 'sistema_model');
        
        $status = $this->sistema_model->get_status();
        
        if($status->ativo == 1) {
            
            redirect($this->config->item('admin') . 'login');
        }
        else {
            
            $data['titulo'] = 'Login';
            $data['url']    = $this->config->item('admin') . 'login/validacao';

            $this->load->view($this->config->item('admin') . 'login', $data);
        }
    }
    
    /**
     * Carrega a view de redefinicao de senha
     * 
     * @name   requisitar_nova_senha
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  25/09/2013
     * @return void
     */
    function requisitar_nova_senha($token = NULL) {
        
        // Se informou um token valido
        if($token != NULL){
            
            $usuario = $this->autenticacao_library->get_by_token($token);

            // Se nao encontrou o usuario a que o token se refere e o token ainda nao expirou
            if(!$usuario) {

                $this->session->set_flashdata('msg','msg_token-expirado');

                redirect($this->config->item('admin') . 'login/requisitar_nova_senha');
            }
            else {

                $data['usuario'] = $usuario;
                $data['token']   = $token;
                $data['titulo']  = 'Redefinição de senha';
                $data['url']     = $this->config->item('tpl_login') . '/redefinir_senha';

                $this->load->view($this->config->item('admin') . 'content/redefinicao_senha', $data);
            }
        }
        else {
            
            $data['titulo'] = 'Redefinição de senha';
            $data['url'] = '#';

            $this->load->view($this->config->item('admin') . 'content/redefinicao_senha', $data);
        }
    }
    
    /**
     * Carrega a view de redefinicao de senha
     * 
     * @name   redefinir_senha
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  25/09/2013
     * @return void
     */
    function redefinir_senha() {
                
        $nova_senha = $this->input->post('nova_senha');
        $conf_senha = $this->input->post('conf_senha');
        
        $token = $this->input->post('token');
        
        if (strlen($nova_senha) > 5){
            
            if ($nova_senha == $conf_senha){

                // Realiza a alteracao da senha do usuario
                $resultado = $this->autenticacao_library->salvar_nova_senha($token, $nova_senha);
                
                // Se obteve sucesso na alteracao
                if ($resultado) {

                    $this->session->set_flashdata('msg', 'msg_redefinir-senha-sucesso');
                    
                    redirect($this->config->item('admin') . 'login/requisitar_nova_senha');
                } else {

                    $this->session->set_flashdata('msg', 'msg_erro-banco');

                    redirect($this->config->item('admin') . 'login/requisitar_nova_senha/' . $token);
                }
            } else {

                $this->session->set_flashdata('msg', 'msg_senhas-diferentes');

                redirect($this->config->item('admin') . 'login/requisitar_nova_senha/' . $token);
            }
        } else {

            $this->session->set_flashdata('msg', 'msg_senha-min_len');

            redirect($this->config->item('admin') . 'login/requisitar_nova_senha/' . $token);
        }
    }
    
}