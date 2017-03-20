<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Model responsavel pela interacao com a tabela de competidors
 * 
 * @package   models/adm
 * @name      competidor_model
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @copyright Copyright (c) 2012, Tellks - Solucoes em tecnologia ltda
 * @since     13/12/2012
 * 
 */
class Competidor_model extends CI_Model {

    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'competidor';
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
    function get_all($de = 0, $quantidade = 9) {

        $this->db->select('*');

        $this->db->from($this->tabela);
        
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

        $this->db->select('*');

        $this->db->from($this->tabela);

        $this->db->where('md5(id)', md5($id));

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
     * Busca os categorias em que o competidor cujo id foi recebido por 
     * parametro esta inserido
     * 
     * @name   get_competidor_categorias
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  int $id Id do competidor
     * @return array Retorna um array com os Ids dos categorias em que o competidor esta inserido
     * @return boolean Qdo nao encontra nenhum categoria com acesso a funcionalidade retorna FALSE
     */
    function get_competidor_categorias($id){
        
        $this->db->select('cc.categoria_id');

        $this->db->from($this->tabela . ' as c');
        
        $this->db->join('competidor_categoria as cc','cc.competidor_id = c.id');

        $this->db->where('md5(id)', md5($id));

        // Executa a consulta 
        $resultado = $this->db->get();

        if ($resultado->num_rows > 0) {

            foreach ($resultado->result() as $categoria) {
                
                $array[] = $categoria->categoria_id;
            }
            return $array;
            
        }
        else {

            return FALSE;
        }
    }
    
    /**
     * Busca os materias em que o competidor cujo id foi recebido por 
     * parametro esta inserido
     * 
     * @name   get_competidor_materias
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  int $id Id do competidor
     * @return array Retorna um array com os Ids dos materias em que o competidor esta inserido
     * @return boolean Qdo nao encontra nenhum materia com acesso a funcionalidade retorna FALSE
     */
    function get_competidor_materias($id){
        
        $this->db->select('cm.materia_id');

        $this->db->from($this->tabela . ' as c');
        
        $this->db->join('competidor_materia as cm','cm.competidor_id = c.id');

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
     * Obtêm todos os dados de um registro em particular pelo email
     * 
     * @name   get_by_email
     * @author Claudia dos Reis Silva <claudia.silva@tellks.com.br>
     * @since  13/12/2012
     * @param  string $email email do registro procurado
     * @return Object Qdo encontra o registro retorna um objeto com seus dados
     * @return boolean Qdo nao encontra o registro retorna FALSE
     */ 
    function get_by_email($email) {
        
        $this->db->where('email', $email);
        $resultado = $this->db->get($this->tabela);
        if ($resultado->num_rows == 0) {
            
            return FALSE;
        } else {
            
            return $resultado->row(0);
        }
    } 
    
    /**
     * Insere um novo registro
     * 
     * @name   insert
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  Object $competidor objeto contendo os dados do competidor a ser cadastrado
     * @param  array $grupos Ids dos grupos em que o competidor esta inserido
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function insert($competidor,$categorias, $materias) {
        
        $this->db->insert($this->tabela, $competidor);
        
        $resultado = $this->db->insert_id();        
        
        for ($i = 0; $i < sizeof($categorias); $i++) {
            
            $this->db->insert('competidor_categoria', array('competidor_id' => $resultado, 'categoria_id' => $categorias[$i]));
        }
        
        for ($i = 0; $i < sizeof($materias); $i++) {
            
            $this->db->insert('competidor_materia', array('competidor_id' => $resultado, 'materia_id' => $materias[$i]));
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
     * @param  Object $competidor Dados a serem atualizados
     * @param  array $grupos Ids dos grupos em que o competidor esta inserido
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function update($competidor, $categorias = NULL, $materias = NULL) {

        $update_categorias = FALSE;
        if ($categorias) {
            // Remover o acesso de todos os gurpos
            $this->db->delete('competidor_categoria', 'competidor_id = ' . $competidor->id);

            // Concede o acesso aos grupos selecionados
            for ($i = 0; $i < sizeof($categorias); $i++) {
                $this->db->insert('competidor_categoria', array('competidor_id' => $competidor->id, 'categoria_id' => $categorias[$i]));
            }
            $update_categorias = (bool) $this->db->affected_rows();
        }
        
        $update_materias = FALSE;
        if ($materias) {
            // Remover o acesso de todos os gurpos
            $this->db->delete('competidor_materia', 'competidor_id = ' . $competidor->id);

            // Concede o acesso aos grupos selecionados
            for ($i = 0; $i < sizeof($materias); $i++) {
                $this->db->insert('competidor_materia', array('competidor_id' => $competidor->id, 'materia_id' => $materias[$i]));
            }
            $update_materias = (bool) $this->db->affected_rows();
        }
        
        $this->db->where('md5(id)', md5($competidor->id));
        $this->db->update($this->tabela, $competidor);
        $update_competidor = (bool) $this->db->affected_rows();
        
        return ($update_categorias || $update_materias || $update_competidor);
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