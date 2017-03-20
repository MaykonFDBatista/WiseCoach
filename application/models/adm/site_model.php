<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model responsavel pela interacao com a tabela sistema
 * 
 * @package   models/adm
 * @name      site_model
 * @author    Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
 * @copyright Copyright (c) 2015, Tellks - Solucoes em tecnologia ltda
 * @since     07/01/2015
 * 
 */
class Site_model extends CI_Model{
    
    private $tabela;
    
     /**
     * Metodo construtor
     * 
     * @name _construct
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
     * @since 07/01/2015
     * @param void
     * @return void
     */
    function __construct() {
        
        parent::__construct();
        
        $this->tabela = 'website';
    }
    
    /**
     * Busca os dados do site
     * 
     * @name   get_all
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
     * @since 07/01/2015
     * @return Object Retorna um objeto contendo todas os dados do site
     * @return boolean Caso a consulta ao banco nao retorne informacoes o sistema retorna FALSE
     */
    function get_all() {
        
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
     * Atualiza um registro
     * 
     * @name   update
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br> 
     * @since  07/01/2015
     * @param  Object $dados Dados a serem atualizados
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function update($dados) {

        $this->db->update($this->tabela, $dados);

        // Retorna um valor lógico indicando o resultado da operação.
        return (bool) $this->db->affected_rows();
    }
    
    /**
     * Salva a qnt de sonhos que doador pode realizar simultaneamente
     * 
     * @name   qnt_sonhos_realizando
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br> 
     * @since  27/01/2015
     * @param  int $qnt A qnt de sonhos simultaneos
     * @return bool Retorna valor informando o resultado da operacao
     */ 
    function qnt_sonhos_realizando($qnt) {

        $this->db->update($this->tabela, array('limite_sonhos' => $qnt));

        // Retorna um valor lógico indicando o resultado da operação.
        return (bool) $this->db->affected_rows();
    }
}

?>
