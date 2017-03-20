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
}

?>
