<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * Brasil Card
 * Sistema de análise de crédito
 *  
 * @author Tellks Tecnologia <tellks.com.br>
 * @copyright Copyright (c) 2012, Tellks - Solucoes em tecnologia ltda
 * @link http://tellks.com.br
 */

/**
 * 
 * Classe Cidade_model
 * Model de iteração com a tabela "cidade". 
 * 
 * @package Models
 */

class Cidade_model extends CI_Model {

    public $tabela;

    public function __construct() {
        parent::__construct();
        $this->tabela = 'cep_cidade';
    }

    function get_all($de = 0, $quantidade = 10) {        
        $this->db->select('*');        
        return $this->db->get($this->tabela);
    }
    
    
    /**
     * Retorna todas as UFs cadastradas
     * @name   Get_UFs
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @param  void
     * @since  25/06/2013
     * @return  array
     */
    public function get_UFs() {
        
        $this->db->select('uf')->from('cep_estado')->group_by('uf');
        
        $ufs = $this->db->get();
        
        $result = array();
        
        if($ufs->num_rows() > 0) {
            
            foreach ($ufs->result() as $uf) {
                
                $result[$uf->uf] = $uf->uf;
            }
        }
        
        return $result;
    }

    public function get_uf_by_cidade($id) {
        $this->db->select('fk_uf')->from($this->tabela)->where('id_cidade', $id);
        return $this->db->get()->row(0)->fk_uf;
    }
    
    public function get_cep_by_cidade($id) {        
        $this->db->select('cep')->from('cep_logradouro')->where('fk_id_cidade', $id);
        return $this->db->get()->row(0)->cep;
    }
    

    public function get_cid_UF($uf) {
        $cid = array('fk_uf' => $uf);
        $this->db->select('*')->from($this->tabela)->where($cid);
        $cidades =  $this->db->get();
        
        if($cidades->num_rows() > 0) {
            
            foreach ($cidades->result() as $cidade) {
                
                $result[$cidade->id_cidade] = $cidade->cidade;
            }
        }
        
        return $result;
        
    }

    public function get_by_id($id) {
        $this->db->select('*');
        $this->db->from($this->tabela);
        $this->db->where('md5(id_cidade)', md5($id));
        $resultado = $this->db->get();
        return $resultado->row(0);
    }
    
    public function get_by_CEP($cep) {
        
        $this->db->select('cep.cep,cep.logradouro,cep.fk_id_cidade,bairro.bairro,cidade.fk_uf');
        $this->db->from('cep_logradouro as cep');
        $this->db->join('cep_cidade as cidade', 'cidade.id_cidade = cep.fk_id_cidade');
        $this->db->join('cep_bairro as bairro', 'bairro.id_bairro = cep.fk_id_bairro');
        $this->db->where('cep.cep', $cep);
        $resultado = $this->db->get();
        //echo $this->db->last_query();
        if($resultado->num_rows() > 0)
        {
           return $resultado->row(0);
        }
        else
        {
            return false;
        }
    }

    /**
     * Busca todas as cidade de uma UF
     * @name   Get_cidade
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @param  string
     * @since  24/06/2013
     * @return  CI_MYSQL Object
     */
    public function getCidade($uf) {
        
        $this->db->select('id_cidade, cidade as nome')->from($this->tabela)->where('fk_uf', $uf);
        
        $cidades =  $this->db->get();
        
        return $cidades;
    }
    
}
?>
