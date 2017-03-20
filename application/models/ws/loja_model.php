<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

class loja_model extends CI_Model {
    
    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'regra_loja';
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
    
    function get_by_id($id) {
        
        $this->db->select('*');

        $this->db->from($this->tabela);
        
        $this->db->where('id',$id);

        // Executa a consulta
        $resultado = $this->db->get();
        // Se encontrou dados retorna um vetor com esses dados
        if($resultado->num_rows() > 0 ) {
            
            return $resultado->row(0);
        }
        // Senão retorna um vetor vazio
        else {
            
            return false;
        }
    }
    
}
