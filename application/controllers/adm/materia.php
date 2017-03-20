<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Controller responsável pelo gerenciamento dos materias do sistema
 * 
 * @package Controllers/adm
 * @name Materia
 * @author Alex Santini <alex.santini@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Materia extends CI_Controller {
    
    /**
     * Método construtor
     * 
     * @name _construct
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function __construct() {
        
        parent::__construct();

        _login_admin();
        _access_admin(40);

        // Carrega as Models da aplicação
        $this->load->model($this->config->item('admin') . 'materia_model');
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios','menu','mensagens','data'); 
        
        $this->load->language($arquivos, $this->session->userdata('idioma'));
    }

    /**
     * Index. Redireciona para 'materia/all'
     * 
     * @name index
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function index() {
        
        // 'Delega' para o método all() logo abaixo
        $this->all();
    }

    /**
     * Exibe todos os materias
     * 
     * @name all
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param int $apartir_de A partir de quantos registros começa a seleção
     * @return void
     */
    public function all($apartir_de = 0) {
        
        $this->load->library('filtro_library');

        $controladora = 'materia';
        $model = 'materia_model';
        $url = $this->config->item('admin') . 'materia/all';
        $por_pagina = $this->input->post('por_pagina');
        $campos = array(
            'id'    => _lang('form_id'),
            'nome'  => _lang('form_nome'),
        );

        $this->filtro_library->init($controladora, $model, $url, $por_pagina, $campos,'data_registro');

        // Campo a ser filtrado
        $filtro['campo'] = $this->input->post('campo');
        // Valor ao qual vai ocorrer a filtragem
        $filtro['valor']['value'] = $this->input->post('valor');
        // Rotulo que aparecera na tela para esse valor
        $filtro['valor']['label'] = $this->input->post('valor');
        
        $data['inicial'] = $this->input->post('data_inicial');
        $data['final']   = $this->input->post('data_final');

        
        $dados['filtro'] = $this->filtro_library->gerar_filtro($apartir_de, $filtro,$data);   
        $dados['menu']   = $this->menu_library->menu_admin();
        
        $fnd = $this->menu_model->get_by_id(40);
        $dados['titulo']   = $fnd->nome;
        $dados['conteudo'] = $this->config->item('admin') . $fnd->url;
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 40;
                
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Mostra o formulario de cadastro de novo materia
     * 
     * @name novo
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function novo() {
    
        $dados['materias']   = $this->materia_model->get_all_adm();
        
        $dados['menu'] = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_novo') . '&nbsp;' . _lang('menu_materia');
        $dados['conteudo']     = $this->config->item('admin') . 'materia/editar';
        $dados['url']          = $this->config->item('admin') . 'materia/cadastrar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'materia';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 40;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/materia.js';          
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Insere um novo materia
     * 
     * @name cadastrar
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function cadastrar() {
        
        $dados = new stdClass();
        $dados->nome  = $this->input->post('mat_nome');
        $submateria = $this->input->post('mat_submateria_de');
        $dados->submateria_de = empty($submateria) ? NULL : $submateria;
        
        $resultado = $this->materia_model->insert($dados);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_insert-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'materia', 'refresh');
    }
    
    /**
     * Metodo de edição
     * 
     * @name editar
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param int $id Id do materia
     * @return void
     */
    public function editar($id) {
        
        $dados['materias']   = $this->materia_model->get_all_adm();
        
        // Acessa o Model
        $dados['materia'] = $this->materia_model->get_by_id($id);
        $dados['menu']   = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_editar') . '&nbsp;' . _lang('menu_materia');
        $dados['conteudo']     = $this->config->item('admin') . 'materia/editar';
        $dados['url']          = $this->config->item('admin') . 'materia/atualizar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'materia';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 40;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/materia.js';          
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Processa uma atualização
     * 
     * @name atualizar
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function atualizar() {

        // Cria um objeto que recebe os dados enviados via post
        $dados = new stdClass();
        $dados->id    = (int)$this->input->post('mat_id');
        $dados->nome  = $this->input->post('mat_nome');
        $submateria = $this->input->post('mat_submateria_de');
        $dados->submateria_de = empty($submateria) ? NULL : $submateria;
       
        // Chama o Model e pede para atualizar o materia
        $resultado = $this->materia_model->update($dados);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_update-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'materia', 'refresh');
    }

    /**
     * Remove um Materia
     * 
     * @name remover
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param string/array $ids ids dos materias a serem removidos
     * @return void
     */
    public function remover($ids) {
        
        // Transforma a string recebida em array
        if(is_string($ids)) {
            
            $ids = explode('-', $ids);
        }
        $resultado = $this->materia_model->delete($ids);

        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_delete-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'materia', 'refresh');
    }

}

?>
