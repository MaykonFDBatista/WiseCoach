<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Model responsavel pela interacao com a tabela de funcionalidades
 * 
 * @package   models/adm
 * @name      funcionalidade_model
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @copyright Copyright (c) 2012, Tellks - Solucoes em tecnologia ltda
 * @since     13/12/2012
 * 
 */

class funcionalidade_model extends CI_Model{
    
    private $tabela;

    public function __construct() {
        parent::__construct();
        $this->tabela = 'funcionalidade';
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
        
        // Se encontrou dados retorna um array com esses dados
        if($resultado->num_rows() > 0 ){
            return $resultado->result();
        }
        // Senão retorna um array vazio
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
        
        if($de >= 0 && $quantidade > 0)$this->db->limit($quantidade, $de);

        // Executa a consulta
        $resultado = $this->db->get();

        // Se encontrou registros retorna um array com esses registros
        if($resultado->num_rows() > 0 ){
            return $resultado->result();
        }
        // Senão retorna um array vazio
        else{
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

        if ($resultado->num_rows > 0) {

            return $resultado->row(0);            
        }
        else {

            return FALSE;
        }
    }

    /**
     * Busca os grupos com acesso a funcionalidade cujo id foi recebido por 
     * parametro
     * 
     * @name   get_grupos_acesso
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  int $id Id da funcionalidade
     * @return array Retorna um array com os Ids dos grupos com acesso a funcionalidade
     * @return boolean Qdo nao encontra nenhum grupo com acesso a funcionalidade retorna FALSE
     */    
    function get_grupos_acesso($id){
        
        $this->db->select('fg.grupo_id');

        $this->db->from($this->tabela . ' as f');
        
        $this->db->join('funcionalidade_grupo as fg','fg.funcionalidade_id = f.id');

        $this->db->where('md5(id)', md5($id));

        // Executa a consulta 
        $resultado = $this->db->get();

        if ($resultado->num_rows > 0) {

            foreach ($resultado->result() as $grupo){
                $array[] = $grupo->grupo_id;
            }
            return $array;
        }
        else {

            return FALSE;
        }
    }
        
    /**
     * Insere uma nova funcionalidade
     * 
     * @name   insert
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  Object $funcionalidade objeto contendo os dados da funcionalidade a ser cadastrada
     * @param  array $grupos Ids dos grupos com acesso a funcionalidade recem cadastrada
     * @return bool Retorna valor informando o resultado da operacao
     */    
    function insert($funcionalidade,$grupos) {
        
        $this->db->insert($this->tabela, $funcionalidade);

        $id = $this->db->select('id')->from($this->tabela)->where('url', $funcionalidade->url)->get()->row(0)->id;

        for ($i = 0; $i < sizeof($grupos); $i++) {

            $this->db->insert('funcionalidade_grupo', array('funcionalidade_id' => $id, 'grupo_id' => $grupos[$i]));
        }

        // Força para que seja retornado um valor lógico
        return (bool) $this->db->affected_rows();
    }

    /**
     * Atualiza uma funcionalidade
     * 
     * @name   update
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  Object $funcionalidade Dados a serem atualizados
     * @param  array $grupos Ids dos grupos com acesso a funcionalidade
     * @return bool Retorna valor informando o resultado da operacao
     */    
    function update($funcionalidade,$grupos) {
        
        // Remove o acesso de todos os grupos
        $rem = $this->db->delete('funcionalidade_grupo','funcionalidade_id = '.$funcionalidade->id);
  
        // Concede o acesso aos grupos selecionados
        for ($i = 0; $i < sizeof($grupos); $i++) {

            $acesso = array(
                'funcionalidade_id' => $funcionalidade->id,
                'grupo_id' => $grupos[$i]
            );

            $ins = $this->db->insert('funcionalidade_grupo', $acesso);
        }
        
        $this->db->where('md5(id)', md5($funcionalidade->id));

        $this->db->update($this->tabela, $funcionalidade);
        
        return ((bool) ($this->db->affected_rows()) || ((bool)$rem || (bool)$ins));
    }

    /**
     * Deleta uma funcionalidade
     * 
     * @name   delete
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012 
     * @param  array $ids ids das funcionalidades a serem removidas
     * @return bool Retorna valor informando o resultado da operacao
     */    
    function delete($ids) {
        
        $this->db->where_in('id', $ids);

        $this->db->delete($this->tabela);

        // Força para que seja retornado um valor lógico
        return (bool) $this->db->affected_rows();
    }
    
    /**
     * Verifica se um usuario tem acesso a uma funcionalidade
     * 
     * @name   tem_acesso
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012 
     * @param  int $funcionalidade Id da funcionalidade
     * @param  array $Grupos grupos em que o usuario está inserido
     * @return boolean Retorna se possui acesso(TRUE) ou nao(FALSE)
     */    
    function tem_acesso($funcionalidade, $Grupos) {
        
        if(_is_super_user()) return TRUE;
        
        $this->db->select('*');
        
        $this->db->from('funcionalidade_grupo');
        
        $condicoes = array('funcionalidade_id'=>$funcionalidade,'grupo_id'=>$Grupos[0]);
        
        $this->db->where($condicoes);
        if(sizeof($Grupos) > 1){
            for($i=1; $i<sizeof($Grupos); $i++){
                  $condicoes = array('funcionalidade_id'=>$funcionalidade,'grupo_id'=>$Grupos[$i]);
                  $this->db->or_where($condicoes);
            }
        }
        
        $resultado = $this->db->get(); 
        
        if ($resultado->num_rows == 0) {
            
            return FALSE;        
        } else {
            
            return TRUE; 
        }
        
    }

}

?>
