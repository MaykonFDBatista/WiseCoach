<?php

class badge_library {
    
    private $CI;
    
    public function __construct() {
        
        $this->CI = &get_instance();
    }
    
    function concede_badge($regra_concessao,$parametro_concessao, $competidor_id) {
        
        $this->CI->load->model(array(
                $this->CI->config->item('admin') . 'badge_model', 
                $this->CI->config->item('admin') . 'notificacao_model'));
        
        $badge = $this->CI->badge_model->get_by_regra_concessao($regra_concessao,$parametro_concessao);
        
        $concedido = FALSE;
        
        if($badge != NULL){
            
            $concedido = $this->CI->badge_model->concede_badge($badge->id, $competidor_id);
        }
        
        return $concedido;
    } 
}
