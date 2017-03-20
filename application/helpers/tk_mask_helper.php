<?php


function tem_pv($string){
    for($i=0; $i<strlen($string); $i++){
        if($string[$i] == ',' || $string[$i] == '.'){
            return TRUE;
        }
    }
    return false;
}

/**
 * 
 * Set_moeda
 * 
 * @param string $string
 * @param type $int
 * @param type $int
 * @return string
 */
if (!function_exists('set_moeda')) {

    function set_moeda($string) {

        return number_format($string, 2, ',', '.');
    }

}

