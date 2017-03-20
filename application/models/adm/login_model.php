<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Model responsavel pela autenticacao do usuario
 * 
 * @package   models/adm
 * @name      login_model
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     22/09/2013
 * 
 */
class Login_model extends CI_Model {

    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'usuario';
    }

    /**
     * Autentica usuario e senha no banco de dados
     * 
     * @name   autenticar
     * @author Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>   
     * @since  13/12/2012
     * @param  int $usuario Id do ususario
     * @param  string $senha Senha do usuario
     * @return array Qdo encontra algum registro retorna um Array com todos os registros que respeitam as clausulas
     * @return boolean Quando nao encontra nenhum registro
     */   
    function autenticar($email, $acesso = 'frontend') {

        $this->db->select('u.id, u.nome, u.senha, ug.grupo_id, u.foto');
        $this->db->from('usuario u');
        $this->db->join('usuario_grupo ug', 'u.id = ug.usuario_id', 'inner');
        $this->db->join('grupo g', 'g.id = ug.grupo_id', 'inner');
        $this->db->where('u.email', $email);
        $this->db->where_in('u.ativo', array('1','2'));
        $this->db->where('g.acesso', $acesso);
        $this->db->order_by('ug.grupo_id','ASC');
        $result = $this->db->get();

        //Se query autenticou a conta, retorna registro
        if($result->num_rows() > 0){
            return $result;                    
        }
        else{
            return false;
        }
        
    }

}