<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Model responsavel pela interacao com a tabela de grupos
 * 
 * @package   models/adm
 * @name      grupo_model
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @copyright Copyright (c) 2012, Tellks - Solucoes em tecnologia ltda
 * @since     13/12/2012
 * 
 */
class MY_Model extends CI_Model{
    
    protected $tabela;

    public function __construct($tabela = '') {
        
        parent::__construct();
        $this->tabela = $tabela;
    }

    /**
     * Conta a qtd de registros da tabela
     * 
     * @name   count_rows
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
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
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
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
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  int $de Limite inicial
     * @param  int $quantidade Quantidade de registros retornados
     * @return array Array contendo os registros retornados
     */
    function get_all() {

        $this->db->select('*');

        $this->db->from($this->tabela);

        // Executa a consulta
        $resultado = $this->db->get();
        
        // Se encontrou dados retorna um vetor com esses dados
        if($resultado->num_rows() > 0 ){
            return $resultado->result();
        }
        // Senão retorna um vetor vazio
        else{
            return array();
        }
    }
    
    /**
     * Obtêm uma faixa de registros que obedecem as clausulas
     * recebidas por parametro limitados pela paginação
     * 
     * @name   get_all_where
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/05/2013
     * @param  array $array Array associativo com as clausulas da consulta
     * @param  int $de Limite inicial
     * @param  int $quantidade Quantidade de registros retornados
     * @return array Array contendo os registros retornados
     */
    function get_all_where($array = array(),$de = 0, $quantidade = 9) {

        $this->db->select('*');

        $this->db->from($this->tabela);
        
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
    
    /**
     * Obtêm todos os dados de um registro em particular
     * 
     * @name   get_by_id
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  int $id Id do registro procurado
     * @return Object Qdo encontra o registro retorna um objeto com seus dados
     * @return boolean Qdo nao encontra o registro retorna FALSE
     */ 
    function get_by_id($id) {

        $this->db->select('*');

        $this->db->from($this->tabela);

        $this->db->where('id', $id);
        
        // Executa a consulta 
        $resultado = $this->db->get();

        // Se encontrou algum dado, retorna o dado encontrado
        if ($resultado->num_rows > 0) {

            return $resultado->row(0);
        }
        // Senao retorna FALSO
        else {

            return FALSE;
        }
    }
    
    /**
     * Insere um novo registros
     * 
     * @name   insert
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  Object objeto objeto contendo os dados do registro a ser cadastrado
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function insert($objeto) {

        $this->db->insert($this->tabela, $objeto);

        // Força para que seja retornado um valor lógico
        return (bool) $this->db->affected_rows();
    }

    /**
     * Atualiza um registro
     * 
     * @name   update
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  Object $objeto Dados a serem atualizados
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function update($objeto) {
        
        $this->db->where('id', $objeto->id);
        
        $this->db->update($this->tabela, $objeto);

        // Retorna um valor lógico indicando o resultado da operação.
        return (bool) $this->db->affected_rows();
    }

    /**
     * Deleta os registros cujos ids foram recebidos por parametro
     * 
     * @name   delete
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012 
     * @param  array $ids ids dos objetos a serem removidos
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function delete($ids) {
        
        $this->db->where_in('id', $ids);

        $this->db->delete($this->tabela);

        // Força para que seja retornado um valor lógico
        return (bool) $this->db->affected_rows();
    }
   
}