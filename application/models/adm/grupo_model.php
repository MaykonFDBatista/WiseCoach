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
class grupo_model extends CI_Model{
    
    private $tabela;

    public function __construct() {
        
        parent::__construct();
        $this->tabela = 'grupo';
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
        if($resultado->num_rows() > 0 ){
            return $resultado->result();
        }
        // Senão retorna um vetor vazio
        else{
            return array();
        }
    }
    
    function get_all_adm() {

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
    
    function get_all_app() {

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

        $this->db->where('md5(id)', md5($id));

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
     * Busca o id e nome de todos os grupos cadastrados e os retorna na forma
     * de vetor
     * 
     * @name   get_array_grupos
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @return array Retorna um array contendo todos os registros
     */    
    function get_array_grupos(){
        
        $this->db->select('*');

        $this->db->from($this->tabela);

        // Executa a consulta
        $resultado = $this->db->get();
        
        // Se encontrou dados retorna um vetor com esses dados
        if($resultado->num_rows() > 0 ) {
            
            foreach ($resultado->result() as $grupo) {
                
                $array[$grupo->id] = $grupo->nome;
            }
            // Retorna um array onde a chave e o id e o valor e o nome
            return $array;
        }
        // Senão retorna um vetor vazio
        else {
            
            return array();
        }
        
    }

    /**
     * Insere um novo grupo
     * 
     * @name   insert
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  Object $grupo objeto contendo os dados do grupo a ser cadastrado
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function insert($grupo) {

        $this->db->insert($this->tabela, $grupo);

        // Força para que seja retornado um valor lógico
        return (bool) $this->db->affected_rows();
    }

    /**
     * Atualiza um grupo
     * 
     * @name   update
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  Object $grupo Dados a serem atualizados
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function update($grupo) {
        
        $this->db->where('md5(id)', md5($grupo->id));

        $this->db->update($this->tabela, $grupo);

        // Retorna um valor lógico indicando o resultado da operação.
        return (bool) $this->db->affected_rows();
    }

    /**
     * Deleta os grupos cujos ids foram recebidos por parametro
     * 
     * @name   delete
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012 
     * @param  array $ids ids dos grupos a serem removidos
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function delete($ids) {
        
        $this->db->where_in('id', $ids);

        $this->db->delete($this->tabela);

        // Força para que seja retornado um valor lógico
        return (bool) $this->db->affected_rows();
    }
    
    /**
     * Obtêm os grupos com acesso ao app
     * 
     * @name   get_app
     * @author Claudia dos Reis Silva <claudia.silva@tellks.com.br>
     * @since  09/07/2013
     * @param  void
     * @return array Array contendo os registros retornados
     */
    function get_frontend() {

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
     * Busca o(s) grupo(s) que o(s) usuario(s) passado(s) por parametro pertence
     * 
     * @name   get_usuario_grupo
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  22/07/2013
     * @return array Retorna um array contendo todos os grupos que os usuarios informados
     * peretencem
     */
    function get_usuario_grupo($usuarios) {
        
        $this->db->select('ug.grupo_id as id, g.nome');
        $this->db->from('usuario_grupo ug');
        $this->db->join('grupo as g', 'g.id = ug.grupo_id');
        $this->db->where_in('ug.usuario_id',$usuarios);
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0) {
            
            return $resultado->result();
        }
        else {
            
            return array();
        }
    }
}

?>
