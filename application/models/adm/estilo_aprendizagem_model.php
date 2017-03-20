<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

class estilo_aprendizagem_model extends CI_Model{
    
    private $tabela;

    public function __construct() {
        
        parent::__construct();
        $this->tabela = 'estilo_aprendizagem';
    }

 
    public function get_all() {

        $this->db->select('*');

        $this->db->from($this->tabela);
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0 ) {
            return $resultado->result();
        }
        else {
            return array();
        }
    }
    
    public function get_by_nome($nome) {

        $this->db->select('*');

        $this->db->from($this->tabela);
        
        $this->db->like('nome',$nome,'BOTH');
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0 ) {
            return $resultado->result();
        }
        else {
            return array();
        }
    }
    
    function get_by_tipo_objeto_aprendizagem($tipo_id) {
        
        $this->db->select('t.*,e.nome');
        
        $this->db->from('tipo_objeto_aprendizagem_estilo_aprendizagem as t');
        
        $this->db->join('estilo_aprendizagem as e','t.estilo_aprendizagem_id = e.id');
        
        $this->db->where('tipo_objeto_aprendizagem_id',$tipo_id);
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0) {
            return $resultado->result();
        }
        else {
            return array();
        }
    }
}

?>
