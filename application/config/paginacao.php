<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Configuracao da paginacao
|--------------------------------------------------------------------------
*/
$config['uri_segment'] = 4;
$config['first_link'] = 'Primeira';
$config['last_link'] = 'Última';
$config['prev_link'] = '<';
$config['next_link'] = '>';
$config['full_tag_open'] ='';
$config['full_tag_close'] = '';
$config['per_page'] = 10;

$config['paginacao']['full_tag_open']   = '<div class="pagination" style="text-align: center;"><ul>';
$config['paginacao']['full_tag_close']  = '</ul></div>';
$config['paginacao']['first_link']      = '<i class="icon-angle-left"></i>';
$config['paginacao']['first_tag_open']  = '<li>';
$config['paginacao']['first_tag_close'] = '</li>';
$config['paginacao']['last_link']       = '<i class="icon-angle-right"></i>';
$config['paginacao']['last_tag_open']   = '<li>';
$config['paginacao']['last_tag_close']  = '</li>';
//$config['next_link'] = '&gt;';
$config['paginacao']['next_tag_open']   = '<li>';
$config['paginacao']['next_tag_close']  = '</li>';
//$config['prev_link'] = '&lt;';
$config['paginacao']['prev_tag_open']   = '<li>';
$config['paginacao']['prev_tag_close']  = '</li>';

$config['paginacao']['cur_tag_open']    = '<li class="active"> <a>';
$config['paginacao']['cur_tag_close']   = '</a></li>';

$config['paginacao']['num_tag_open']    = '<li>';
$config['paginacao']['num_tag_close']   = '</li>';

?>
