<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * Controller inicial da administracao da aplicacao
 * 
 * @package Controllers/adm
 * @name Index
 * @author Maykon Filipe Dacioli Batista<maykon.batista@tellks.com.br>
 * @copyright Copyright (c) 2015, Tellks - Solucoes em tecnologia ltda
 * @since 20/01/2015
 * 
 */

class Logout extends CI_Controller {
    
    /**
     * Método construtor
     * 
     * @name _construct
     * @author Alex Santini<alex.santini@tellks.com.br>
     * @since 20/01/2015
     * @param void
     * @return void
     */
    function __construct() {
        
        parent::__construct();
        
    }
    
    /**
     * Carrega os dados do site
     * 
     * @name index
     * @author Maykon Filipe Dacioli Batista<maykon.batista@tellks.com.br>
     * @since 20/01/2015
     * @param void
     * @return void
     */
    function index() {
        
        $this->logout();

    }
    
    function logout(){

        $this->session->unset_userdata(array(
            'id'    => '',
            'nome'  => '',
            'email' => ''
        ));
        
        $this->session->set_flashdata('msg', 'msg_logout-ok');

        $redireciona = base_url('ws/login');
        
        redirect($redireciona, 'refresh');
    }

}