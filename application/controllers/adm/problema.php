<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * Controller de gerenciamento de problemas pela administração.
 * 
 * @package Controllers/adm
 * @name Problema
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Problema extends CI_Controller {
    
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
        _access_admin(38);

        // Carrega as Models utilizadas
        $this->load->model(array($this->config->item('admin') . 'categoria_model',
                                 $this->config->item('admin') . 'materia_model',
                                 $this->config->item('admin') . 'problema_model'));
        
        $this->load->config('problema');
        $this->load->config('arquivo');
        
        // Carrega o helper de criptografia de senhas
        $this->load->helper('tk_joomla_encrypt_password');
        
        $this->load->helper('tk_folder');
        
        $this->load->helper('file');
        
        // Carrega as configuracoes dos idiomas disponiveis caso o problema deseje 
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
     * Exibe todos os problemas
     * 
     * @name all
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param int $apartir_de A partir de quantos registros começa a seleção
     * @return void
     */
    public function all($apartir_de = 0) {

        $this->load->library('filtro_library');
        
        $controladora = 'problema';
        $model = 'problema_model';
        $url = $this->config->item('admin') . 'problema/all';
        $por_pagina = $this->input->post('por_pagina');
        $campos = array(
            'p.id'         => _lang('form_id'),
            'p.nome'       => _lang('form_nome'),
            'p.nivel'      => _lang('form_nivel'),
            'c.nome'       => _lang('form_categoria')
        );

        $this->filtro_library->init($controladora, $model, $url, $por_pagina, $campos,'p.data_registro', $Status = array('1' => _lang('form_ativo'), '0' => _lang('form_inativo')), 'p.ativo');
        
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
        $fnd = $this->menu_model->get_by_id(38);
        $dados['titulo']   = $fnd->nome;
        $dados['conteudo'] = $this->config->item('admin') . $fnd->url;
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 38;

        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }
    
    /**
     * Mostra o formulario de cadastro de novo problema
     * 
     * @name novo
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    public function novo() {
       
        $dados['categorias'] = $this->categoria_model->get_array_categorias();
        $dados['materias']   = $this->materia_model->get_all_adm();
        
        $dados['menu'] = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_novo') . '&nbsp;' . _lang('menu_problema');
        $dados['conteudo']     = $this->config->item('admin') . 'problema/editar';
        $dados['url']          = $this->config->item('admin') . 'problema/cadastrar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'problema';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 38;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/problema.js';
        $dados['assets_js'][] = 'ajax/problema.js';
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        $dados['template_js'][] = 'form/jquery.autosize.min.js';
        $dados['template_js'][] = 'form/bootstrap-fileupload.min.js';
        $dados['template_js'][] = 'lib/ckeditor/ckeditor.js';
        
        // Carrega os javascript de carregamento de imagem
        $dados['template_js'][] = 'form/bootstrap-fileupload.min.js';
        $dados['template_js'][] = 'lib/plupload/js/plupload.full.js';
        $dados['template_js'][] = 'lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js';
        $dados['template_js'][] = 'lib/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js';

        if ($this->session->userdata('idioma') != 'en-US') {

            $dados['template_js'][] = 'lib/plupload/js/i18n/' . strtolower($this->session->userdata('idioma')) . '.js';
        }
        
//        $dados['template_js'][] = 'lib/jqamp-ui-spinner/compiled/jqamp-ui-spinner.min.js';
//        $dados['template_js'][] = 'lib/jqamp-ui-spinner/compiled/jquery-mousewheel-3.0.6.min.js';
        
        // Carrega os javascript de mascara
//        $dados['template_js'][] = 'plugins/forms/jquery.form.js';
//        $dados['template_js'][] = 'plugins/forms/jquery.inputmask.js';
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }

    /**
     * Insere um novo problema
     * 
     * @name cadastrar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @return boolean 
     */
    public function cadastrar() {

        $dados = new stdClass();

        $dados->nome            = $this->input->post('pro_nome');
        $dados->descricao       = $this->input->post('pro_descricao');
        $dados->entrada         = $this->input->post('pro_entrada');
        $dados->saida           = $this->input->post('pro_saida');
        $dados->restricoes      = $this->input->post('pro_restricoes');
        $dados->exemplo_entrada = $this->input->post('pro_exemplo_entrada');
        $dados->exemplo_saida   = $this->input->post('pro_exemplo_saida');
        if($this->input->post('pro_timelimit') != ''){
            $dados->timelimit   = $this->input->post('pro_timelimit');
        }
        else{
            $dados->timelimit  = null;
        }
        $dados->nivel_id           = $this->input->post('pro_nivel');
        $dados->ativo           = $this->input->post('pro_ativo');
        $dados->categoria_id    = $this->input->post('pro_categoria');

        $materias = $this->input->post('pro_materias');
        
        $resultado = $this->problema_model->insert($dados, $materias);
        
        if($resultado > 0){

            $caminho = $this->config->item('url_arquivos_admin') . 'problemas/0/arquivos';

            if (is_dir($caminho)) {

                $origem = $caminho;
                $destino = $this->config->item('url_arquivos_admin') . 'problemas/' . $resultado . '/arquivos';
                copia_dir($origem, $destino);
                remove_dir($origem);
                
                $dados->id         = $resultado;
                $dados->descricao  = str_replace("problemas/0/arquivos", "problemas/" . $resultado . "/arquivos", $dados->descricao);
                $dados->entrada    = str_replace("problemas/0/arquivos", "problemas/" . $resultado . "/arquivos", $dados->entrada);
                $dados->saida      = str_replace("problemas/0/arquivos", "problemas/" . $resultado . "/arquivos", $dados->saida);
                $dados->restricoes = str_replace("problemas/0/arquivos", "problemas/" . $resultado . "/arquivos", $dados->restricoes);
                
                $this->problema_model->update($dados);
            }
            
            $upload_arquivo_entrada = $this->upload_arquivo_entrada($resultado, true);
            if($upload_arquivo_entrada == 'ok'){
                $upload_arquivo_saida = $this->upload_arquivo_saida($resultado, true);
                if($upload_arquivo_saida == 'ok'){
                    $this->session->set_flashdata('msg', 'msg_insert-ok');
                }
                else{
                    $this->session->set_flashdata('msg', $upload_arquivo_saida);
                }
            }
            else{
                $this->session->set_flashdata('msg', $upload_arquivo_entrada);
            }
        }
        else{
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'problema', 'refresh');

    }

    /**
     * Metodo de edição
     * 
     * @name editar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param int $id id do problema
     * @return void
     */
    public function editar($id) {
        
        $dados['categorias']   = $this->categoria_model->get_array_categorias();
        $dados['materias']     = $this->materia_model->get_all_adm();
        
        $dados['possui_materias']   = $this->problema_model->get_problema_materias($id);
        
        $dados['problema'] = $this->problema_model->get_by_id($id);
        $dados['arquivos'] = get_filenames('./' . $this->config->item('url_arquivos_admin') . 'problemas/' . $dados['problema']->id . '/arquivos');
        
        $dados['menu']        = $this->menu_library->menu_admin();
        
        $dados['titulo']       = _lang('form_editar') . '&nbsp;' . _lang('menu_problema');
        $dados['conteudo']     = $this->config->item('admin') . 'problema/editar';
        $dados['url']          = $this->config->item('admin') . 'problema/atualizar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'problema';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 38;
        
        // Carrega os javascripts de validacao
        $dados['assets_js'][] = 'plugins/jquery.validate.js';   
        $dados['assets_js'][] = 'validacao/funcoes.js';
        $dados['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $dados['assets_js'][] = 'validacao/problema.js';
        $dados['assets_js'][] = 'ajax/problema.js';
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        $dados['template_js'][] = 'form/jquery.autosize.min.js';
        $dados['template_js'][] = 'form/bootstrap-fileupload.min.js';
        $dados['template_js'][] = 'lib/ckeditor/ckeditor.js';
        
        // Carrega os javascript de carregamento de imagem
        $dados['template_js'][] = 'form/bootstrap-fileupload.min.js';
        $dados['template_js'][] = 'lib/plupload/js/plupload.full.js';
        $dados['template_js'][] = 'lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js';
        $dados['template_js'][] = 'lib/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js';

        if ($this->session->userdata('idioma') != 'en-US') {

            $dados['template_js'][] = 'lib/plupload/js/i18n/' . strtolower($this->session->userdata('idioma')) . '.js';
        }
        
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
        
        $dados->id      = (int)$this->input->post('pro_id');
        $dados->nome            = $this->input->post('pro_nome');
        $dados->descricao       = $this->input->post('pro_descricao');
        $dados->entrada         = $this->input->post('pro_entrada');
        $dados->saida           = $this->input->post('pro_saida');
        $dados->restricoes      = $this->input->post('pro_restricoes');
        $dados->exemplo_entrada = $this->input->post('pro_exemplo_entrada');
        $dados->exemplo_saida   = $this->input->post('pro_exemplo_saida');
        $dados->dicas           = $this->input->post('pro_dicas');
        
        if($this->input->post('pro_timelimit') != ''){
            $dados->timelimit   = $this->input->post('pro_timelimit');
        }
        else{
            $dados->timelimit  = null;
        }
        $dados->nivel_id           = $this->input->post('pro_nivel');
        $dados->ativo           = $this->input->post('pro_ativo');
        $dados->categoria_id    = $this->input->post('pro_categoria');
        
        $materias   = $this->input->post('pro_materias');
       
        // Chama o Model e pede para atualizar a problema
        $resultado = $this->problema_model->update($dados, $materias);
        
        $upload_arquivo_entrada = $this->upload_arquivo_entrada($dados->id);
        
        $upload_arquivo_saida = $this->upload_arquivo_saida($dados->id);
        
        if($resultado || $upload_arquivo_entrada == 'ok' || $upload_arquivo_saida == 'ok'){
            $this->session->set_flashdata('msg', 'msg_update-ok');
        }
        else{
            $this->session->set_flashdata('msg', 'msg_error');
        }
                
        // Redireciona
        redirect($this->config->item('admin') . 'problema', 'refresh');
    }
    
    /**
     * Remove um problema
     * 
     * @name remover
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param string/array $ids ids dos problemas a serem removidos
     * @return void
     */
    public function remover($ids) {
        
        // Transforma a string recebida em array
        if(is_string($ids)) {
            
            $ids = explode('-', $ids);
        }
        $resultado = $this->problema_model->delete($ids);

        if ($resultado == TRUE) {
            
            if(is_array($ids)) {

                foreach ($ids as $id) {

                    $dir = $this->config->item('url_problemas') . $id;
                    
                    remove_dir($dir);
                    
                }
            }
            
            $this->session->set_flashdata('msg', 'msg_delete-ok');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($this->config->item('admin') . 'problema', 'refresh');
    }
    
     /**
     * Salva o banner se for selecionado no formulário
     * 
     * @name upload_banner
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 19/03/2015
     * @param int $id id do banner
     * @return void
     */
    function upload_arquivo_entrada($id, $excluir_registro = false) {
        
        $resultado = 'ok';
        
        $config = $this->config->item('arquivo');

        $config['upload_path'] = './' . $this->config->item('url_problemas') . $id .'/';

        // Se o usuario enviou a foto
        if(isset($_FILES['userfile']['name'])){
            
            if ($_FILES['userfile']['name'] != '') {
                $config = $this->config->item('arquivo');

                $config['upload_path'] = './' . $this->config->item('url_problemas') . $id .'/';
                
                if(!is_dir($config['upload_path'])){
                    mkdir($config['upload_path'],0777,TRUE);
                }                    

                $this->load->library('upload', $config);
                

                if ($this->upload->do_upload()) {
                    

                    $arquivo_entrada = $this->upload->data();

                    // remove a imagem anterior se existir
                    remove_arquivo($config['upload_path'], 'input.');

//                    $novo_nome = 'input.' . end(explode(".", $arquivo_entrada['file_name']));
                    $novo_nome = 'input.in';

                    // renomeia a nova foto do doador para que o seu nome seja o id do doador
                    rename($config['upload_path'] . $arquivo_entrada['file_name'], $config['upload_path'] . $novo_nome);

                    $resultado = 'ok';

                } else {
                    if($excluir_registro){
                        $this->problema_model->delete($id);
                        remove_dir($config['upload_path']);
                    }
                    // retorna o erro que ocorreu
                    $resultado = strip_tags($this->upload->display_errors());
                }
            }
        }
        else{
            remove_arquivo($config['upload_path'], 'input.');
        }

        return $resultado;
    }
    
     /**
     * Salva o banner se for selecionado no formulário
     * 
     * @name upload_banner
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 19/03/2015
     * @param int $id id do banner
     * @return void
     */
    function upload_arquivo_saida($id, $excluir_registro = false) {
        
        $resultado = 'ok';
        
        $config = $this->config->item('arquivo');

        $config['upload_path'] = './' . $this->config->item('url_problemas') . $id .'/';

        // Se o usuario enviou a foto
        if(isset($_FILES['userfile2']['name'])){
            
            
            
            if ($_FILES['userfile2']['name'] != '') {
                
                
                if(!is_dir($config['upload_path'])){
                    mkdir($config['upload_path'],0777,TRUE);
                }                    

                $this->load->library('upload', $config);
                

                if ($this->upload->do_upload('userfile2')) {
                    

                    $arquivo_saida = $this->upload->data();

                    // remove a imagem anterior se existir
                    remove_arquivo($config['upload_path'], 'output.');

//                    $novo_nome = 'output.' . end(explode(".", $arquivo_saida['file_name']));
                    $novo_nome = 'output.out';

                    // renomeia a nova foto do doador para que o seu nome seja o id do doador
                    rename($config['upload_path'] . $arquivo_saida['file_name'], $config['upload_path'] . $novo_nome);

                    $resultado = 'ok';

                } else {
                    if($excluir_registro){
                        $this->problema_model->delete($id);
                        remove_dir($config['upload_path']);
                    }
                    // retorna o erro que ocorreu
                    $resultado = strip_tags($this->upload->display_errors());
                }
            }
        }
        else{
            remove_arquivo($config['upload_path'], 'output.');
        }

        return $resultado;
    }
    
}