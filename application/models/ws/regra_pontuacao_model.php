<?php

class regra_pontuacao_model extends CI_Model {
    
    
    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'regra_pontuacao';
    }
    
    function get_all() {
        
        $this->db->select('*');

        $this->db->from($this->tabela);

        // Executa a consulta
        $resultado = $this->db->get();
        // Se encontrou dados retorna um vetor com esses dados
        if($resultado->num_rows() > 0 ) {
            
            return $resultado->result();
        }
        // Senão retorna um vetor vazio
        else {
            
            return array();
        }
    }
    
}
