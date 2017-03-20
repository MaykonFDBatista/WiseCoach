<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Realiza a autenticacao de um usuario
 * 
 * @package   libraries
 * @name      autenticacao_library
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     23/09/2013
 * 
 */
class autenticacao_library {
    
    /**
     * Metodo construtor
     * 
     * @name   __construct
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  22/09/2013
     * @param  void
     * @return void
     */
    function __construct() {}
    
    /**
     * Autentica um usuario no banco de dados
     * 
     * @name   autenticar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  22/09/2013
     * @param  string $email email do usuario    
     * @param  string $senha senha informada usuario
     * @param  string $acesso acesso desejado
     * @return boolean / array Se encontrou o usuario retorna um array com seus dados
     *  Caso contrario retorna False
     */
    function autenticar($email, $senha){
        
        $CI = & get_instance();
        
        $CI->load->model($CI->config->item('admin') . 'autenticacao_model');
        
        $autenticacao = $CI->autenticacao_model->autenticar($email);

        // Se encontrou o usuario
        if ($autenticacao) {
            
            // Carrega o helper que criptografa a senha
            $CI->load->helper('tk_joomla_encrypt_password');
            
            // Separa a senha e o salt
            $parts = explode(':', $autenticacao->row(0)->senha);
            $senha_banco_crypt = $parts[0];
            $salt = @$parts[1];
            
            //Criptografa a senha informada pelo usuario com o salt obtido no banco
            $senha_informada_crypt = getCryptedPassword($senha, $salt);

            // Se a senha informada depois de criptografada for igual a senha criptografada no banco
            // o usuario deve ser autenticado
            if ($senha_banco_crypt == $senha_informada_crypt) {
                
                // Seta o valor do userdata
                $this->set_logado($autenticacao);
                return TRUE;
            }
        }
        $tentativas_login = $CI->session->userdata('tentativas');
        $tentativas_login += 1;
        $CI->session->set_userdata('tentativas',$tentativas_login);
        // Retorno default da funcao
        return FALSE;
    }
    
    /**
     * Autentica uma sessao no banco de dados com base no usuario e senha gravados
     * na sessao
     * 
     * @name   autenticar_sessao
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  08/10/2013
     * @return boolean
     */
    function autenticar_sessao(){
        
        $CI = & get_instance();
        
        $CI->load->model($CI->config->item('admin') . 'autenticacao_model');
        
        $autenticacao = $CI->autenticacao_model->get_by_usuario_id($CI->session->userdata('usuario_id'));
        
        // Se encontrou o usuario
        if ($autenticacao) {
            
            // Separa a senha e o salt
            $parts = explode(':', $autenticacao->row(0)->senha);
            $senha_banco_crypt = $parts[0];
            
            // Se a senha presente na sessao for igual a senha criptografada no banco
            // o usuario e autenticado
            if ($senha_banco_crypt == $CI->session->userdata('senha')) {
                
                return TRUE;
            }
        }
        
        return FALSE;
    }
    /**
     * Retorna a quantidade de tentativas de login
     * 
     * @name   get_n_tentativas
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  22/09/2013
     * @return int
     */
    function get_n_tentativas() {
        
        $CI = &get_instance();
        
        $n = $CI->session->userdata('tentativas');
        // Se a qtd de tentativas estiver vazia retorna 0 senao retorna a qtd de tentativas
        return ($n == '')? 0 : $n;
    }
    
    /**
     * Inicializa o userdata setando a sessao como sendo de um usuario logado
     * 
     * @name   set_logado
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  22/09/2013
     * @param  Object Mysql $usuario Objeto Mysql retornado pelo banco com os dados do usuario
     * @param string $acesso permitido ao usuario
     * @return void
     */
    function set_logado($usuario) {
        
        $CI = & get_instance();
        
        $grupos = array();

        // Inicializa o contador de grupos
        $i = 0;

        foreach ($usuario->result() as $aux) {

            $grupos[$i] = $aux->grupo_id;

            $i++;
        }

        //Salva dados na tabela de log
        $CI->load->model($CI->config->item('admin') . 'log_model');
      
        $dados['login']         = date('Y-m-d H:i:s', $CI->session->_get_time());
        $dados['last_activity'] = $dados['login'];
        $dados['usuario_id']    = $usuario->row(0)->id;
        $dados['ip_address']    = $CI->session->userdata['ip_address'];
        $dados['user_agent']    = $CI->session->userdata['user_agent'];

        $CI->log_model->login($dados);
        $log = $CI->log_model->get_by_login($dados['usuario_id'], $dados['login']);

        //Grava informações da autenticação do usuário na sessão

        $nome = explode(' ', $usuario->row(0)->nome);

        // Separa a senha e o salt para salvar a senha na sessao
        $parts = explode(':', $usuario->row(0)->senha);
        $senha_banco_crypt = $parts[0];
        
        $CI->session->set_userdata(array(
            // seta o acesso permitido
            'login_admin'     => true,
            'usuario'         => $nome[0],
            'usuario_id'      => $usuario->row(0)->id,
            'senha'           => $senha_banco_crypt,
            'idioma'          => $usuario->row(0)->idioma,
            'app'             => $usuario->row(0)->app_id,
            'grupos'          => $grupos,
            'log_id'          => $log->id
        ));
    }
    
