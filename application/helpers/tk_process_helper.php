<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * @package   application/helpers
 * @name      tk_folder_helper
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     24/07/2013
 * 
 */

if (!function_exists('PsExecute')) {
    function PsExecute($comando, $timeout = 10, $sleep = 1) { 
        // First, execute the process, get the process ID 
        
        $pid = PsExec($comando); 
        
        if( $pid === false ) 
            return false;         

        $cur = 0; 
        // Second, loop for $timeout seconds checking if process is running 
        while( $cur < $timeout ) { 
            sleep($sleep);
            $cur += $sleep; 
            // If process is no longer running, return true; 

            if( !PsExists($pid) ){
                return true; // Process must have exited, success! 
            }
                

        } 
        
        // If process is still running after timeout, kill the process and return false 
        PsKill($pid); 
        return false; 
        
    } 
}

if (!function_exists('PsExec')) {
    function PsExec($comando) { 
        
        exec($comando.' > /dev/null 2>&1 & echo $!', $output, $teste);

        $pid = (int)$output[0]; 

        if($pid!="") return $pid; 

        return false; 
        
    } 
}

if (!function_exists('PsExists')) {
    function PsExists($pid) { 
        
        exec("ps --no-headers -p $pid 2>&1", $output); 
        
        if(isset($output[0])){
            
            $output[0] = trim($output[0]);
            $output_array = explode(" ", $output[0]);
            $check_pid = $output_array[0];
            if($pid == $check_pid) { 
                return true; 
            } 

        }

        return false;        
    } 
}
    
if (!function_exists('PsKill')) {

    function PsKill($pid) { 
        exec("kill -9 $pid", $output); 
    } 
}
    