<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of objeto_aprendizagem
 *
 * @author claudia
 */
class objeto_aprendizagem extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->model(array(
            $this->config->item('ws') . 'website_model', 
            $this->config->item('ws') . 'objeto_aprendizagem_model')
        );
        
        $arquivos = array('formularios', 'mensagens', 'data', 'estilo_aprendizagem'); 
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        
        $this->load->language($arquivos, $idioma);
        
        $this->load->library('badge_library');

        $competidor_id = $this->session->userdata('id');
        
        if($competidor_id) {
            
            $concedeu = $this->badge_library->concede_badge(1,'objeto_aprendizagem', $competidor_id);
        }
    }
    
    public function download($objeto_aprendizagem_id) {
        
        $this->load->config('arquivo');
        
        $this->load->helper('download');
        
        $objeto_aprendizagem = $this->objeto_aprendizagem_model->get_by_id($objeto_aprendizagem_id);
        
        $url = $this->config->item('objeto_aprendizagem_url') . $objeto_aprendizagem->identificador;
        
        $data = file_get_contents($url);
        
        force_download($objeto_aprendizagem->identificador, $data); 
    }
    
    public function visualizar($objeto_aprendizagem_id) {
        
        $this->load->config('arquivo');
        
        $objeto_aprendizagem = $this->objeto_aprendizagem_model->get_by_id($objeto_aprendizagem_id);
        
        $dados = array();
        $dados['website'] = $this->website_model->get_dados();
        $dados['objeto_aprendizagem'] = $objeto_aprendizagem;      
        
        //view a ser carregada
        $dados['conteudo'] = 'objeto_aprendizagem/visualizar';
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }
    
}
