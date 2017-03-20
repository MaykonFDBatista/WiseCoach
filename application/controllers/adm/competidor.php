<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * Controller de gerenciamento de comários pela administração.
 * 
 * @package Controllers/adm
 * @name Competidor
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Competidor extends CI_Controller {
    
    /**
     * Método construtor
     * 
     * @name _construct
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function __construct() {
        
        parent::__construct();

        _login_admin();
        _access_admin(37);

        // Carrega as Models utilizadas
        $this->load->model(array($this->config->item('admin') . 'categoria_model',
                                 $this->config->item('admin') . 'materia_model',
                                 $this->config->item('admin') . 'competidor_model'));
        
        $this->load->config('problema');
        
        // Carrega o helper de criptografia de senhas
        $this->load->helper('tk_joomla_encrypt_password');
        
        // Carrega as configuracoes dos idiomas disponiveis caso o competidor deseje 
        // alterar o idioma do sistema em seu perfil
        $this->load->config('linguagens');
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios','mensagens','grupos_usuario', 'my_form_validation','data'); 
        
        $this->load->language($arquivos, $this->session->userdata('idioma'));
    }
    
    /**
     * Redireciona para o metodo all
     * 
     * @name index
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function index() {

        $this->all();
    }

    /**
     * Exibe todos os competidors
     * 
     * @name all
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param int $apartir_de A partir de quantos registros começa a seleção
     * @return void
     */
    public function all($apartir_de = 0) {

        $this->load->library('filtro_library');
        
        $controladora = 'competidor';
        $model = 'competidor_model';
        $url = $this->config->item('admin') . 'competidor/all';
        $por_pagina = $this->input->post('por_pagina');
        $campos = array(
            'id'     => _lang('form_id'),
            'nome'   => _lang('form_nome'),
            'email'  => _lang('form_email')
        );
        

        $this->filtro_library->init($controladora, $model, $url, $por_pagina, $campos,'data_registro', $Status = array('1' => _lang('form_ativo'), '0' => _lang('form_inativo')));
        
        // Campo a ser filtrado
        $filtro['campo'] = $this->input->post('campo');
        // Valor ao qual vai ocorrer a filtragem
        $filtro['valor']['value'] = $this->input->post('valor');
        // Rotulo que aparecera na tela para esse valor
        $filtro['valor']['label'] = $this->input->post('valor');
        
        $data['inicial'] = $this->input->post('data_inicial');
        $data['final']   = $this->input->post('data_final');

        // Se esta setado para utilizar o filtro por status
        $status = $this->input->post('status');
        
        $dados['filtro']   = $this->filtro_library->gerar_filtro($apartir_de, $filtro,$data,$status);
        $dados['menu']     = $this->menu_library->menu_admin();
        $fnd = $this->menu_model->get_by_id(37);
        $dados['titulo']   = $fnd->nome;
        $dados['conteudo'] = $this->config->item('admin') . $fnd->url;
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 37;

        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }
    
    /**
     * Mostra o formulario de cadastro de novo competidor
     * 
     * @name novo
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function novo() {
       
        $dados['categorias'] = $this->categoria_model->get_all_adm();
        $dados['materias']   = $this->materia_model->get_all_adm();
        
        $dados['menu'] = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_novo') . '&nbsp;' . _lang('menu_competidor');
        $dados['conteudo']     = $this->config->item('admin') . 'competidor/editar';
        $dados['url']          = $this->config->item('admin') . 'competidor/cadastrar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'competidor';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 37;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/competidor.js';
        $dados['assets_js'][] = 'ajax/competidor.js';
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        $dados['template_js'][] = 'lib/complexify/jquery.complexify.banlist.js';
        $dados['template_js'][] = 'lib/complexify/jquery.complexify.min.js';
        // Carrega os javascript de mascara
//        $dados['template_js'][] = 'plugins/forms/jquery.form.js';
//        $dados['template_js'][] = 'plugins/forms/jquery.inputmask.js';
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Insere um novo competidor
     * 
     * @name cadastrar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @return boolean 
     */
    public function cadastrar() {

        $dados = new stdClass();

        $dados->nome = $this->input->post('com_nome');

        // Pega a senha informada pelo competidor
        $dados->senha = $this->input->post('com_senha');

        // Gera um salt randomico
        $salt = genRandomPassword(32);

        // Criptografa a senha informada com o salt gerado randomicamente
        $crypt = getCryptedPassword($dados->senha, $salt);

        // Salva a senha criptorafada concatenada com o salt
        $dados->senha = $crypt . ':' . $salt;

        $dados->telefone = $this->input->post('com_telefone');
        $dados->celular  = $this->input->post('com_celular');
        $dados->email    = $this->input->post('com_email');
        $dados->ativo    = $this->input->post('com_ativo');
        $dados->idioma   = $this->input->post('com_idioma');
        $dados->nivel_id    = $this->input->post('com_nivel');

        $categorias = $this->input->post('com_categorias');
        $materias = $this->input->post('com_materias');
        
        $resultado = $this->competidor_model->insert($dados, $categorias, $materias);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ((bool)$resultado == TRUE) {

            $this->session->set_flashdata('msg', 'msg_insert-ok');
        } else {

            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'competidor', 'refresh');

    }

    /**
     * Metodo de edição
     * 
     * @name editar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param int $id id do competidor
     * @return void
     */
    public function editar($id) {
       
        $dados['categorias']   = $this->categoria_model->get_all_adm();
        $dados['materias']     = $this->materia_model->get_all_adm();
        
        $dados['possui_categorias'] = $this->competidor_model->get_competidor_categorias($id);
        $dados['possui_materias']   = $this->competidor_model->get_competidor_materias($id);
        
        $dados['competidor']  = $this->competidor_model->get_by_id($id);
        $dados['menu']        = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_editar') . '&nbsp;' . _lang('menu_competidor');
        $dados['conteudo']     = $this->config->item('admin') . 'competidor/editar';
        $dados['url']          = $this->config->item('admin') . 'competidor/atualizar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'competidor';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 37;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/competidor.js';
        $dados['assets_js'][] = 'ajax/competidor.js';
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        $dados['template_js'][] = 'lib/complexify/jquery.complexify.banlist.js';
        $dados['template_js'][] = 'lib/complexify/jquery.complexify.min.js';
//        $dados['template_js'][] = 'lib/jqamp-ui-spinner/compiled/jqamp-ui-spinner.min.js';
//        $dados['template_js'][] = 'lib/jqueryUI/jquery-ui-1.10.2.custom.min.js';
//        $dados['template_js'][] = 'form/jquery.progressbar.anim.min.js';
        
        // Carrega os javascript de mascara
//        $dados['template_js'][] = 'plugins/forms/jquery.form.js';
//        $dados['template_js'][] = 'plugins/forms/jquery.inputmask.js';
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Processa uma atualização
     * 
     * @name atualizar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function atualizar() {

        // Cria um objeto que recebe os dados enviados via post
        $dados = new stdClass();
        
        $dados->id      = (int)$this->input->post('com_id');
        $dados->nome    = $this->input->post('com_nome');
        
        if($this->input->post('com_senha') != '') {
            
            // Gera um salt randomico
            $salt = genRandomPassword(32);
        
            // Criptografa a senha informada com o salt
            $crypt = getCryptedPassword($this->input->post('com_senha'), $salt);
        
            // Concatena a senha criptografada com o salt
            $dados->senha = $crypt . ':' . $salt;
        }
        
        $dados->telefone = $this->input->post('com_telefone');
        $dados->celular  = $this->input->post('com_celular');
        $dados->email    = $this->input->post('com_email');
        $dados->ativo    = $this->input->post('com_ativo');
        $dados->idioma   = $this->input->post('com_idioma');
        $dados->nivel_id    = $this->input->post('com_nivel');
        
        $categorias = $this->input->post('com_categorias');
        $materias   = $this->input->post('com_materias');
       
        // Chama o Model e pede para atualizar a competidor
        $resultado = $this->competidor_model->update($dados,$categorias, $materias);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_update-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }
                
        // Redireciona
        redirect($this->config->item('admin') . 'competidor', 'refresh');
    }
    
    /**
     * Remove um competidor
     * 
     * @name remover
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param string/array $ids ids dos competidors a serem removidos
     * @return void
     */
    public function remover($ids) {
        
        // Transforma a string recebida em array
        if(is_string($ids)) {
            
            $ids = explode('-', $ids);
        }
        $resultado = $this->competidor_model->delete($ids);

        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_delete-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'competidor', 'refresh');
    }
    
}