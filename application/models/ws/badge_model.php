<?php

class badge_model extends CI_Model {
    
    private $tabela;
    
    public function __construct() {
        
        parent::__construct();
        
        $this->tabela = 'badge';
    }
    
    public function get_all($competidor_id) {
        
        $this->db->select('b.*,cb.competidor_id as concedido');
        
        $this->db->from($this->tabela . ' as b');
        
        $this->db->join('competidor_badge as cb','cb.badge_id = b.id','LEFT');
        
        $this->db->where('(cb.competidor_id = ' . $competidor_id . ' OR cb.competidor_id IS NULL)');
        
        $this->db->order_by('cb.data_registro','DESC');
        
        $result = $this->db->get();
        
        if($result->num_rows() > 0 ) {
            
            return $result->result();
        }
        
        return array();
    }
}
