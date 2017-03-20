<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Controller para onde o sistema é redirecionado quando o mesmo está desativado
 * 
 * @package Controllers/adm
 * @name Desativado
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Desativado extends CI_Controller {
    
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
        
        $this->load->model($this->config->item('app') . 'sistema_model');
        
        $status = $this->sistema_model->get_status();
        
        if($status->ativo == 1) {
            
            redirect($this->config->item('admin') . $this->router->default_controller);
        }
        
        // Se o sistema nao esta ativo carrega os arquivos de linguagem necessarios nas 
        // views carregadas por esta controladora
        $arquivos = array('mensagens','formularios'); 
        
        $this->load->language($arquivos, $this->session->userdata('idioma'));
    }
    
    /**
     * Redireciona para a página de desativado
     * 
     * @name index
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function index() {
        
        $dados['sis_desativado'] = TRUE;
        
        $this->load->view($this->config->item('admin_desativado'),$dados);
    }
}

?>
