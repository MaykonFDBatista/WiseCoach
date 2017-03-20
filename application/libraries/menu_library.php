<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright           Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Menu_Library
 *
 * @package	CodeIgniter
 * @subpackage	Libraries
 * @category	Parser
 * @author	Tellks - Solucoes em tecnologia LTDA
 * @link	http://tellks.com.br
 */
class Menu_Library {

    
    public function __construct() {
        
        $CI = &get_instance();
        
        // Carrega o arquivo de idioma do menu
        $CI->load->language('menu', $CI->session->userdata('idioma'));
    }

    /**
     * Monta dos os menus e itens de menu em Array
     * 
     * @method menu
     * @return Array
     * @access public
     */
    public function menu() {
        
        $CI = & get_instance();
        
        $data['menu'] = $CI->menu_model->get_menu($CI->session->userdata('grupos'));
        
        foreach($data['menu'] as $m) {       
           
             $data['item_menu'][$m->id] = $CI->menu_model->get_item_menu($CI->session->userdata('grupos'), $m->id);
        }
        
        return $data;
        
    }
    
    /**
     * Monta dos os menus e itens de menu da administracao em Array
     * 
     * @method menu_admin
     * @return Array
     * @access public
     */
    public function menu_admin() {
        
        $CI = & get_instance();
        
        $data['menu'] = $CI->menu_model->get_menu($CI->session->userdata('grupos'));
        
        foreach($data['menu'] as $m) {       
           
             $data['item_menu'][$m->id] = $CI->menu_model->get_item_menu($CI->session->userdata('grupos'), $m->id);
        }
        
        return $data;
        
    }

}
// END Menu Class

/* End of file Menu.php */
/* Location: ./application/libraries/Menu.php */