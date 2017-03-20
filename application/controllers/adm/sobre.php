<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * Controller ajuda para o usuario da aplicacao
 * 
 * @package Controllers/adm
 * @name Sobre
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Sobre extends CI_Controller {
    
    /**
     * Método construtor
     * 
     * @name _construct
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function __construct() {
        
        parent::__construct();
        _login_admin();
    }
    
    /** 
     * Redireciona para o método sobre
     * 
     * @name index
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function index() {
        
        $this->sobre();
    }
    
    /** 
     * Exibe a view com as informações sobre o sistema
     * 
     * @name sobre
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function sobre() {
        
        _access_admin(14);
        $fnd = $this->menu->get_by_id(14);
        
        $data['menu']     = $this->menu_library->menu_admin();
        $data['titulo']   = $fnd->fnd_nome;
        $data['conteudo'] = $this->config->item('admin') . $fnd->fnd_url;   
        
        $this->load->view($this->config->item('tpl_admin'), $data);
    }
    
    /**
     * Método que redireciona para o site da Tellks
     * 
     * @name site_desenvolvedor
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function site_desenvolvedor() {
        
        redirect('http://tellks.com.br');
    }
    
}