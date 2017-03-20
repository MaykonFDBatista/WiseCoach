<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of campo_model
 *
 * @author tellks
 */
class Website_model extends CI_Model{
    private $tabela;
    
    public function __construct() {
        parent::__construct();
        $this->tabela="website";
    }
    
    /**
     * Obtêm uma faixa de registros limitados pela paginação
     * 
     * @name   get_all
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br> 
     * @since  16/09/2014
     * @param  int $de Limite inicial
     * @param  int $quantidade Quantidade de registros retornados
     * @return array Array contendo os registros retornados
     */
    function get_dados() {

        $this->db->select('*');

        $this->db->from($this->tabela);

        // Executa a consulta
        $resultado = $this->db->get();
        
        // Se encontrou dados retorna um array com esses dados
        if($resultado->num_rows() > 0 ){
            return $resultado->row(0);
        }
        // Senão retorna um array vazio
        else{
            return new stdClass();
        }
    }
    
    /**
     * Retorno o email de contato do fale conosco do website do app
     * 
     * @name   get_email_contato
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br> 
     * @since  16/09/2014
     * @param  void
     * @return string com o email
     */
    function get_email_contato() {

        $this->db->select('email_fale_conosco');

        $this->db->from($this->tabela);

        // Executa a consulta
        $resultado = $this->db->get();
        
        // Se encontrou dados retorna um array com esses dados
        if($resultado->num_rows() > 0 ){
           return $resultado->row(0)->email_fale_conosco;
        }
        // Senão retorna um array vazio
        else{
            return new stdClass();
        }
    }
    
}
