<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * Controller de Logout da aplicacao
 * 
 * @package Controllers/adm
 * @name Logout
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Logout extends CI_Controller {
    
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
    }
    
    /**
     * Redireciona para o método logout
     * 
     * @name index
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function index() {
        
        $this->logout();
    }
    
    /**
     * Efetua logout
     * 
     * @name logout
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function logout(){
        
        if ($this->session->userdata('login_admin')) {
            
            /*Salva o logout na tabela de log*/
            
            $this->load->model($this->config->item('admin') . 'log_model');
            
            $dados['logout']        = date('Y-m-d H:i:s');
            $dados['last_activity'] = $dados['logout'];
            $dados['id']            = $this->session->userdata('log_id');
            
            $this->log_model->logout($dados);
            
            $this->session->sess_destroy();
            
        }
            
        redirect($this->config->item('admin') . $this->config->item('login'));
    }
    
}