<?php

if (!defined('BASEPATH'))
    exit('Sem permissao de acesso direto ao Script.');
/**
 * Helper com funcoes para criacao de tags html expandindo o helper nativo do framework
 * 
 * @package   application/helpers
 * @name      tk_html_helper
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     03/11/2013
 */

/**
 * Gera uma quebra de linha PHP no código fonte HTML (\n)
 *
 * @access	public
 * @param	integer
 * @return	string
 */
if ( ! function_exists('lnbreak'))
{
	function lnbreak($num = 1)
	{
            for($i=0; $i<$num; $i++) {
                echo "\n";
            }

	}
}

/**
 * Script tag
 *
 * Gera uma tag Script para um arquivo .js
 *
 * @access	public
 * @param	string	src
 * @param	string	type
 * @return	string
 */
if ( ! function_exists('script_tag'))
{
        function script_tag($src, $type = 'text/javascript', $index_page = FALSE) {

            $CI =& get_instance();
            
            if( $index_page === FALSE)
                $script = '<script src="' . $CI->config->slash_item('base_url') . $src . '" type="' . $type . '"></script>';
            else 
                $script = '<script src=" '.  $src . '"></script>';
            return $script;
            
        }   
}

