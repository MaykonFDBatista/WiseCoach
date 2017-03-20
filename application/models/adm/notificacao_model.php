<?php

class notificacao_model extends CI_Model {
    
    private $table;
    
    public function __construct() {
        
        parent::__construct();
        
        $this->table = 'notificacao';
    }
    
    public function insert($notificacao){
        
        $inseriu = $this->db->insert($this->table, $notificacao);
        
        return (bool)$inseriu;
    }
}
