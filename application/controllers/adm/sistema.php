<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller responsavel pelo gerenciamento das configuracoes globais do sistema
 * 
 * @package   controllers/adm
 * @name      sistema
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     28/06/2013
 * 
 */
class sistema extends CI_Controller{
      
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
        
        _login_admin();
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios','mensagens','data'); 
        
        $this->load->language($arquivos, $this->session->userdata('idioma'));
    }
    
    /**
     * Redireciona para o método informacoes
     * 
     * @name index
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function index() {
        
        $this->informacoes();
    }
    
    /**
     * Exibe a view de ediçao
     * 
     * @name editar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function minha_conta() {
        
        // Carrega as configuracoes dos idiomas disponiveis caso o usuario deseje 
        // alterar o idioma do sistema em seu perfil
        $this->load->config('linguagens');
        
        $this->load->model($this->config->item('admin') . 'usuario_model');
        
        $usuario = $this->usuario_model->get_by_id($this->session->userdata('usuario_id'));
        
        $data['usuario']  = $usuario;
        $data['menu']     = $this->menu_library->menu_admin();

        $fnd = $this->menu_model->get_by_id(24);
        
        $data['titulo']   = $fnd->nome;
        $data['conteudo'] = $this->config->item('admin') . $fnd->url;
        $data['url']      = $this->config->item('admin') . 'sistema/alterar_minha_conta';
        
        //funcionalidade selecionada
        $data['fun_corrente'] = 24; 
        
        // Carrega os javascripts de validacao
        $data['assets_js'][] = 'plugins/jquery.validate.js';   
        $data['assets_js'][] = 'validacao/funcoes.js';
        $data['assets_js'][] = 'validacao/mensagens/' . $this->session->userdata('idioma') . '.js';
        $data['assets_js'][] = 'validacao/minha_conta.js';
                
        // Carrega os javascript de carregamento de imagem
        $data['template_js'][] = 'form/bootstrap-fileupload.min.js';
        $data['template_js'][] = 'lib/complexify/jquery.complexify.banlist.js';
        $data['template_js'][] = 'lib/complexify/jquery.complexify.min.js';
        
        $this->load->view($this->config->item('tpl_admin'), $data);
    }

    /**
     * Processa uma alteração
     * 
     * @name alterar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function alterar_minha_conta(){
                
        $this->load->model($this->config->item('admin') . 'usuario_model');
        
        $this->load->helper('text');
        
        $usuario = $this->usuario_model->get_by_id($this->session->userdata('usuario_id'));
        
        if($usuario != FALSE) {
            
                $user = new stdClass();
                $user->id       = $this->session->userdata('usuario_id');
                $user->nome     = $this->input->post('usu_nome');
                $user->email    = $this->input->post('usu_email');
                $user->telefone = $this->input->post('usu_telefone');
                $user->celular  = $this->input->post('usu_celular');
                $user->idioma   = $this->input->post('usu_idioma');
                
                // Atualiza a sessao com o novo idioma
                $this->session->set_userdata('idioma',$user->idioma);
                
                // Se o usuario enviou uma foto
                if($_FILES['userfile']['name'] != '') {
                     
                    $this->load->config('imagem');
                    
                    $config = $this->config->item('imagem');
                    
                    $config['upload_path'] = './' . $this->config->item('url_arquivos_admin_usuarios');
                    
                    $this->load->library('upload', $config);
                    
                    // Se o upload foi realizado
                    if($this->upload->do_upload()) {
                        
                        $foto = $this->upload->data();
                        
                        // Redimensiona a imagem
                        _redimensionar($config['upload_path'] . $foto['file_name'], 130, 130, FALSE);
                        
                        // remove a foto anterior do diretorio
                        if(file_exists($this->config->item('url_arquivos_admin_usuarios') . $usuario->foto)) 
                                unlink($this->config->item('url_arquivos_admin_usuarios') . $usuario->foto);
                        
                        $novo_nome =  $user->id . substr($foto['file_name'], -4);
                        // renomeia a nova foto do usuario para que o seu nome seja o id do usuario
                        rename($this->config->item('url_arquivos_admin_usuarios') . $foto['file_name'], 
                               $this->config->item('url_arquivos_admin_usuarios') . $novo_nome);
                        
                        $user->foto = $novo_nome;
                        
                    }
                    else {

                        $this->session->set_flashdata('msg', strip_tags($this->upload->display_errors()));
                        $this->session->set_flashdata('tp', 'alert alert-error');
                        
                        // Sinaliza que ouve erro no upload de foto
                        $erro_upload = TRUE;
                    }
                }
                
                $flag = 1;
                
                if($this->input->post('nova_senha') != '') {
                    
                    // Carrega o helper de criptografia de senha
                    $this->load->helper('tk_joomla_encrypt_password');
                    
                    // Pega a senha criptografada armazenada em banco
                    $parts = explode(':', $usuario->senha);
                    $senha_banco_crypt = $parts[0];
                    $salt = @$parts[1];
                    
                    // Criptografa a senha antiga informada
                    $senha_informada_crypt = getCryptedPassword($this->input->post('senha_anterior'), $salt);
                    
                    // Se forem iguais realiza a alteracao da senha
                    if( $senha_banco_crypt == $senha_informada_crypt) {
                        
                        if($this->input->post('nova_senha') != '' ) {
                            
                            if($this->input->post('nova_senha') == $this->input->post('nova_senha2') ) {
                                
                                // Gera um salt randomico
                                $salt = genRandomPassword(32);
        
                                // Pega a senha informada pelo usuario
                                $user->senha = $this->input->post('nova_senha');

                                // Criptografa a senha com salt gerado
                                $crypt = getCryptedPassword($user->senha, $salt);

                                // Concatena a senha criptografada com o salt
                                $user->senha = $crypt . ':' . $salt;
                                
                                //Atualiza a nova senha na sessao
                                $this->session->set_userdata('senha',$crypt);
                            }
                            else {
                                $flag = 0;
                                $this->session->set_flashdata('msg', 'msg_senhas-diferentes');
                                $this->session->set_flashdata('tp', 'alert alert-error');
                            }
                        }
                    }
                    else {
                            $flag = 0;    
                            $this->session->set_flashdata('msg', 'msg_senha_incorreta');
                            $this->session->set_flashdata('tp', 'alert alert-error');
                    }
                }
                // Se as senhas conferem
                if($flag) {
                    $this->usuario_model->update($user);
                    $this->session->set_userdata('usuario', word_limiter($user->nome,1,''));
                    
                    // Se atualizou os dados do usuario e nao houve erro no upload de foto
                    if( !isset($erro_upload)) {
                        
                        $this->session->set_flashdata('msg', 'msg_update-ok');
                        $this->session->set_flashdata('tp', 'alert alert-success');
                    }
                }
        }
        else {
              $this->session->set_flashdata('msg', 'msg_usuario_incorreto');
              $this->session->set_flashdata('tp', 'alert alert-error');
        }
        
        redirect($this->config->item('admin') . 'sistema/minha_conta');
    }
    
    
    
    /**
     * Exibe views com as informações do sistema
     * 
     * @name informacoes
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @return void
     */
    function informacoes() {
        
        _access_admin(1);
        
        $fnd = $this->menu_model->get_by_id(1);
        $dados['menu']     = $this->menu_library->menu_admin();
        $dados['titulo']   = $fnd->nome;
        $dados['conteudo'] = $this->config->item('admin') . $fnd->url;
        
        //Funcionalidade selecionada
        $dados['fun_corrente'] = 1; 
        
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }
    
    /**
     * Carrega a view com as opcoes de desativar o sistema ou o frontend
     * 
     * @name configuracoes
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 28/06/2013
     * @return void
     */
    function configuracoes() {
        
        _access_admin(22);
        
        $this->load->model(array($this->config->item('admin') . 'sistema_model',
                           $this->config->item('admin') . 'site_model'));
        
        $dados['sistema']    = $this->sistema_model->get_configuracoes();
        $dados['qnt_sonhos'] = $this->site_model->get_all();
        
        $fnd = $this->menu_model->get_by_id(22);
        $dados['menu']     = $this->menu_library->menu_admin();
        $dados['titulo']   = $fnd->nome;
        $dados['conteudo'] = $this->config->item('admin') . $fnd->url;
        $dados['url']          = $this->config->item('admin') . 'sistema/salvar';
        $dados['url_cancelar'] = $this->config->item('admin') . 'sistema';
        
        // Funcionalidade selecionada
        $dados['fun_corrente'] = 22; 
        
        // Carrega javascripts necessarios para o funcionamento de elementos do formulario
        $dados['template_js'][] = 'lib/bootstrap-switch/bootstrapSwitch.js'; 
        
        $this->load->view($this->config->item('tpl_admin'), $dados);
    }
    
    /**
     * Salva as configuracoes alteradas
     * 
     * @name salvar
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 28/06/2013
     * @return void
     */
    function salvar(){
        
        $this->load->model(array($this->config->item('admin') . 'sistema_model',
                                 $this->config->item('admin') . 'site_model'));
        
        $config = new stdClass();
        
        $config->id = 1;
        $config->ativo = $this->input->post('ativo');
        $config->frontend_ativo = $this->input->post('frontend_ativo');
        
        $config->frontend_ativo = ($config->ativo == 0)? 0: $config->frontend_ativo;
        
        $resultado  = $this->sistema_model->update($config);
        
        if ($resultado == TRUE) {
            
            $this->session->set_flashdata('msg', 'msg_sucesso');
        }
        else {
            
            $this->session->set_flashdata('msg', 'msg_error');
        }
        
        redirect($this->config->item('admin') . 'sistema/configuracoes');
    }

}

?>
