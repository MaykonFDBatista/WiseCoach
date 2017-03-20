<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * @package   helpers
 * @name      tk_string_helper
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     17/07/2013 
 * 
 */

/**
 * Recebe uma string e retorna uma sbstring com a quantidade e caracteres informados
 * por parametro
 * 
 * @name str_trim
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @since 17/07/2013
 * @param string $input string de entrada
 * @param int $qtd Quantidade de caracteres da substring retornada
 * @return void
 */
if (!function_exists('str_trim')) {

    function str_trim($input, $qtd = 12) {

        $p = explode(' ', $input);
        $c = 0;
        $substring = '';

        foreach ($p as $p1) {
            
            if($c < $qtd && ($c + strlen($p1) <= $qtd)) {
                
                $substring .= ' ' . $p1;
                $c += strlen($p1) + 1;
            } else {
                
                break;
            }
        }

        return strlen($substring) < $qtd ? $substring : $substring;
    }

}
