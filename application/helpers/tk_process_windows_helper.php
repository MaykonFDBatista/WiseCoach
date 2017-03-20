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
    function PsExecute($script, $timeout = 10, $sleep = 1) { 
        // First, execute the process, get the process ID 
        
        $pid = PsExec($script); 
        
        if( $pid === false ) 
            return false;         

        $cur = 0; 
        // Second, loop for $timeout seconds checking if process is running 
        while( $cur < $timeout ) { 
            sleep($sleep);
            $cur += $sleep; 
            // If process is no longer running, return true; 

            if( !PsExists($pid) ) 
                return true; // Process must have exited, success! 

        } 
        
        // If process is still running after timeout, kill the process and return false 
        PsKill($pid); 
        return false; 
    } 
}

if (!function_exists('PsExec')) {
    function PsExec($script) { 
                
        exec("psexec -d ".$script." 2>&1", $output, $pid);
        
        if(!isset ($pid)){
            $pid = "";
        }
      
//        $pid = "";
//        
//        if(isset($output[5])){
//            preg_match('/ID (\d+)/', $output[5], $matches);
//            if(isset($matches[1])){
//                $pid = $matches[1];
//            }
//        }
        
        if($pid!="") return $pid; 

        return false; 
        
    } 
}

if (!function_exists('PsExists')) {
    function PsExists($pid) { 
        
        exec("tasklist | find \"$pid\" 2>&1", $output, $matches); 
        
        while( list(,$row) = each($output) ) {
            
            $check_pid = 0;
            
            preg_match('/(\d+)/', $row, $matches);
            
            if(isset($matches[0])){
                $check_pid = $matches[0];
            }

            if($pid == $check_pid) { 
                    return true; 
            } 

        }

        return false; 
    } 
}
    
if (!function_exists('PsKill')) {

    function PsKill($pid) { 
        exec("taskkill /PID $pid", $output); 
    } 
}
    