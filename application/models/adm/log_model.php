<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model responsavel pela interacao com a tabela de log
 * 
 * @package   Models
 * @name      log_model
 * @author    Claudia dos Reis Silva claudia.silva@tellks.com.br
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     21/05/2013
 * 
 */
class log_model extends CI_Model{
    
    private $tabela = 'log';
    
    function __construct() {
        parent::__construct();
    }
    
    
    /**
     * Metodo responsavel por inserir dados na tabela de log assim que um usuario efetua login
     * 
     * @name   login
     * @author Claudia dos Reis Silva <claudia.silva@tellks.com.br>
     * @since  21/05/2013
     * @params array $dados array com os dados a serem inseridos
     * @return bool Retorna valor informando o resultado da operacao
     * 
     */
    function login($dados) {
        
        $this->db->insert($this->tabela,$dados);
        
        return (bool) $this->db->affected_rows();
        
    }
    
    /**
     * Metodo responsavel por buscar os dados na tabela de log de acordo com o usuario e data informados
     * 
     * @name   get_by_login
     * @author Claudia dos Reis Silva claudia.silva@tellks.com.br
     * @since  21/05/2013
     * @params int $id_u id do usuario
     * @param  timestamp $login data e hora do login
     * @return Object Quando encontra o log
     * @return array Quando nao encontra o log
     * 
     */
    function get_by_login($id_u,$login) {
        
       $this->db->select('*');
       $this->db->from($this->tabela);
       $this->db->where('usuario_id',$id_u);
       $this->db->where('login',$login);
       $dados =  $this->db->get();
       
       if($dados->num_rows() > 0) {
           return $dados->row(0);
       }
       else {
           return array();
       }
       
    }
    
    /**
     * Metodo responsavel por inserir o logout na tabela de log
     * 
     * @name   logout
     * @author Claudia dos Reis Silva claudia.silva@tellks.com.br
     * @since  21/05/2013
     * @param  array dados do log e horario de logout
     * @return void
     * 
     */
    function logout($dados) {
        $this->db->where('id',$dados['id']);
        $this->db->update($this->tabela,$dados);
    }
            
    /**
     * Atualiza o campo last_activity no log do usuario
     * 
     * @name   update_last_activity
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
     * @since  08/10/2013
     * @param  string $last_activity valor a ser atribuido ao campo last_activity
     * @return boolean Informa o resultado da operacao
     */
    function update_last_activity($last_activity){
        
        $this->db->where('id', $this->session->userdata('log_id'));
        
        return (bool) $this->db->update('log', array('last_activity' => $last_activity));
    }
    
    /**
     * Remove sessoes expiradas do banco
     * 
     * @name   remove_sessoes_expiradas
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
     * @since  08/10/2013
     * @return void
     */
    function remove_sessoes_expiradas(){
        
        // Clausulas que definem se uma sessao esta expirada
        $clausulas = array(
            'ip_address' => $this->session->userdata('ip_address'),
            'user_agent' => $this->session->userdata('user_agent'),
            'user_data !=' => '',
            'last_activity + ' . $this->config->item('sess_expiration') . ' < ' => $this->session->_get_time()
        );

        //Busca sessoes que obedecem as clausulas
        $sessao = $this->db->select('*')->from($this->config->item('sess_table_name'))->where($clausulas)->get();

        // Encontrou sessoes expiradas
        if ($sessao->num_rows() > 0) {

            // Itera sob o array dessas sessoes removendo-as
            foreach ($sessao->result() as $sess) {

                // Remove a sessao expirada do banco
                $this->db->delete($this->config->item('sess_table_name'), array('session_id' => $sess->session_id));
            }
        }
    }
}

?>
