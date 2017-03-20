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

class Recomendacao extends CI_Controller {
    
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
        
        $this->session->set_userdata('pagina_anterior', current_url()); 
        $this->session->set_userdata('pagina_anterior_login', current_url()); 
        
        _login_ws();
        
        $this->load->model(array(
            $this->config->item('ws') . 'website_model',
            $this->config->item('ws') . 'competidor_model',
            $this->config->item('ws') . 'problema_model',
            $this->config->item('ws') . 'submissao_model',
            $this->config->item('ws') . 'recomendacao_model'));
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios', 'mensagens'); 
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        
        $this->load->language($arquivos, $idioma);
        
        $competidor_id = $this->session->userdata('id');
        
        if($competidor_id) {
            
            $this->load->library('badge_library');
            
            $concedeu = $this->badge_library->concede_badge(1,'recomendacao', $competidor_id);
        }
        
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
        
        $dados = array();
        $dados['website']       = $this->website_model->get_dados();
        $competidor_id          = $this->session->userdata('id');
        $competidor             = $this->competidor_model->get_by_id($competidor_id);
        $competidor_categorias  = $this->competidor_model->get_competidor_categorias($competidor_id);
        $competidor_materias    = $this->competidor_model->get_competidor_materias($competidor_id);
        $competidor_problemas   = $this->competidor_model->get_competidor_problemas($competidor_id);
        $dados['problemas']     = $this->recomendacao_model->recomendacao_baseada_conteudo($competidor, $competidor_categorias, $competidor_materias, $competidor_problemas);
        $dados['competidores']  = $this->recomendacao_model->competidores_similares2($competidor, $competidor_categorias, $competidor_materias, $competidor_problemas);
        $dados['problemas2']    = $this->recomendacao_model->recomendacao_colaborativa($competidor, $competidor_categorias, $competidor_materias, $competidor_problemas);
        //view a ser carregada
        $dados['conteudo'] = 'recomendacao/index';
        
        $dados['pagina'] = 'recomendacao';
        
        $dados['assets_js'][] = 'plugins/peity-master/jquery.peity.min.js';
        $dados['assets_js'][] = 'ajax/recomendacao_ws.js';
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }
    
   

}