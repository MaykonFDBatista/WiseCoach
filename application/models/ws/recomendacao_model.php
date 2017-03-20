<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Model responsavel pela interacao com a tabela de problemas
 * 
 * @package   models/adm
 * @name      problema_model
 * @author    Alex Santini <alexsantini_spfc@hotmail.com>   
 * @copyright Copyright (c) 2012, Tellks - Solucoes em tecnologia ltda
 * @since     13/12/2012
 * 
 */
class Recomendacao_model extends CI_Model {

    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'problema';
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
        $this->db->select('p.*, c.nome as categoria');

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('categoria as c','p.categoria_id = c.id');$this->db->select('p.*');
        
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

        $this->db->select('p.*, c.nome as categoria');

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('categoria as c','p.categoria_id = c.id');
        
        $this->db->where('p.ativo', 1);

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
     * @author Alex Santini <alexsantini_spfc@hotmail.com> 
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
     * @author Alex Santini <alexsantini_spfc@hotmail.com> 
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
            
            
        }
        else {

            $array[0] = 0;
        }
        
        return $array;
    }
    
    function problemas_materias_diferentes($competidor_materias){
        $this->db->select('pm.problema_id');
        
        $this->db->distinct();

        $this->db->from('problema_materia as pm');
    
        $this->db->where_not_in('pm.materia_id', $competidor_materias);
        
        // Executa a consulta
        $resultado = $this->db->get();

        // Se encontrou dados retorna um vetor com esses dados
        if($resultado->num_rows() > 0 ) {
            
            foreach ($resultado->result() as $problema) {
                
                $array[] = $problema->problema_id;
            }
            
        }
        // Senão retorna um vetor vazio
        else {
            
            $array[0] = 0;
        }
        
        return $array;
    }
    
    function recomendacao_baseada_conteudo($competidor, $competidor_categorias, $competidor_materias, $competidor_problemas){
        
        $problemas_materias_diferentes = $this->problemas_materias_diferentes($competidor_materias);
        
        $peso = '(SELECT SUM(pm.materia_id) FROM problema_materia AS pm WHERE pm.problema_id = p.id)';
        
        $this->db->select('p.*, c.nome as categoria, ' . $peso . ' AS peso');

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('categoria as c','p.categoria_id = c.id');
        
        $this->db->where('p.ativo', 1);
        
        $this->db->where('p.nivel_id <=', $competidor->nivel_id);
        
        $this->db->where_in('p.categoria_id', $competidor_categorias);
        
        $this->db->where_not_in('p.id', $problemas_materias_diferentes);
        
        $this->db->where_not_in('p.id', $competidor_problemas);
        
        $this->db->order_by('p.nivel_id');
        
        $this->db->order_by('p.categoria_id');
        
        $this->db->order_by('peso');
        
        
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
    
    function competidores_materias_diferentes($competidor_materias){
        $this->db->select('cm.competidor_id');
        
        $this->db->distinct();

        $this->db->from('competidor_materia as cm');
    
        $this->db->where_not_in('cm.materia_id', $competidor_materias);
        
        // Executa a consulta
        $resultado = $this->db->get();

        // Se encontrou dados retorna um vetor com esses dados
        if($resultado->num_rows() > 0 ) {
            
            foreach ($resultado->result() as $competidor) {
                
                $array[] = $competidor->competidor_id;
            }
            
        }
        // Senão retorna um vetor vazio
        else {
            
            $array[0] = 0;
        }
        
        return $array;
    }
    
    function competidores_categorias_diferentes($competidor_categorias){
        $this->db->select('cc.competidor_id');
        
        $this->db->distinct();

        $this->db->from('competidor_categoria as cc');
    
        $this->db->where_not_in('cc.categoria_id', $competidor_categorias);
        
        // Executa a consulta
        $resultado = $this->db->get();

        // Se encontrou dados retorna um vetor com esses dados
        if($resultado->num_rows() > 0 ) {
            
            foreach ($resultado->result() as $competidor) {
                
                $array[] = $competidor->competidor_id;
            }
            
        }
        // Senão retorna um vetor vazio
        else {
            
            $array[0] = 0;
        }
        
        return $array;
    }
    
    function competidores_similares2($competidor, $competidor_categorias, $competidor_materias){
        
        $competidores_materias_diferentes = $this->competidores_materias_diferentes($competidor_materias);
        
        $competidores_categorias_diferentes = $this->competidores_categorias_diferentes($competidor_categorias);
        
        $peso_materia = '(SELECT SUM(cm.materia_id) FROM competidor_materia AS cm WHERE cm.competidor_id = c.id)';
        
        $peso_categoria = '(SELECT SUM(cc.categoria_id) FROM competidor_categoria AS cc WHERE cc.competidor_id = c.id)';
        
        $this->db->select('c.*, ' . $peso_materia . ' AS peso_materia, ' . $peso_categoria . ' AS peso_categoria');

        $this->db->from('competidor as c');
        
        $this->db->where('c.id !=', $competidor->id);
        
        $this->db->where('c.ativo', 1);
        
        $this->db->where('c.nivel_id <=', $competidor->nivel_id);
        
        $this->db->where_not_in('c.id', $competidores_materias_diferentes);
        
        $this->db->where_not_in('c.id', $competidores_categorias_diferentes);
        
        $this->db->order_by('c.nivel_id');
        
        $this->db->order_by('peso_materia');
        
        $this->db->order_by('peso_categoria');
        
        
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
    
    function competidores_similares($competidor, $competidor_categorias, $competidor_materias){
        
        $competidores_materias_diferentes = $this->competidores_materias_diferentes($competidor_materias);
        
        $competidores_categorias_diferentes = $this->competidores_categorias_diferentes($competidor_categorias);
        
        $peso_materia = '(SELECT SUM(cm.materia_id) FROM competidor_materia AS cm WHERE cm.competidor_id = c.id)';
        
        $peso_categoria = '(SELECT SUM(cc.categoria_id) FROM competidor_categoria AS cc WHERE cc.competidor_id = c.id)';
        
        $this->db->select('c.*, ' . $peso_materia . ' AS peso_materia, ' . $peso_categoria . ' AS peso_categoria');

        $this->db->from('competidor as c');
        
        $this->db->where('c.id !=', $competidor->id);
        
        $this->db->where('c.ativo', 1);
        
        $this->db->where('c.nivel_id <=', $competidor->nivel_id);
        
        $this->db->where_not_in('c.id', $competidores_materias_diferentes);
        
        $this->db->where_not_in('c.id', $competidores_categorias_diferentes);
        
        $this->db->order_by('c.nivel_id');
        
        $this->db->order_by('peso_materia');
        
        $this->db->order_by('peso_categoria');
        
        
        // Executa a consulta
        $resultado = $this->db->get();

        // Se encontrou dados retorna um vetor com esses dados
        if($resultado->num_rows() > 0 ) {
            
            foreach ($resultado->result() as $competidor) {
                
                $array[] = $competidor->id;
            }
            
        }
        // Senão retorna um vetor vazio
        else {
            
            $array[0] = 0;
        }
        
        return $array;
    }
    
    function problemas_competidores_similares($competidores_similares){
        
        $this->db->select('s.problema_id');
        
        $this->db->distinct();

        $this->db->from('submissao as s');
        
        $this->db->where('s.resposta', 1);
        
        $this->db->where_in('s.competidor_id', $competidores_similares);        
        
        // Executa a consulta
        $resultado = $this->db->get();

        // Se encontrou dados retorna um vetor com esses dados
        if($resultado->num_rows() > 0 ) {
            
            foreach ($resultado->result() as $submissao) {
                
                $array[] = $submissao->problema_id;
            }

        }
        // Senão retorna um vetor vazio
        else {
            
            $array[0] = 0;

        }
        
        return $array;
        
    }
    
    function recomendacao_colaborativa($competidor, $competidor_categorias, $competidor_materias, $competidor_problemas){
        
        $competidores_similares = $this->competidores_similares($competidor, $competidor_categorias, $competidor_materias);
         
        $problemas_competidores_similares = $this->problemas_competidores_similares($competidores_similares);
        
        $peso = '(SELECT SUM(pm.materia_id) FROM problema_materia AS pm WHERE pm.problema_id = p.id)';
        
        $this->db->select('p.*, c.nome as categoria, ' . $peso . ' AS peso');

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('categoria as c','p.categoria_id = c.id');
        
        $this->db->where('p.ativo', 1);
        
        $this->db->where_in('p.id', $problemas_competidores_similares);
        
        $this->db->where_not_in('p.id', $competidor_problemas);
        
        $this->db->order_by('p.nivel_id');
        
        $this->db->order_by('p.categoria_id');
        
        $this->db->order_by('peso');
        
        
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