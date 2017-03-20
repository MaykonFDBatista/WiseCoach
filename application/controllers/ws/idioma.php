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

class Idioma extends CI_Controller {
    
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

    }
    
    function alterar($idioma){

        $this->session->set_userdata('idioma', $idioma);
        
        // Redireciona
        $redireciona = $this->session->userdata('pagina_anterior');
        if($redireciona == ''){
            $redireciona = base_url('ws');
        }

        redirect($redireciona, 'refresh');
    }

}