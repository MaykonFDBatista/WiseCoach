<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * Controller responsável por exibir a página de acesso negado
 * 
 * @package Controllers/adm
 * @name Acesso_negado
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Acesso_negado extends CI_Controller {
    
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
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('mensagens'); 
        
        $this->load->language($arquivos, $this->session->userdata('idioma'));
    }
    
    /**
     * Redireciona para o metodo acesso_negado
     * 
     * @name index
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function index() {
        
        $this->mensagem();
    }
    
    /**
     * Método que exibe a view de acesso negado
     * 
     * @name acesso_negado
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function mensagem($msg = FALSE) {
        
        if($msg) $data['msg'] = $msg;
        
        $data['menu'] = $this->menu_library->menu_admin();
        $data['titulo'] = _lang('msg_acesso_negado_titulo');
        $data['conteudo'] = 'adm/content/acesso_negado';
       
        $this->load->view($this->config->item('tpl_admin'), $data);
    }
    
}
