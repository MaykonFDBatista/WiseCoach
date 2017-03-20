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
class objeto_aprendizagem_model extends MY_Model {
    
    public function __construct() {
        
        parent::__construct('objeto_aprendizagem');
    }
    
    function get_by_id($id) {

        $this->db->select('*');

        $this->db->from($this->tabela);

        $this->db->where('id', $id);
        
        // Executa a consulta 
        $resultado = $this->db->get();

        $objeto_aprendizagem = FALSE;
        // Se encontrou algum dado, retorna o dado encontrado
        if ($resultado->num_rows > 0) {

            $objeto_aprendizagem = $resultado->row(0);
            
            if($objeto_aprendizagem) {
                $objeto_aprendizagem->materias = $this->get_materias($objeto_aprendizagem->id);
                $objeto_aprendizagem->estilos_aprendizagem = $this->get_estilos($objeto_aprendizagem->id);
            }
        }
        
        return $objeto_aprendizagem;
        
    }
    
    function get_materias($objeto_aprendizagem_id) {

        $this->db->select('m.*');

        $this->db->from('objeto_aprendizagem_materia as oam');

        $this->db->join('materia as m','m.id = oam.materia_id');
                
        $this->db->where('oam.objeto_aprendizagem_id', $objeto_aprendizagem_id);
        
        // Executa a consulta 
        $resultado = $this->db->get();

        // Se encontrou algum dado, retorna o dado encontrado
        if ($resultado->num_rows > 0) {

            return $resultado->result();
        }
        // Senao retorna FALSO
        else {

            return array();
        }
    }
    
    function get_estilos($objeto_aprendizagem_id) {

        $this->db->select('e.*');

        $this->db->from('objeto_aprendizagem_estilo_aprendizagem as oae');

        $this->db->join('estilo_aprendizagem as e','e.id = oae.estilo_aprendizagem_id');
                
        $this->db->where('oae.objeto_aprendizagem_id', $objeto_aprendizagem_id);
        
        // Executa a consulta 
        $resultado = $this->db->get();

        // Se encontrou algum dado, retorna o dado encontrado
        if ($resultado->num_rows > 0) {

            return $resultado->result();
        }
        // Senao retorna FALSO
        else {

            return array();
        }
    }
    
    function insert($objeto) {
        
        $materias = $objeto->materias;
        unset($objeto->materias);
        $estilos = $objeto->estilos;
        unset($objeto->estilos);
        
        $this->db->insert($this->tabela, $objeto);

        $id = $this->db->insert_id();
        
        $insert_materia = $this->insert_materia($materias, $id);
        
        $insert_estilo = $this->insert_estilo($estilos, $id);
        
        return $insert_materia + $insert_estilo;
    }
    
    function update($objeto) {
        
        $materias = $objeto->materias;
        unset($objeto->materias);
        $estilos = $objeto->estilos;
        unset($objeto->estilos);
        
        $this->db->where('id', $objeto->id);
        
        $atualizou = $this->db->update($this->tabela, $objeto);

        $insert_materia = $this->insert_materia($materias,$objeto->id);
        
        $insert_estilo = $this->insert_estilo($estilos,$objeto->id);
                
        return (bool)$atualizou + $insert_materia + $insert_estilo;
    }
    
    function insert_materia($materias,$objeto_aprendizagem_id){
       
        $removeu = $this->delete_materia($materias,$objeto_aprendizagem_id);
        
        $insert_result = false;
        
        if(sizeof($materias) > 0) {
            
            foreach($materias as $materia) {
                
                if(!empty($materia)) {
                    
                    $query = 'INSERT INTO objeto_aprendizagem_materia (materia_id,objeto_aprendizagem_id) VALUES (?,?) ON DUPLICATE KEY UPDATE materia_id = ?, objeto_aprendizagem_id = ?';

                    $this->db->query($query, array($materia, $objeto_aprendizagem_id,$materia, $objeto_aprendizagem_id));

                    $insert_result += (bool) $this->db->affected_rows();
                }
            }
        }
       
       return (bool)$removeu + $insert_result;
    }
    
    function delete_materia($materias,$objeto_aprendizagem_id) {
        
        $this->db->where('objeto_aprendizagem_id',$objeto_aprendizagem_id);
        
        $this->db->where_not_in('materia_id', $materias);

        $this->db->delete('objeto_aprendizagem_materia');

        // Força para que seja retornado um valor lógico
        return (bool) $this->db->affected_rows();
    }
    
    function insert_estilo($estilos,$objeto_aprendizagem_id){
       
        $removeu = $this->delete_estilo($estilos,$objeto_aprendizagem_id);
        
        $insert_result = false;
        
        if(sizeof($estilos) > 0) {
            foreach($estilos as $estilo) {
                
                if(!empty($estilo)) {
                    
                    $query = 'INSERT INTO objeto_aprendizagem_estilo_aprendizagem (estilo_aprendizagem_id,objeto_aprendizagem_id) VALUES (?,?) ON DUPLICATE KEY UPDATE estilo_aprendizagem_id = ?, objeto_aprendizagem_id = ?';

                    $this->db->query($query, array($estilo, $objeto_aprendizagem_id,$estilo, $objeto_aprendizagem_id));

                    $insert_result += (bool) $this->db->affected_rows();
                }
            }
        }
       
       return (bool)$removeu + $insert_result;
    }
    
    function delete_estilo($estilos,$objeto_aprendizagem_id) {
        
        $this->db->where('objeto_aprendizagem_id',$objeto_aprendizagem_id);
        
        $this->db->where_not_in('estilo_aprendizagem_id', $estilos);

        $this->db->delete('objeto_aprendizagem_estilo_aprendizagem');

        // Força para que seja retornado um valor lógico
        return (bool) $this->db->affected_rows();
    }
    
    function where_count_rows($array = array()) {
        
        $this->db->from($this->tabela . ' as oa');
        
        $this->db->join('tipo_objeto_aprendizagem as tp','oa.tipo_id = tp.id','LEFT');
        
        $this->db->where($array);
        
        return $this->db->count_all_results();
    }
    
    function get_all_where($array = array(),$de = 0, $quantidade = 9) {

        $this->db->select('oa.*,tp.nome as tipo');

        $this->db->from($this->tabela . ' as oa');
        
        $this->db->join('tipo_objeto_aprendizagem as tp','oa.tipo_id = tp.id','LEFT');
        
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
}
