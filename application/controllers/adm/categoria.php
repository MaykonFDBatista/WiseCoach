<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Controller responsável pelo gerenciamento dos categorias do sistema
 * 
 * @package Controllers/adm
 * @name Categoria
 * @author Alex Santini <alex.santini@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Categoria extends CI_Controller {
    
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
        _access_admin(39);

        // Carrega as Models da aplicação
        $this->load->model($this->config->item('admin') . 'categoria_model');
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios','mensagens','data'); 
        
        $this->load->language($arquivos, $this->session->userdata('idioma'));
    }

    /**
     * Index. Redireciona para 'categoria/all'
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
     * Exibe todos os categorias
     * 
     * @name all
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param int $apartir_de A partir de quantos registros começa a seleção
     * @return void
     */
    public function all($apartir_de = 0) {
        
        $this->load->library('filtro_library');

        $controladora = 'categoria';
        $model = 'categoria_model';
        $url = $this->config->item('admin') . 'categoria/all';
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
        
        $fnd = $this->menu_model->get_by_id(39);
        $dados['titulo']   = $fnd->nome;
        $dados['conteudo'] = $this->config->item('admin') . $fnd->url;
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 39;
                
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Mostra o formulario de cadastro de novo categoria
     * 
     * @name novo
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function novo() {
       
        $dados['menu'] = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_novo') . '&nbsp;' . _lang('menu_categoria');
        $dados['conteudo']     = $this->config->item('admin') . 'categoria/editar';
        $dados['url']          = $this->config->item('admin') . 'categoria/cadastrar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'categoria';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 39;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/categoria.js';          
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Insere um novo categoria
     * 
     * @name cadastrar
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function cadastrar() {
        
        $dados = new stdClass();
        $dados->nome  = $this->input->post('cat_nome');

        $resultado = $this->categoria_model->insert($dados);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_insert-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'categoria', 'refresh');
    }
    
    /**
     * Metodo de edição
     * 
     * @name editar
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param int $id Id do categoria
     * @return void
     */
    public function editar($id) {
        
        // Acessa o Model
        $dados['categorias'] = $this->categoria_model->get_by_id($id);
        $dados['menu']   = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_editar') . '&nbsp;' . _lang('menu_categoria');
        $dados['conteudo']     = $this->config->item('admin') . 'categoria/editar';
        $dados['url']          = $this->config->item('admin') . 'categoria/atualizar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'categoria';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 39;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/categoria.js';          
        
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
        $dados->id    = (int)$this->input->post('cat_id');
        $dados->nome  = $this->input->post('cat_nome');
       
        // Chama o Model e pede para atualizar o categoria
        $resultado = $this->categoria_model->update($dados);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_update-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'categoria', 'refresh');
    }

    /**
     * Remove um Categoria
     * 
     * @name remover
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 2013
     * @param string/array $ids ids dos categorias a serem removidos
     * @return void
     */
    public function remover($ids) {
        
        // Transforma a string recebida em array
        if(is_string($ids)) {
            
            $ids = explode('-', $ids);
        }
        $resultado = $this->categoria_model->delete($ids);

        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_delete-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'categoria', 'refresh');
    }

}

?>
