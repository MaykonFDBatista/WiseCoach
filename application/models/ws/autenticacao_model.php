<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Model responsavel pela autenticacao do usuario
 * 
 * @package   models/adm
 * @name      Autenticacao_model
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     22/09/2013
 * 
 */
class Autenticacao_model extends CI_Model {

    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'doador';
    }

    /**
     * Autentica usuario no banco de dados
     * 
     * @name   autenticar
     * @author Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>   
     * @since  13/12/2012
     * @param  string $usuario email do ususario
     * @return array Qdo encontra algum registro retorna um Array com todos os registros que respeitam as clausulas
     * @return boolean Quando nao encontra nenhum registro
     */   
    function autenticar($email) {

        $this->db->select('u.id, u.nome, u.senha');
        $this->db->from('doador u');
        $this->db->where('u.email', $email);
        $this->db->where('u.ativo', '1');
        $this->db->where('id_facebook', null);
        $result = $this->db->get();

        if($result->num_rows() > 0){
            return $result;                    
        }
        else{
            return false;
        }
    }
    
    /**
     * Autentica usuario no banco de dados
     * 
     * @name   autenticar
     * @author Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>   
     * @since  13/12/2012
     * @param  string $usuario id do ususario
     * @return array Qdo encontra algum registro retorna um Array com todos os registros que respeitam as clausulas
     * @return boolean Quando nao encontra nenhum registro
     */   
    function get_by_usuario_id($usuario) {

        $this->db->select('u.*');
        $this->db->from('doador u');
        $this->db->where('u.id', $usuario);
        $this->db->where('id_facebook', null);
        $this->db->where_in('u.ativo', '1');
        $result = $this->db->get();
        
        if($result->num_rows() > 0){
            return $result;                    
        }
        else{
            return false;
        }
    }
    
    /**
     * Busca um usuario pelo email
     * 
     * @name   get_by_email
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
     * @since  24/09/2013
     * @param  string $email email do usuario
     * @return array Qdo encontra algum registro retorna um Array com todos os registros que respeitam as clausulas
     * @return boolean Quando nao encontra nenhum registro
     */   
    function get_by_email($email) {

        $this->db->select('*');
        $this->db->from('doador u');
        $this->db->where('u.email', $email);
        $this->db->where('id_facebook', null);
        $this->db->where_in('u.ativo', '1');
        $result = $this->db->get();

        if($result->num_rows() > 0){
            return $result;                    
        }
        else{
            return false;
        }
    }
    
    /**
     * Busca um usuario pelo email
     * 
     * @name   get_by_token
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
     * @since  24/09/2013
     * @param  string $token de redefinicao de senha
     * @return Object Qdo encontra algum registro retorna um objeto com os dados do usuario
     * @return boolean Quando nao encontra nenhum registro
     */   
    function get_by_token($token) {

        $data = date("Y-m-d H:m:s", time() - 86400);
        
        $this->db->select('*');
        $this->db->from('doador u');
        $this->db->where('md5(u.senha)', $token);
        $this->db->where('u.data_redefinir_senha > ', $data);
        $this->db->where('id_facebook', null);
        $this->db->where_in('u.ativo', '1');
        $result = $this->db->get();

        if($result->num_rows() > 0){
            return $result->row(0);                    
        }
        else{
            return false;
        }
    }

    /**
     * Seta o tempo que o usuario tem para redefinir sua senha usando um token
     * 
     * @name   seta_tempo_redefinir_senha
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
     * @since  25/09/2013
     * @param  string $email do usuario
     * @param  string $data  Data de envio do token de redefinicao de senha
     * @return boolean Informa o resultado da operacao
     */   
    function seta_tempo_redefinir_senha($email, $data) {

        $dados['data_redefinir_senha'] = $data;
        $this->db->where('email', $email);
        $this->db->where('id_facebook', null);
        $this->db->update($this->tabela, $dados);
        
        return (bool) $this->db->affected_rows();
    }
    
    /**
     * Altera a senha de um usuario de acordo com o token passado desde que o token
     * ainda nao tenha expirado.
     * 
     * @name   salvar_nova_senha
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
     * @since  25/09/2013
     * @param  string $token de alteracao
     * @param  string $nova_senha Nova senha criptografada
     * @return boolean Informa o resultado da operacao
     */   
    function salvar_nova_senha($token, $nova_senha) {

        $dados['senha'] = $nova_senha;
        $dados['data_redefinir_senha'] = '';
        
        $this->db->where('md5(senha)', $token);
        $this->db->where('id_facebook', null);
        $this->db->update('doador', $dados);
//        echo $this->db->last_query();
        return (bool) $this->db->affected_rows();
    }    
}