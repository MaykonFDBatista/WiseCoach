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
class autenticacao_library_ws {
    
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
        
        $CI->load->model($CI->config->item('ws') . 'autenticacao_model');
        
        $usuario = $CI->autenticacao_model->get_by_email($email,'');
        // Se ha algum usuario cadastrado com o email fornecido
        if($usuario) {
            
            $assunto = $CI->config->item('sis_nome') . ' | ' . _lang('msg_redefinir_senha_titulo');
            
            // mensagem contem apenas o link de redefinicao de senha
            $mensagem = anchor(base_url($CI->config->item('ws') . 'login/requisitar_nova_senha/' . md5($usuario->row(0)->senha)));
            
            $destinatario = array('usuario' => $usuario->row(0)->nome,'email' => $email);
            
            $resultado = $this->enviar_email($destinatario,$assunto,$mensagem,$CI->config->item('ws') . 'login/email_redefinir_senha');
            
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
       
        $CI->load->model($CI->config->item('ws') . 'autenticacao_model');
        
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
        
        $CI->load->model($CI->config->item('ws') . 'autenticacao_model');
        
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