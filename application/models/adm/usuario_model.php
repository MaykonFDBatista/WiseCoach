<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Model responsavel pela interacao com a tabela de usuarios
 * 
 * @package   models/adm
 * @name      usuario_model
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @copyright Copyright (c) 2012, Tellks - Solucoes em tecnologia ltda
 * @since     13/12/2012
 * 
 */
class Usuario_model extends CI_Model {

    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'usuario';
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
     * Busca os grupos em que o usuario cujo id foi recebido por 
     * parametro esta inserido
     * 
     * @name   get_usuario_grupos
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  13/12/2012
     * @param  int $id Id do usuario
     * @return array Retorna um array com os Ids dos grupos em que o usuario esta inserido
     * @return boolean Qdo nao encontra nenhum grupo com acesso a funcionalidade retorna FALSE
     */
    function get_usuario_grupos($id){
        
        $this->db->select('ug.grupo_id');

        $this->db->from($this->tabela . ' as u');
        
        $this->db->join('usuario_grupo as ug','ug.usuario_id = u.id');

        $this->db->where('md5(id)', md5($id));

        // Executa a consulta 
        $resultado = $this->db->get();

        if ($resultado->num_rows > 0) {

            foreach ($resultado->result() as $grupo) {
                
                $array[] = $grupo->grupo_id;
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
     * @param  Object $usuario objeto contendo os dados do usuario a ser cadastrado
     * @param  array $grupos Ids dos grupos em que o usuario esta inserido
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function insert($usuario,$grupos) {
        
        $this->db->insert($this->tabela, $usuario);
        
        $resultado = $this->db->affected_rows();        
        
        $id = $this->db->select('id')->from($this->tabela)->where('email',$usuario->email)->get()->row(0)->id;
        
        for ($i = 0; $i < sizeof($grupos); $i++) {
            
            $this->db->insert('usuario_grupo', array('usuario_id' => $id, 'grupo_id' => $grupos[$i]));
        }

        if ($resultado > 0) {

            return $id;
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
     * @param  Object $usuario Dados a serem atualizados
     * @param  array $grupos Ids dos grupos em que o usuario esta inserido
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function update($usuario, $grupos = NULL) {

        $update_grupos = FALSE;
        if ($grupos) {
            // Remover o acesso de todos os gurpos
            $this->db->delete('usuario_grupo', 'usuario_id = ' . $usuario->id);

            // Concede o acesso aos grupos selecionados
            for ($i = 0; $i < sizeof($grupos); $i++) {
                $this->db->insert('usuario_grupo', array('usuario_id' => $usuario->id, 'grupo_id' => $grupos[$i]));
            }
            $update_grupos = (bool) $this->db->affected_rows();
        }
        $this->db->where('md5(id)', md5($usuario->id));
        $this->db->update($this->tabela, $usuario);
        $update_usuario = (bool) $this->db->affected_rows();
        
        return ($update_grupos || $update_usuario);
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