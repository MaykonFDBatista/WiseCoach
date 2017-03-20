<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Verifica se um grupo de usuario pode acessar uma funcionalidade
 *
 * @name   _access
 * @author Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>  
 * @since  13/12/2012
 * @return void
 */
if ( ! function_exists('_access'))
{
	function _access($id_funcionalidade)
	{

            $CI = & get_instance();
            
            $CI->load->model($CI->config->item('app') . 'funcionalidade_model');
            
            $tem_acesso = $CI->funcionalidade_model->tem_acesso($id_funcionalidade, $CI->session->userdata('grupos'), $CI->session->userdata('app'));
            
            if(!$tem_acesso){
                
                 redirect($CI->config->item('app') . 'acesso_negado');
            }
            
	}
}

/**
 * Verifica se um grupo de usuario pode acessar uma funcionalidade na area administrativa
 *
 * @name   _access_admin
 * @author Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>  
 * @since  13/12/2012
 * @return void
 */
if ( ! function_exists('_access_admin'))
{
	function _access_admin($id_funcionalidade)
	{
            $CI = & get_instance();
            
            $CI->load->model($CI->config->item('admin') . 'funcionalidade_model');
            
            $tem_acesso = $CI->funcionalidade_model->tem_acesso($id_funcionalidade, $CI->session->userdata('grupos'));
            
            if(!$tem_acesso){
                redirect($CI->config->item('admin') . 'acesso_negado');
            }
            
	}
}

/**
 * Verifica se um usuario se encontra bloqueado
 *
 * @name   _bloqueado
 * @author Joao Claudio Dias Araujo <joao.raujo@tellks.com.br>  
 * @since  24/07/2013
 */
if (!function_exists('_bloqueado')) {

    function _bloqueado($acesso = 'frontend') {
        
        $CI = & get_instance();

        $CI->load->model('usuario_model');

        $usu = $CI->usuario_model->get_by_id($CI->session->userdata('usuario_id'));

        if ($usu->ativo == '2') {
            
            $msg = (($acesso = 'frontend')?'f_block':'');
            
            redirect('acesso_negado/mensagem/' . $msg);
        }
    }

}


?>
