<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


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
 * @return bool
 */
if (!function_exists('enviar_email')) {

    function enviar_email($email_to = NULL, $email_titulo = NULL, $mensagem = '') {

        $CI = &get_instance();

        // Se o destinatario ou layout do email nao foram informados aborata a operacao
        if (empty($email_to)) {
            return FALSE;
        }

        // Carrega as configuracoes de envio e a library que realiza a operacao
        $CI->load->config('email');
        $CI->load->library('email');

        // Busca no config os dados do remetente
        $remetente = $CI->config->item('email_from');

        // Seta os dados do envio
        $CI->email->from($remetente['email'], $remetente['nome']);
        $CI->email->to($email_to['email']);
        $CI->email->subject($email_titulo);
        $CI->email->message($mensagem);

        // Realiza o envio e retorna o resultado
        return $CI->email->send();
    }

}

/* End of file tk_email_helper.php */
/* Location: ./application/helpers/tk_email_helper.php */