<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('_pontos_competidor')) {
    
	function _pontos_competidor($competidor_id) {

            $CI = & get_instance();
            
            $CI->load->model($CI->config->item('ws') . 'competidor_model');
            
            return $CI->competidor_model->get_pontos($competidor_id);
        }       
}

