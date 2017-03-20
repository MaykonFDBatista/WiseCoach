<?php
class notificacao_model extends CI_Model {
    
    private $table;
    
    public function __construct() {
        
        parent::__construct();
        
        $this->table = 'notificacao';
    }
    
    public function get_nao_lidas_by_competidor($competidor_id) {
        
        $this->db->select('*');
        
        $this->db->from($this->table);
        
        $this->db->where('lida',0);
        
        $this->db->where('competidor_id', $competidor_id);
        
        $result = $this->db->get();
        
        if($result->num_rows() > 0) {
            
            return $result->result();
        }
        
        return array();
    }
    
    public function marcar_como_lida($competidor_id, $notificacao_id){
        
        $objeto = array('lida' => 1);
        
        $this->db->where('competidor_id', $competidor_id);
        
        $this->db->where('id', $notificacao_id);
        
        $lida = $this->db->update($this->table, $objeto);
        
        return (boolean)$lida;
    }
}
