<?php

/**
 * 
 * DiffDate
 * 
 * @param type $data
 * @param type $data
 * @return array
 */
if (!function_exists('DiffDate')) {

    function DiffDate($begin, $end) {

        $date1 = new DateTime($begin);
        $date2 = new DateTime($end);

        $alt_diff['y'] = floor(abs($date1->format('U') - $date2->format('U')) / (60 * 60 * 24 * 365));
        $alt_diff['m'] = floor((floor(abs($date1->format('U') - $date2->format('U')) / (60 * 60 * 24)) - ($alt_diff['y'] * 365)) / 30);
        $alt_diff['d'] = floor(floor(abs($date1->format('U') - $date2->format('U')) / (60 * 60 * 24)) - ($alt_diff['y'] * 365) - ($alt_diff['m'] * 30));
        $alt_diff['h'] = floor(floor(abs($date1->format('U') - $date2->format('U')) / (60 * 60)) - ($alt_diff['y'] * 365 * 24) - ($alt_diff['m'] * 30 * 24 ) - ($alt_diff['d'] * 24));
        $alt_diff['mi'] = floor(floor(abs($date1->format('U') - $date2->format('U')) / (60)) - ($alt_diff['y'] * 365 * 24 * 60) - ($alt_diff['m'] * 30 * 24 * 60) - ($alt_diff['d'] * 24 * 60) - ($alt_diff['h'] * 60));
        $alt_diff['s'] = floor(floor(abs($date1->format('U') - $date2->format('U'))) - ($alt_diff['y'] * 365 * 24 * 60 * 60) - ($alt_diff['m'] * 30 * 24 * 60 * 60) - ($alt_diff['d'] * 24 * 60 * 60) - ($alt_diff['h'] * 60 * 60) - ($alt_diff['mi'] * 60));
        $alt_diff['invert'] = (($date1->format('U') - $date2->format('U')) > 0) ? 0 : 1;

        return $alt_diff;
    }

}

/**
 * 
 * valida_data
 * 
 * @param type $data
 * @param type $data
 * @return array
 */
if (!function_exists('valida_data')) {

    function valida_data($data) {
        $data = explode("/", $data); // fatia a string $dat em pedados, usando / como referência
        $d = $data[0];
        $m = $data[1];
        $y = $data[2];

        if (($d == '') || ($m == '') || ($y == ''))
            return FALSE;

        $res = checkdate($m, $d, $y);

        if ($res == 1) {

            return TRUE;
        } else {

            return FALSE;
        }
    }

}

/**
 * Recebe uma data e calcula o tempo decorrido da data ate agora
 * 
 * @name tempo_decorrido
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @since 28/04/2014
 * @param type $data No formato Y-m-d H:i:s
 * @return array
 */
if (!function_exists('tempo_decorrido')) {

    function tempo_decorrido($data) { 
        
        $data_atual = mktime();
        
        list($ano, $mes, $dia) = explode("-", $data);
        list($dia, $hora) = explode(" ", $dia);
        list($hora, $min, $seg) = explode(":", $hora);
        
        // transforma a data do banco em segundos
        $data_banco = mktime($hora, $min, $seg, $mes, $dia, $ano);

        // subtrai a data atual da data do banco em segundos
        $diferenca = $data_atual - $data_banco; 

        $minutos = $diferenca / 60;
        $horas   = $diferenca / 3600;
        $dias    = $diferenca / 86400;
        $semanas = $diferenca / 604800;
        $meses   = $diferenca / 2419200;
        
        // se a tiver passado de 0 a 60 segundos
        if ($minutos < 1) { 
            
            $diferenca = _lang('dt_ha_segundos');
            
            // se tiver passado de 1 a 60 minutos
        } elseif ($minutos > 1 && $horas < 1) { 
            
            // Verifica a mensagem deve ser no plurar
            if (floor($minutos) == 1 or floor($horas) == 1) {
                
                $s = '';
            } else {
                
                $s = 's';
            }
            $diferenca = _lang('dt_ha') . " " . floor($minutos) . " " . _lang("dt_minuto" . $s);
            
            // se tiver passado de 1 a 24 horas
        } elseif ($horas <= 24) { 
            
            // plural ou singular de hora   
            if (floor($horas) == 1) {
                $s = '';
            } else {
                $s = 's';
            } 
            
            $diferenca = _lang('dt_ha') . " " . floor($horas) . " " . _lang("dt_hora" . $s);
            
        }// se tiver passado um dia  
        elseif ($dias <= 2) { 
            
            $diferenca = _lang('dt_ontem');
            
        }// se tiver passado 6 dias  
        elseif ($dias <= 7) { 
            
            $diferenca = _lang('dt_ha') . " " . floor($dias) . " " . _lang('dt_dias');
            
        }// se tiver passado uma semana (7 dias)
        elseif ($dias <= 8) { 
            
            $diferenca = _lang('dt_ha_uma_semana');
        }
//        elseif($semanas <= 3) {
//            
//            $diferenca = _lang('dt_ha') . " " . floor($semanas) . " " . _lang('dt_semanas');
//        }
//        elseif ($semanas <= 2) {
//            
//            $diferenca = _lang('dt_ha_um_mes');
//        }
//        elseif($meses <= 11) {
//            
//            $diferenca = _lang('dt_ha') . " " . floor($meses) . " " . _lang('dt_meses');
//        }
        else {
            
            $diferenca = _lang('dt_em') . ' ' . date("d/m/Y", $data_banco);
        }

        return $diferenca;
    }

}

/**
 * Recebe uma data e formata ela no formato do banco sem hora e minuto
 * @name formata_data
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @since 07/05/2014
 * @param type $data
 * @return string
 */
if (!function_exists('formata_data')) {

    function formata_data($data) {
        
        $data = DateTime::createFromFormat('!' . str_replace('/', '-', _lang('formato_data')), str_replace('/', '-', $data));
            
        return $data->format('Y-m-d');
    }
}

    //Returns the difference, in seconds, between two datetime objects including
    //the microseconds:
if (!function_exists('mdiff')) {
    function mdiff($date1, $date2){
        //Absolute val of Date 1 in seconds from  (EPOCH Time) - Date 2 in seconds from (EPOCH Time)
        $diff = abs(strtotime($date1->format('d-m-Y H:i:s.u'))-strtotime($date2->format('d-m-Y H:i:s.u')));

        //Creates variables for the microseconds of date1 and date2
        $micro1 = $date1->format("u");
        $micro2 = $date2->format("u");

        //Absolute difference between these micro seconds:
        
        if($micro2 >= $micro1){
            $micro = $micro2 - $micro1;
        }
        else{
            $micro1 = 1000000 - $micro1;
            $micro1 = $micro1 % 1000000;
            $micro = $micro2 + $micro1;
            $diff--;
        }

        //Creates the variable that will hold the seconds (?):
        $difference = $diff.".".$micro;

        return $difference;
    }
}