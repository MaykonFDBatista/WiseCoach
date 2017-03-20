<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

class loja extends CI_Controller {
    
    function __construct() {
        
        parent::__construct();
        
        _login_ws();
        
        $this->load->model(array(
            $this->config->item('ws') . 'website_model',
            $this->config->item('ws') . 'competidor_model',
            $this->config->item('ws') . 'loja_model',
            $this->config->item('ws') . 'regra_pontuacao_model',
            ));
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios', 'mensagens'); 
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        
        $this->load->language($arquivos, $idioma);
    }
    
    /**
     * Carrega a view com os dados do competidor
     * 
     * @name index
     * @author Claudia dos Reis Silva <claudia.silva@tellks.com.br>
     * @since 04/08/2015
     * @param void
     * @return void
     */
    function index() {
        
        $competidor_id = $this->session->userdata('id');
        
        $dados = array();
        $dados['competidor'] = $this->competidor_model->get_by_id($competidor_id);
        $dados['regras_loja'] = $this->loja_model->get_all();
        $dados['regra_pontuacao'] = $this->regra_pontuacao_model->get_all();
        
        $dados['idiomas']    = $this->config->item('sis_idiomas');
        $dados['website']    = $this->website_model->get_dados();
        
        $dados['url'] = base_url($this->config->item('ws') . 'loja/comprar');

        //view a ser carregada
        $dados['conteudo'] = 'loja/index';
        
        $dados['assets_js'][] = 'plugins/icheck/icheck.min.js';
        $dados['assets_js'][] = 'ajax/loja_ws.js';
        $dados['assets_js'][] = 'validacao/loja_ws.js';
        
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }
    
    function comprar(){
        
        $this->config->item('arquivo');
        
        $this->load->helper('file');
        
        $this->load->model(array($this->config->item('ws') . 'problema_model'));
        
        $competidor_id = $this->session->userdata('id');
        
        $competidor = $this->competidor_model->get_by_id($competidor_id);
        
        $regras = $this->input->post('regras');
        
        $regra_id = (sizeof($regras) > 0) ? $regras[0] : 0;
        
        $regra = $this->loja_model->get_by_id($regra_id);
        
        if($competidor->pontos >=  $regra->pontos) {
            
            $problema_id = $this->input->post('problema_id');
            
            $problema = $this->problema_model->get_by_id($problema_id);
            
            $competidor->pontos -= $regra->pontos;
            $this->competidor_model->update($competidor);
            
            $dados = array();
            $dados['entrada_problema']   = read_file('./' . $this->config->item('url_problemas') . $problema->id .'/input.in');
            $dados['problema']  = $problema;
            $dados['regra']     = $regra;
            
            $dados['idiomas']    = $this->config->item('sis_idiomas');
            $dados['website']    = $this->website_model->get_dados();

            //view a ser carregada
            $dados['conteudo'] = 'loja/premio';

            // Carrega a view passando os dados a serem exibidos.
            $this->load->view($this->config->item('tpl_index_default'), $dados);
            
        }
        else {
            $this->session->set_flashdata('msg', 'msg_error');
            
            redirect($this->config->item('ws') . '/loja');
        }
    }
    
    function busca_problemas($regra){
        
        $this->load->model(array($this->config->item('ws') . 'problema_model'));
        
        $problemas = array();
        
        if($regra == 1){
            $problemas = $this->problema_model->get_all_ws();
        }
        else if($regra == 2){
            $problemas = $this->problema_model->get_all_com_dicas();
        }
        
        echo json_encode($problemas);
    }
    
}
