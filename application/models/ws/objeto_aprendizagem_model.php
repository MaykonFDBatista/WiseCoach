<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

class Objeto_aprendizagem_model extends CI_Model {

    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'objeto_aprendizagem';
    }
    
    function get_por_problema($problema_id,$competidor_id){
        
        $this->db->select('oa.*, tipo.nome as tipo, tipo.icone, formato.mime_type as formato');

        $this->db->from('problema as p');
        
        $this->db->join('problema_materia as pm','pm.problema_id = p.id');
        
        $this->db->join('objeto_aprendizagem_materia as oam','oam.materia_id = pm.materia_id');
        
        $this->db->join($this->tabela . ' as oa','oam.objeto_aprendizagem_id = oa.id');
        
        $this->db->join('objeto_aprendizagem_estilo_aprendizagem as oae','oae.objeto_aprendizagem_id = oa.id','LEFT');

        $this->db->join('competidor_estilo_aprendizagem as ce','ce.estilo_aprendizagem_id = oae.estilo_aprendizagem_id','LEFT');
        
        $this->db->join('tipo_objeto_aprendizagem as tipo','tipo.id = oa.tipo_id','LEFT');
        
        $this->db->join('formato_objeto_aprendizagem as formato','formato.id = oa.formato_id','LEFT');
        
        $this->db->where('p.id', $problema_id);
        
        if($competidor_id > 0) {
            $this->db->where('(ce.competidor_id = ' . $competidor_id . ' OR ce.competidor_id IS NULL)');
        }
        
        $this->db->group_by('oa.id');
        
        $this->db->order_by('max(ce.pontuacao)','DESC');
        
        $this->db->order_by('oa.titulo','ASC');

        $resultado = $this->db->get();

        if ($resultado->num_rows > 0) {
            
            return $resultado->result();
            
        }
        else {

            return array();
        }
    }
    
    function get_by_id($id) {

        $this->db->select('oa.*,f.extensao,f.mime_type,t.nome as tipo');

        $this->db->from($this->tabela . ' as oa');
        
        $this->db->join('formato_objeto_aprendizagem as f','f.id = oa.formato_id','LEFT');

        $this->db->join('tipo_objeto_aprendizagem as t','t.id = oa.tipo_id','LEFT');
        
        $this->db->where('oa.id', $id);

        // Executa a consulta 
        $resultado = $this->db->get();

        $objeto_aprendizagem = FALSE;
        // Se encontrou algum dado, retorna o dado encontrado
        if ($resultado->num_rows > 0) {

            $objeto_aprendizagem = $resultado->row(0);
            
            if($objeto_aprendizagem) {
                $objeto_aprendizagem->materias = $this->get_materias($objeto_aprendizagem->id);
                $objeto_aprendizagem->estilos_aprendizagem = $this->get_estilos($objeto_aprendizagem->id);
            }
        }

        return $objeto_aprendizagem;
    }
    
    function get_materias($objeto_aprendizagem_id) {

        $this->db->select('m.*');

        $this->db->from('objeto_aprendizagem_materia as oam');

        $this->db->join('materia as m','m.id = oam.materia_id');
                
        $this->db->where('oam.objeto_aprendizagem_id', $objeto_aprendizagem_id);
        
        // Executa a consulta 
        $resultado = $this->db->get();

        // Se encontrou algum dado, retorna o dado encontrado
        if ($resultado->num_rows > 0) {

            return $resultado->result();
        }
        // Senao retorna FALSO
        else {

            return array();
        }
    }
    
    function get_estilos($objeto_aprendizagem_id) {

        $this->db->select('e.*');

        $this->db->from('objeto_aprendizagem_estilo_aprendizagem as oae');

        $this->db->join('estilo_aprendizagem as e','e.id = oae.estilo_aprendizagem_id');
                
        $this->db->where('oae.objeto_aprendizagem_id', $objeto_aprendizagem_id);
        
        // Executa a consulta 
        $resultado = $this->db->get();

        // Se encontrou algum dado, retorna o dado encontrado
        if ($resultado->num_rows > 0) {

            return $resultado->result();
        }
        // Senao retorna FALSO
        else {

            return array();
        }
    }
}