    /**
     * Envia para o usuario um email com um link para redefinicao da senha
     * 
     * @name   redefinicao_senha
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  22/09/2013
     * @param  string $email Email do usuario que solicitou a redefinicao da senha
     * @return boolean
     */
    function redefinicao_senha($email) {
        
        $CI = &get_instance();
        
        $CI->load->model($CI->config->item('admin') . 'autenticacao_model');
        
        $usuario = $CI->autenticacao_model->get_by_email($email,'');
        // Se ha algum usuario cadastrado com o email fornecido
        if($usuario) {
            
            $assunto = $CI->config->item('sis_nome') . ' | ' . _lang('msg_redefinir_senha_titulo');
            
            // mensagem contem apenas o link de redefinicao de senha
            $mensagem = anchor(base_url($CI->config->item('admin') . 'login/requisitar_nova_senha/' . md5($usuario->row(0)->senha)));
            
            $destinatario = array('usuario' => $usuario->row(0)->nome,'email' => $email);
            
            $resultado = $this->enviar_email($destinatario,$assunto,$mensagem,$CI->config->item('admin') . 'content/email_redefinir_senha');
            
            // Se enviou o email seta o tempo que o usuario tem para redefinir a senha usando o token enviado
            if($resultado) {
                
                // Inicializa a contagem do tempo de validade do token de redefinicao de senha
                $CI->autenticacao_model->seta_tempo_redefinir_senha($email,  date('Y-m-d H:m:s'));
                
                return TRUE;
            }
            
            return NULL;
        }
        else {
            
            return FALSE;
        }
    }

    /**
     * Envia um email para o usuario informado
     * 
     * @name   enviar_email
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  22/09/2013
     * @param  string $email_to Email do usuario que solicitou a redefinicao da senha
     * @param  string $assunto Assunto do email
     * @param  string $mensagem Mensagem do email
     * @param  string $template Layout do email
     * @return boolean
     */
    function enviar_email($email_to = NULL, $email_titulo = NULL, $mensagem = '', $template = NULL) {
        
        $CI = &get_instance();
        
        //Formata a mensagem no template do email
        $message = $CI->load->view($template, array('usuario' => $email_to, 'msg' => $mensagem), TRUE);
        
        // Carrega o helper responsavel pelo envio do email
        $CI->load->helper('tk_email');
        
        // Realiza o envio e recebe o resultado da operacao
        $resultado = enviar_email($email_to, $email_titulo, $message);

        return $resultado;
    }
    
    /**
     * Busca um usuario pelo email
     * 
     * @name   get_by_token
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
     * @since  24/09/2013
     * @param  string $token de redefinicao de senha
     * @return Object Qdo encontra algum registro retorna um objeto com os dados do usuario
     * @return boolean Quando nao encontra nenhum registro
     */
    function get_by_token($token = NULL) {
        
        $CI = &get_instance();
       
        $CI->load->model($CI->config->item('admin') . 'autenticacao_model');
        
        return $CI->autenticacao_model->get_by_token($token);
    }
    
    /**
     * Salva a alteracao de senha do usuario
     * 
     * @name   salva_nova_senha
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  25/09/2013
     * @param  string $token Token de redefinicao de senha
     * @param  string $nova_senha Nova senha
     * @return boolean
     */
    function salvar_nova_senha($token = NULL, $nova_senha = NULL) {
        
        $CI = &get_instance();
        
        // Carrega o helper que criptografa a senha
        $CI->load->helper('tk_joomla_encrypt_password');
        
        $CI->load->model($CI->config->item('admin') . 'autenticacao_model');
        
        // Gera um salt randomico
        $salt = genRandomPassword(32);
        
        // Criptografa a senha informada com o salt gerado randomicamente
        $crypt = getCryptedPassword($nova_senha, $salt);
        
        // Concatenada a senha criptorafada com o salt
        $nova_senha = $crypt . ':' . $salt;

        $resultado = $CI->autenticacao_model->salvar_nova_senha($token, $nova_senha);
        
        return $resultado;
    }
}