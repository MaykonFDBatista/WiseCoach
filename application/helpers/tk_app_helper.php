<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Retorna o idioma do usuario logado
 * 
 * @name   _idioma
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @since  19/03/2014
 * @return string
 */
if (!function_exists('_idioma')) {

    function _idioma() {

        $CI = &get_instance();

        $idioma = $CI->session->userdata('idioma');
        
        // Verifica se o valor de app nao e vazio
        if($idioma != ''){
            
            return $idioma;
        } else{
            
            return 'pt-BR';
        }
    }

}

/**
 * Retorna o id da instancia da aplicacao que o usuario logado tem acesso
 * 
 * @name   _app_id
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @since  11/10/2013
 * @return int
 */
if (!function_exists('_app_id')) {

    function _app_id() {

        $CI = &get_instance();

        $app = $CI->session->userdata('app');
        
        // Verifica se o valor de app nao e vazio
        if($app != ''){
            
            return $app;
        } else{
            
            return 0;
        }
    }

}

/**
 * Retorna o caminho para os arquivos do condominio
 * 
 * @name   _arquivos
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @since  26/08/2013
 * @return string
 * 
 */
if (!function_exists('_arquivos')) {

    function _arquivos() {

        $CI = & get_instance();
        
        return $CI->config->item('url_arquivos_app') . _app_id() . '/';
    }

}

/**
 * Retorna o caminho para as imagens da galeria de um app
 * 
 * @name   _galeria
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @since  19/11/2013
 * @return string
 * 
 */
if (!function_exists('_galeria')) {

    function _galeria() {

        $CI = & get_instance();
        
        return $CI->config->item('url_arquivos_app') . _app_id() . '/' . $CI->config->item('url_imagens_app') . 'galeria/';
    }

}

/**
 * Retorna o id do app a ser usado
 * 
 * @name   _arquivos
 * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
 * @since  04/09/2014
 * @return int
 * 
 */
if (!function_exists('_app_ws_id')) {

    function _app_ws_id() {

        $CI = & get_instance();
        
        return (int)$CI->config->item('app_ws_id');;
    }

}

/* End of file tk_app_helper.php */
/* Location: ./application/helpers/tk_app_helper.php */