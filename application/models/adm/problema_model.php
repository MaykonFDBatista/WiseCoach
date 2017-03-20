<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Model responsavel pela interacao com a tabela de problemas
 * 
 * @package   models/adm
 * @name      problema_model
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @copyright Copyright (c) 2012, Tellks - Solucoes em tecnologia ltda
 * @since     13/12/2012
 * 
 */
class Problema_model extends CI_Model {

    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'problema';
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
        $this->db->select('p.*, c.nome as categoria');

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('categoria as c','p.categoria_id = c.id');
        
        $this->db->where($array);
        return $this->db->count_all_results();
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
    function get_all($de = 0, $quantidade = 9) {

        $this->db->select('p.*, c.nome as categoria');

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('categoria as c','p.categoria_id = c.id');
        
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

        $this->db->select('p.*, c.nome as categoria');

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('categoria as c','p.categoria_id = c.id');
        
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
     * Obtêm todos os dados de um registro em particular pelo id
     * 
     * @name   get_by_id
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  int $id Id do registro procurado
     * @return Object Qdo encontra o registro retorna um objeto com seus dados
     * @return boolean Qdo nao encontra o registro retorna FALSE
     */ 
    function get_by_id($id) {

        $this->db->select('p.*, c.nome as categoria');

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('categoria as c','p.categoria_id = c.id');

        $this->db->where('md5(p.id)', md5($id));

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
     * Busca os materias em que o problema cujo id foi recebido por 
     * parametro esta inserido
     * 
     * @name   get_problema_materias
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  int $id Id do problema
     * @return array Retorna um array com os Ids dos materias em que o problema esta inserido
     * @return boolean Qdo nao encontra nenhum materia com acesso a funcionalidade retorna FALSE
     */
    function get_problema_materias($id){
        
        $this->db->select('pm.materia_id');

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('problema_materia as pm','pm.problema_id = p.id');

        $this->db->where('md5(id)', md5($id));

        // Executa a consulta 
        $resultado = $this->db->get();

        if ($resultado->num_rows > 0) {

            foreach ($resultado->result() as $materia) {
                
                $array[] = $materia->materia_id;
            }
            return $array;
            
        }
        else {

            return FALSE;
        }
    }
     
    
    /**
     * Insere um novo registro
     * 
     * @name   insert
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  Object $problema objeto contendo os dados do problema a ser cadastrado
     * @param  array $grupos Ids dos grupos em que o problema esta inserido
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function insert($problema, $materias) {
        
        $this->db->insert($this->tabela, $problema);
        
        $resultado = $this->db->insert_id();        
        
        for ($i = 0; $i < sizeof($materias); $i++) {
            
            $this->db->insert('problema_materia', array('problema_id' => $resultado, 'materia_id' => $materias[$i]));
        }

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
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  Object $problema Dados a serem atualizados
     * @param  array $grupos Ids dos grupos em que o problema esta inserido
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function update($problema, $materias = NULL) {
        
        $update_materias = FALSE;
        if ($materias) {
            // Remover o acesso de todos os gurpos
            $this->db->delete('problema_materia', 'problema_id = ' . $problema->id);

            // Concede o acesso aos grupos selecionados
            for ($i = 0; $i < sizeof($materias); $i++) {
                $this->db->insert('problema_materia', array('problema_id' => $problema->id, 'materia_id' => $materias[$i]));
            }
            $update_materias = (bool) $this->db->affected_rows();
        }
        
        $this->db->where('md5(id)', md5($problema->id));
        $this->db->update($this->tabela, $problema);
        $update_problema = (bool) $this->db->affected_rows();
        
        return ($update_materias || $update_problema);
    }

    /**
     * Deleta um registro
     * 
     * @name   delete
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012 
     * @param   array $ids ids dos registro a serem removidos
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function delete($ids) {
        
        $this->db->where_in('id', $ids);
        
        $this->db->delete($this->tabela);
        return (bool) $this->db->affected_rows();
    }

}