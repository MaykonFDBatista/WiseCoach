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
class formato_objeto_aprendizagem_model extends MY_Model {
    
    public function __construct() {
        
        parent::__construct('formato_objeto_aprendizagem');
    }
    
    function get_by_extensao_mime_type($extensao,$mime_type) {

        $this->db->select('f.*,toa.nome as tipo_objeto_aprendizagem');

        $this->db->from($this->tabela . ' as f');
        
        $this->db->join('tipo_objeto_aprendizagem as toa','f.tipo_objeto_aprendizagem_id = toa.id');

        $this->db->where('extensao', $extensao);
        
        $this->db->or_where('mime_type', $mime_type);
        
        // Executa a consulta 
        $resultado = $this->db->get();

        // Se encontrou algum dado, retorna o dado encontrado
        if ($resultado->num_rows > 0) {

            $formato = $resultado->row(0);
            
            return $formato;
        }
        // Senao retorna FALSO
        else {

            return FALSE;
        }
    }
    
    function get_by_tipo_objeto_aprendizagem($tipo_objeto_aprendizagem_id) {

        $this->db->select('*');

        $this->db->from($this->tabela);

        $this->db->where('tipo_objeto_aprendizagem_id', $tipo_objeto_aprendizagem_id);
        
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
    
}
