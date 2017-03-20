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
class Submissao_model extends CI_Model {

    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'submissao';
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
    function get_all($de = 0, $quantidade = 9, $competidor_id) {

        $this->db->select('s.*, p.nome as problema');

        $this->db->from($this->tabela . ' as s');
        
        $this->db->join('problema as p','s.problema_id = p.id');
        
        $this->db->where('s.competidor_id', $competidor_id);
        
        $this->db->order_by('s.data_registro', 'desc');
        
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
    function get_all_ws($competidor_id) {

        $this->db->select('s.*, p.nome as problema');

        $this->db->from($this->tabela . ' as s');
        
        $this->db->join('problema as p','s.problema_id = p.id');
        
        $this->db->where('s.competidor_id', $competidor_id);
        
        $this->db->order_by('s.data_registro', 'desc');

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
    function get_all_where($array = array(),$de = 0, $quantidade = 9, $competidor_id) {

        $this->db->select('s.*, p.nome as problema');

        $this->db->from($this->tabela . ' as s');
        
        $this->db->join('problema as p','s.problema_id = p.id');
        
        $this->db->where('s.competidor_id', $competidor_id);
        
        $this->db->where($array);
        
        $this->db->order_by('s.data_registro', 'desc');

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
     * Obtêm todos os dados de um registro em particular pelo id
     * 
     * @name   get_by_id
     * @author Alex Santini <alexsantini_spfc@hotmail.com> 
     * @since  13/12/2012
     * @param  int $id Id do registro procurado
     * @return Object Qdo encontra o registro retorna um objeto com seus dados
     * @return boolean Qdo nao encontra o registro retorna FALSE
     */ 
    function get_by_id($id) {

        $this->db->select('s.*, p.*');

        $this->db->from($this->tabela . ' as s');
        
        $this->db->join('problema as p','s.problema_id = p.id');
        
        $this->db->order_by('s.data_registro', 'desc');

        $this->db->where('md5(s.id)', md5($id));

        // Executa a consulta 
        $resultado = $this->db->get();

        if ($resultado->num_rows > 0) {

            return $resultado->row(0);
            
        }
        else {

            return FALSE;
        }
    }
    
     
    
    /**
     * Insere um novo registro
     * 
     * @name   insert
     * @author Alex Santini <alexsantini_spfc@hotmail.com> 
     * @since  13/12/2012
     * @param  Object $submissao objeto contendo os dados do submissao a ser cadastrado
     * @param  array $grupos Ids dos grupos em que o submissao esta inserido
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function insert($submissao) {
        
        $this->db->insert($this->tabela, $submissao);
        
        $resultado = $this->db->insert_id(); 
        

        if ($resultado > 0) {   
            
            return $resultado;
        } else {

            return FALSE;
        }
    }

    /**
     * Atualiza um registro
     * 
     * @name   update
     * @author Alex Santini <alexsantini_spfc@hotmail.com> 
     * @since  13/12/2012
     * @param  Object $submissao Dados a serem atualizados
     * @param  array $grupos Ids dos grupos em que o submissao esta inserido
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function update($submissao) {

        
        $this->db->where('md5(id)', md5($submissao->id));
        $this->db->update($this->tabela, $submissao);
        $update = (bool) $this->db->affected_rows();
        
        return $update;
    }

    /**
     * Deleta um registro
     * 
     * @name   delete
     * @author Alex Santini <alexsantini_spfc@hotmail.com> 
     * @since  13/12/2012 
     * @param   array $ids ids dos registro a serem removidos
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function delete($ids) {
        
        $this->db->where_in('id', $ids);
        
        $this->db->delete($this->tabela);
        return (bool) $this->db->affected_rows();
    }

    function verifica_resolucao($competidor_id, $problema_id){
        $this->db->where('competidor_id', $competidor_id);
        $this->db->where('problema_id', $problema_id);
        $this->db->where('resposta', 1);
        $qtd = $this->db->count_all_results($this->tabela);
        
        if($qtd>0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    function get_top_20($problema_id) {

        $this->db->select('s.*,c.nome as competidor');

        $this->db->from($this->tabela . ' as s');
        
        $this->db->join('competidor as c','c.id = s.competidor_id','INNER');
        
        $this->db->where('s.problema_id', $problema_id);
        
        $this->db->where('s.resposta', $this->config->item('resposta_aceita'));
        
        $this->db->order_by('s.tempo', 'asc');
        
        $this->db->order_by('s.data_registro', 'asc');
        
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
    
    function get_qtd_resposta_por_problema($problema_id) {

        $this->db->select('distinct(s.resposta) as resposta,count(*) as qtd');

        $this->db->from($this->tabela . ' as s');
        
        $this->db->where('s.problema_id', $problema_id);
        
        $this->db->group_by('s.resposta');
        
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
    
    function get_qtd_linguagem_por_problema($problema_id) {

        $this->db->select('distinct(s.linguagem) as linguagem,count(*) as qtd');

        $this->db->from($this->tabela . ' as s');
        
        $this->db->where('s.problema_id', $problema_id);
        
        $this->db->group_by('s.linguagem');
        
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
    
    function get_qtd_resposta_por_competidor($competidor_id) {

        $this->db->select('distinct(s.resposta) as resposta,count(*) as qtd');

        $this->db->from($this->tabela . ' as s');
        
        $this->db->where('s.competidor_id', $competidor_id);
        
        $this->db->group_by('s.resposta');
        
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
    
    function get_qtd_linguagem_por_competidor($competidor_id){
        
        $this->db->select('distinct(s.linguagem) as linguagem,count(*) as qtd');

        $this->db->from($this->tabela . ' as s');
        
        $this->db->where('s.competidor_id', $competidor_id);
        
        $this->db->where('s.resposta','1');
        
        $this->db->group_by('s.linguagem');
        
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
    
    function get_qtd_categoria_por_competidor($competidor_id){
        
        $this->db->select('distinct(cat.nome) as categoria,count(*) as qtd');

        $this->db->from($this->tabela . ' as s');
        
        $this->db->join('problema as p','p.id = s.problema_id');
        
        $this->db->join('categoria as cat','cat.id = p.categoria_id');
        
        $this->db->where('s.competidor_id', $competidor_id);
        
        $this->db->where('s.resposta','1');
        
        $this->db->group_by('cat.nome');
        
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
    
    function get_qtd_data_por_competidor($competidor_id){
        
        $sql = "SELECT distinct(DATE_FORMAT(s.data_registro,'%d-%m-%Y')) as data_registro,count(*) as qtd FROM " . $this->tabela . ' as s' . " WHERE s.competidor_id = ? AND s.resposta = 1 GROUP BY DATE_FORMAT(s.data_registro,'%d-%m-%Y') ORDER BY s.data_registro";
        
        // Executa a consulta
        $resultado = $this->db->query($sql, array($competidor_id));
        
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