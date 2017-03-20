<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Retorna uma string corresponde a chave recebida por paramento no idioma corrente no sistema
 * Se recebeu um array por parametro realiza a traducao das chaves do array 
 *
 * @name   _lang
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>  
 * @since  10/10/2013
 * @param  string | array $string chave da strind a ser retornada ou array a ser traduzido
 * @return string | array
 */
if (!function_exists('_lang')) {

    function _lang($string) {

        $CI = & get_instance();

        $CI->load->helper('language');

        // Se foi recebido um array traduz o valor de cada posicao do array
        if (is_array($string)) {

            // itera sob as posicoes do array realizando a traducao
            foreach ($string as $key => $value) {

                $string[$key] = _lang($value);
            }
            
            return $string;
        } else {
            // Busca a string correspondente
            $resultado = lang($string);

            // Se encontrou retorna o resultado encontrado
            if ($resultado == '') {

                return $string;
            } else {
                // Caso nao encontre retorna a chave informada
                return $resultado;
            }
        }
    }

}
