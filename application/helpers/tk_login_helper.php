<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Helpers de login e de verificacao do status do sistema (ativo, inativo)
 * 
 * @package   helpers
 * @name      tk_login_helper 
 * @author    Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br> 
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     13/12/2012
 */


/**
 * Grava na tabela de log de usuario que a sessao expirou
 *
 * @name   expirou_sessao
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @since  13/12/2012
 * @return void
 */
if ( ! function_exists('expirou_sessao')) {
    
	function expirou_sessao() {

            $CI = & get_instance();
            
            $CI->load->model($CI->config->item('admin') . 'log_model');
            
            $CI->log_model->remove_sessoes_expiradas();

	}
}

/**
 * Atualiza o log do usuario e a sessao
 *
 * @name   atualiza_last_activity
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @since  13/05/2013
 * @return void
 */
if ( ! function_exists('atualiza_last_activity')) {
    
	function atualiza_last_activity() {

            $CI = & get_instance();
            
            $CI->load->model($CI->config->item('admin') . 'log_model');
            
            $CI->session->sess_update();

            $last_activity = date('Y-m-d H:i:s', $CI->session->_get_time());

            $CI->log_model->update_last_activity($last_activity);

	}
}

/**
 * Autentica a sessao
 *
 * @name   autenticar_sessao
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @since  13/05/2013
 * @return boolean
 */
if ( ! function_exists('autenticar_sessao')) {
    
	function autenticar_sessao() {

            $CI = & get_instance();
            
            $CI->load->library('autenticacao_library');
            
            $autenticou = $CI->autenticacao_library->autenticar_sessao();
            
            // Se autenticou o usuario no banco
            if($autenticou){
                
                return TRUE;
            }
            else {
                
                $CI->load->model($CI->config->item('admin') . 'log_model');
            
                $dados['logout']        = date('Y-m-d H:i:s');
                $dados['last_activity'] = $dados['logout'];
                $dados['id']            = $CI->session->userdata('log_id');

                $CI->log_model->logout($dados);

                $CI->session->sess_destroy();
                
                return FALSE;
            }
	}
}


/**
 * Verifica se ha sessao ativa para o usuario
 *
 * @name  _login
 * @author Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>  
 * @since  13/12/2012
 * @return void
 */
if ( ! function_exists('_login')) {
	function _login() {

            $CI = & get_instance();
            
            _frontend_ativo();

            // Recebe o segmento da url corrente
            $uri = uri_string();
            
            if ($CI->session->userdata('login')){
                
                atualiza_last_activity();
                
                // Autentica o usuario no banco de dados
                $autenticou = autenticar_sessao();
                
                if (! $autenticou){
                    
                    redirect($CI->config->item('app') . $CI->config->item('login'));
                }
                else {
                    // Se o usuario esta logado e o segmento de url contiver a substring "login" realiza o 
                    // redirecionamento para o controlador default
                    if(substr_count($uri,'login') > 0){
                       
                        redirect($CI->config->item('app'));
                    }
               }
            }
            else{
                
                if ($CI->session->userdata('login_admin')){
                    
                    $CI->session->set_flashdata('msg','msg_logado_admin');
                    $CI->session->set_flashdata('tp','alert alert-info');
                    
                    redirect($CI->config->item('admin'));
                }
                else {
                    
                    // Se o segmento de url nao contiver a substring "login" realiza 
                    // o redirecionamento para a controladora de login
                    if(substr_count($uri,'login') <= 0){
                       
                        redirect($CI->config->item('app') . $CI->config->item('login'));
                    }
                }
            }

	}
}

/**
 * Verifica a sessao ativa do usuario logado na administracao
 *
 * @name   _login_admin
 * @author Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>  
 * @since  13/12/2012
 * @return void
 */
