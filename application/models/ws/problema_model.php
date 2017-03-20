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
class Problema_model extends CI_Model {

    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'problema';
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
    function get_all_ws($competidor_id = NULL) {

        $resolvido = '(SELECT COUNT(*) FROM submissao as s WHERE s.problema_id = p.id AND resposta = 1 AND competidor_id = ' . ((!empty($competidor_id)) ? $competidor_id : 'NULL') . ') as resolvido';
        
        $this->db->select('p.*, c.nome as categoria, ' . $resolvido);

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

    function get_by_categoria($categoria_id, $competidor_id = NULL) {

        if($competidor_id != NULL && $competidor_id > 0) {
            $resolvido = '(SELECT COUNT(*) FROM submissao as s WHERE s.problema_id = p.id AND resposta = 1 AND competidor_id = ' . $competidor_id . ') as resolvido';
        }
        else {
            $resolvido = '(SELECT COUNT(*) FROM submissao as s WHERE s.problema_id = p.id AND resposta = 1 AND competidor_id IS NULL) as resolvido';
        }
        
        $this->db->select('p.*, c.nome as categoria, ' . $resolvido);

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('categoria as c','p.categoria_id = c.id');
        
        $this->db->where('p.ativo', 1);

        $this->db->where('p.categoria_id', $categoria_id);
        
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

        $qtd_submissoes = '(SELECT COUNT(submissao.id) FROM submissao WHERE submissao.problema_id = p.id) as qtd_submissoes';
        
        $this->db->select('p.*, c.nome as categoria,' . $qtd_submissoes);

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
     
    function get_all_com_dicas() {
        
        $this->db->select('p.*, c.nome as categoria, ');

        $this->db->from($this->tabela . ' as p');
        
        $this->db->join('categoria as c','p.categoria_id = c.id');
        
        $this->db->where('p.ativo', 1);

       $this->db->where("(dicas IS NOT NULL AND dicas != '')");
        
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