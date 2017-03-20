<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model responsavel pela interacao com a tabela sistema
 * 
 * @package   models/adm
 * @name      sistema_model
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     28/06/2013
 * 
 */
class sistema_model extends CI_Model{
    
    private $tabela;
    
     /**
     * Metodo construtor
     * 
     * @name _construct
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 28/06/2013
     * @param void
     * @return void
     */
    function __construct() {
        
        parent::__construct();
        
        $this->tabela = 'sistema';
    }
    
    /**
     * Busca as configuracoes do sistema
     * 
     * @name   get_configuracoes
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  28/06/2013
     * @return Object Retorna um objeto contendo todas as configuracoes dos sistema
     * @return boolean Caso a consulta ao banco nao retorne informacoes o sistema retorna FALSE
     */
    function get_configuracoes() {
        
        $this->db->select('*');
        $this->db->from($this->tabela);
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0) {
            
            return $resultado->row(0);
        }
        else {
            
            return FALSE;
        }
    }
    
    /**
     * Busca o status do sistema
     * 
     * @name   get_status
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since  28/06/2013
     * @return Object Retorna um objeto contendo o status do sistema
     * @return boolean Caso a consulta ao banco nao retorne informacoes o sistema retorna FALSE
     */
    function get_status() {
        
        $this->db->select('ativo,frontend_ativo');
        $this->db->from($this->tabela);
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0) {
            
            return $resultado->row(0);
        }
        else {
            
            return FALSE;
        }
    }
    
    /**
     * Atualiza um registro
     * 
     * @name   update
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
     * @since  28/06/2013
     * @param  Object $dados Dados a serem atualizados
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function update($dados) {
        
        $this->db->where('md5(id)', md5($dados->id));

        $this->db->update($this->tabela, $dados);

        // Retorna um valor lógico indicando o resultado da operação.
        return (bool) $this->db->affected_rows();
    }
}

?>
