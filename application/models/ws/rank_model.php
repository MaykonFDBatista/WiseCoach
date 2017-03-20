<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Model responsavel pela interacao com a tabela de submissaos
 * 
 * @package   models/adm
 * @name      submissao_model
 * @author    Alex Santini <alexsantini_spfc@hotmail.com>   
 * @copyright Copyright (c) 2012, Tellks - Solucoes em tecnologia ltda
 * @since     13/12/2012
 * 
 */
class Rank_model extends CI_Model {

    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'competidor';
    }

    /**
     * Conta a qtd de registros da tabela
     * 
     * @name   count_rows
     * @author Alex Santini <alexsantini_spfc@hotmail.com>   
     * @since  13/12/2012
     * @return int numero de registros da tabela
     */ 
    function count_rows() {
        return $this->db->count_all_results($this->tabela);
    }
    
    /**
     * Conta a qtd de registros da tabela que respeitam as clausulas recebidas
     * por parametro
     * 
     * @name   where_count_rows
     * @author Alex Santini <alexsantini_spfc@hotmail.com>   
     * @since  13/05/2013
     * @param  array $array Array associativo com as clausulas da consulta
     * @return int numero de registros da tabela que respeitam as clausulas
     */
    function where_count_rows($array = array()) {
        $this->db->where($array);
        return $this->db->count_all_results($this->tabela);
    }

    /**
     * Obtêm uma faixa de registros limitados pela paginação
     * 
     * @name   get_all
     * @author Alex Santini <alexsantini_spfc@hotmail.com> 
     * @since  13/12/2012
     * @param  int $de Limite inicial
     * @param  int $quantidade Quantidade de registros retornados
     * @return array Array contendo os registros retornados
     */
    function get_all($de = 0, $quantidade = 9) {

        $sql_resolvidos = "(SELECT count(DISTINCT s.problema_id) FROM wisecoach.submissao as s WHERE s.resposta = 1 AND s.competidor_id = c.id)";
        $sql_erros = "(SELECT count(s.problema_id) FROM wisecoach.submissao as s WHERE s.resposta != 0 AND s.resposta != 1 AND s.competidor_id = c.id)";
        $this->db->select('c.*, ' . $sql_resolvidos . ' as resolvidos, ' . $sql_erros .' as erros');

        $this->db->from($this->tabela . ' as c');
        
        $this->db->order_by('resolvidos', 'desc');
        
        $this->db->order_by('erros', 'asc');
        
        $this->db->order_by('c.data_registro', 'asc');
        
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
    
    /**
     * Obtêm uma faixa de registros limitados pela paginação
     * 
     * @name   get_all
     * @author Alex Santini <alexsantini_spfc@hotmail.com> 
     * @since  13/12/2012
     * @param  int $de Limite inicial
     * @param  int $quantidade Quantidade de registros retornados
     * @return array Array contendo os registros retornados
     */
    function get_all_ws() {
        
        $sql_resolvidos = "(SELECT count(DISTINCT s.problema_id) FROM wisecoach.submissao as s WHERE s.resposta = 1 AND s.competidor_id = c.id)";
        $sql_erros = "(SELECT count(s.problema_id) FROM wisecoach.submissao as s WHERE s.resposta != 0 AND s.resposta != 1 AND s.competidor_id = c.id)";
        $this->db->select('c.*, ' . $sql_resolvidos . ' as resolvidos, ' . $sql_erros .' as erros');

        $this->db->from($this->tabela . ' as c');
        
        $this->db->order_by('resolvidos', 'desc');
        
        $this->db->order_by('erros', 'asc');
        
        $this->db->order_by('c.data_registro', 'asc');

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

    /**
     * Obtêm uma faixa de registros que obedecem as clausulas
     * recebidas por parametro limitados pela paginação
     * 
     * @name   get_all_where
     * @author Alex Santini <alexsantini_spfc@hotmail.com> 
     * @since  13/05/2013
     * @param  array $array Array associativo com as clausulas da consulta
     * @param  int $de Limite inicial
     * @param  int $quantidade Quantidade de registros retornados
     * @return array Array contendo os registros retornados
     */
    function get_all_where($array = array(),$de = 0, $quantidade = 9) {

        $sql_resolvidos = "(SELECT count(DISTINCT s.problema_id) FROM wisecoach.submissao as s WHERE s.resposta = 1 AND s.competidor_id = c.id)";
        $sql_erros = "(SELECT count(s.problema_id) FROM wisecoach.submissao as s WHERE s.resposta != 0 AND s.resposta != 1 AND s.competidor_id = c.id)";
        $this->db->select('c.*, ' . $sql_resolvidos . ' as resolvidos, ' . $sql_erros .' as erros');

        $this->db->from($this->tabela . ' as c');
        
        $this->db->order_by('resolvidos', 'desc');
        
        $this->db->order_by('erros', 'asc');
        
        $this->db->order_by('c.data_registro', 'asc');
        
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