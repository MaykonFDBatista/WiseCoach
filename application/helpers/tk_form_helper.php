<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('_dropdown_list'))
{
    function _dropdown_list($array_objects,$key,$value,$op_default = true)
    {
        $result = array();

        foreach($array_objects as $object){
            $result[$object->$key] = $object->$value;
        }
        if($op_default){
            $result[''] = _lang('form_selecione');
        }
        
        return $result;
    }
}