if ( ! function_exists('_login_admin')) {
    
	function _login_admin()	{
            
            $CI = & get_instance();
            
            _ativo();
            
            // Recebe o segmento da url
            $uri = uri_string();
            
            if ($CI->session->userdata('login_admin')){
   
                atualiza_last_activity(); 
                
                // Autentica o usuario no banco de dados
                $autenticou = autenticar_sessao();
                
                if (! $autenticou){
                    
                    redirect($CI->config->item('admin') . 'login');
                }
                else{
                    // Se o usuario esta logado e o segmento de url contiver a substring "login" realiza o 
                    // redirecionamento para o controlador default
                    if(substr_count($uri,'login') > 0){
                      
                         redirect($CI->config->item('admin') . $CI->router->default_controller);
                    }
                }
            }
            else{
                
                if ($CI->session->userdata('login')){
                    
                    $CI->session->set_flashdata('msg','msg_logado_app');
                    $CI->session->set_flashdata('tp','alert alert-info');
                    
                    redirect($CI->config->item('admin'));
                }
                else {
                                      
                    // Se o segmento de url nao contiver a substring "login" realiza 
                    // o redirecionamento para a controladora login
                    if(substr_count($uri,'login') <= 0){
                        
                        redirect($CI->config->item('admin') . $CI->config->item('login'));
                    }                    
                }
            }

	}
}

/**
 * Verifica se ha sessao ativa para o usuario
 *
 * @name  _login
 * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>  
 * @since  13/12/2012
 * @return boolean
 */
if ( ! function_exists('_login_app_ws')) {
	function _login_app_ws() {

            $CI = & get_instance();
            
            if ($CI->session->userdata('login')){
                
                atualiza_last_activity();
                
                // Autentica o usuario no banco de dados
                $autenticou = autenticar_sessao();
                
                if (! $autenticou){
                    
                    return false;
                }
                else {
                   return true;
               }
            }
            else{
                
                return false;
                
            }

	}
}

/**
 * Verifica se ha sessao ativa para o usuario
 *
 * @name  _login
 * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>  
 * @since  13/12/2012
 * @return boolean
 */
if ( ! function_exists('_login_ws')) {
	function _login_ws($login = true) {
            $CI = & get_instance();
            
            $id_usuario = $CI->session->userdata('id');
            
            if($login){
                if (empty($id_usuario)){
                    redirect(base_url('ws/login'));
                }
            }
            else{
                if (!empty($id_usuario)){
                    $redireciona = $CI->session->userdata('pagina_anterior_login');
                    if($redireciona == ''){
                        $redireciona = base_url('ws');
                    }
                    redirect($redireciona);
                }
            }
        }
}

/**
 * Verifica se o frontend do sistema esta ativo 
 *
 * @name   _frontend_ativo
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @since  28/06/2013
 * @return void 
 */
if ( ! function_exists('_frontend_ativo')) {
    function _frontend_ativo() {

        $CI = & get_instance();
        
        $CI->load->model($CI->config->item('admin') . 'sistema_model');
        
        $status = $CI->sistema_model->get_status();

        if (($status->ativo != 1) || ($status->frontend_ativo != 1) ){// || ($status->cond_ativo != 1)) {
            
            $is_super = _is_super_user();

            if (!$is_super) {

                redirect($CI->config->item('admin') . 'desativado');
            }
        }
    }

}

/**
 * Verifica se o sistema esta ativo.
 *
 * @name   _ativo
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @since  28/06/2013
 * @return void 
 */
if ( ! function_exists('_ativo'))
{
    function _ativo() {

        $CI = & get_instance();

        $CI->load->model($CI->config->item('admin') . 'sistema_model');
        
        $status = $CI->sistema_model->get_status();

        if (($status->ativo != 1)){

            $is_super = _is_super_user();

            if (!$is_super) {

                redirect($CI->config->item('admin') . 'desativado');
            }
        }
    }
}


/**
 * Verifica se o usuario logado pertence ao grupo de super usuario
 *
 * @name   _login_admin
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @since  28/06/2013
 * @return boolean  
 */
if ( ! function_exists('_is_super_user'))
{
	function _is_super_user() {
            
            $CI = & get_instance();
            
            $grupos = $CI->session->userdata('grupos');

            if (is_array($grupos)) {
                
                foreach ($grupos as $g) {

                    if ($g == $CI->config->item('super_users')) {

                        return TRUE;
                    }
                }
            }

            return FALSE;
	}
}

// ------------------------------------------------------------------------

/* End of file tk_login_helper.php */
/* Location: ./application/helpers/tk_login_helper.php */
