<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Model do menu principal da aplicacao
 * 
 * @package   Models
 * @name      Menu_model
 * @author    Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>
 * @copyright Copyright (c) 2012, Tellks - Solucoes em tecnologia ltda
 * @since     13/12/2012
 */

class Menu_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Busca todos os modulos
     * 
     * @name   get_menu
     * @author Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>
     * @since  13/12/2012
     * @param array $grupos grupos em que o usuario logado esta inserido
     * @return array Modulos que o usuario logado tem acesso
     */
    public function get_menu($grupos) {
        
        $this->db->select('m.id, m.nome');
        
        // Verifica se o usuario esta logado no backend
        // Se estiver deve ser feita consulta na tabela funcionalidade_grupo
        if($this->session->userdata('login_admin') == TRUE) {
            
            $this->db->from('funcionalidade_grupo fg');
            $prefixo_tabela = 'fg';
        }
        else {
            // Caso contrario deve ser feita a consulta na tabela funcionalidade_condominio
            $this->db->from('funcionalidade_app fc');
            $prefixo_tabela = 'fc';
            // Busca apenas os modulos com funcionalidades que o condominio tem acesso
            $this->db->where('fc.app_id', _app_id());
        }
        
        $this->db->join('funcionalidade f', 'f.id = ' . $prefixo_tabela . '.funcionalidade_id', 'inner');
        
        $this->db->join('modulo m', 'm.id = f.modulo_id', 'inner');
        
        $this->db->where('m.ativo > 0');
        
        if (sizeof($grupos) > 0) {

            $this->db->where_in($prefixo_tabela . '.grupo_id',$grupos);
        }
            
        $this->db->order_by('m.ordem', 'ASC');
        $this->db->distinct('m.id');
        
        $result = $this->db->get();
        
        if($result->num_rows() > 0 ) {
            
            return $result->result();
        }
        else {
            
            return array();
        }
    }
    
    /**
     * Busca as funcionalidades de um modulo que um usuario pode acessar no 
     * condominio em que ele está 
     * 
     * @name   get_item_menu
     * @author Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>
     * @since  13/12/2012
     * @param  array $Grupos grupos em que o usuario esta inserido
     * @param  int $idModulo Id do modulo
     * @param  string $acesso informa se o usuario esta tentando acessar o frontend ou backend
     * @return array Funcionalidades de um modulo que estao disponiveis para o usuario
     */
    public function get_item_menu($Grupos, $idModulo = null) {
        
        $this->db->select('f.id, f.modulo_id, f.nome, f.url');
        $this->db->from('funcionalidade f');
        
        $this->db->join('modulo m', 'm.id = f.modulo_id', 'inner');
            
        $this->db->join('funcionalidade_grupo fg', 'f.id = fg.funcionalidade_id', 'inner');
        $prefixo_tabela = 'fg';
        
        $this->db->where('f.modulo_id', $idModulo);
        
        $this->db->where_in($prefixo_tabela . '.grupo_id', $Grupos);

        $this->db->where('f.ativo', '1');
        $this->db->order_by('f.ordem', 'ASC');
        $this->db->distinct('f.nome');
        $result = $this->db->get();
        
        if($result->num_rows() > 0 ) {
            
            return $result->result();
        }
        else {
            
            return array();
        }
    }
    
    /**
     * Retorna infomacoes da funcionalidade cujo id foi passado por parametro
     * 
     * @name   get_by_id
     * @author Rafael Silva Frutuoso <rafael.frutuoso@tellks.com.br>
     * @since  13/12/2012
     * @params int $id Id da funcionalidade que se deseja obter informacoes
     * @return Object Dados da funcionalidade pesquisada
     */
    public function get_by_id($id) {
        
        $this->db->select('*');
        $this->db->from('funcionalidade');
        $this->db->where('id', $id);
        $result = $this->db->get();
        
        return $result->row(0);
        
    }

}