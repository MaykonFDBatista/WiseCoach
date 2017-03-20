<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of objeto_aprendizagem_model
 *
 * @author claudia
 */
class badge_model extends MY_Model {
    
    public function __construct() {
        
        parent::__construct('badge');
    }
    
    function get_by_id($id) {

        $this->db->select('*');

        $this->db->from($this->tabela);

        $this->db->where('id', $id);
        
        // Executa a consulta 
        $resultado = $this->db->get();

        $badge = FALSE;
        // Se encontrou algum dado, retorna o dado encontrado
        if ($resultado->num_rows > 0) {

            $badge = $resultado->row(0);
        }
        
        return $badge;
        
    }
    
    function get_by_regra_concessao($regra_concessao,$parametro_concessao) {

        $this->db->select('*');

        $this->db->from($this->tabela);

        $this->db->where('regra_concessao', $regra_concessao);
        
        $this->db->where('parametro_concessao', $parametro_concessao);
        
        // Executa a consulta 
        $resultado = $this->db->get();

        $badge = FALSE;
        // Se encontrou algum dado, retorna o dado encontrado
        if ($resultado->num_rows > 0) {

            $badge = $resultado->row(0);
        }
        
        return $badge;
        
    }
    
    function insert($objeto) {
        
        $this->db->insert($this->tabela, $objeto);

        $id = $this->db->insert_id();
        
        return $id;
    }
    
    function update($objeto) {
        
        $this->db->where('id', $objeto->id);
        
        $atualizou = $this->db->update($this->tabela, $objeto);
                
        return (bool)$atualizou;
    }
    
    function where_count_rows($array = array()) {
        
        $this->db->from($this->tabela);
        
        $this->db->where($array);
        
        return $this->db->count_all_results();
    }
    
    function get_all_where($array = array(),$de = 0, $quantidade = 9) {

        $this->db->select('*');

        $this->db->from($this->tabela);
        
        $this->db->where($array);
        
        $this->db->limit($quantidade, $de);

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
    
    function concede_badge($badge_id, $competidor_id) {

        $dados = array($badge_id, $competidor_id, $badge_id, $competidor_id);
            
        $sql = 'INSERT INTO competidor_badge (badge_id, competidor_id) VALUES (?,?) ON DUPLICATE KEY UPDATE badge_id = ?, competidor_id = ?';

        $inseriu = (bool)$this->db->query($sql,$dados);
        
        return $inseriu;
    }
}
