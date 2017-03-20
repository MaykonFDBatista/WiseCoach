<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nivel_model
 *
 * @author claudia
 */
class nivel_model extends CI_Model{
    
    private $tabela;

    public function __construct() {
        
        parent::__construct();
        $this->tabela = 'nivel';
    }
    
     function get_all() {

        $this->db->select('*');

        $this->db->from($this->tabela);

        // Executa a consulta
        $resultado = $this->db->get();
        
        // Se encontrou dados retorna um vetor com esses dados
        if($resultado->num_rows() > 0 ){
            return $resultado->result();
        }
        // Senão retorna um vetor vazio
        else{
            return array();
        }
    }
    
}
