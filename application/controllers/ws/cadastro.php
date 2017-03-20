n<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * Controller inicial da administracao da aplicacao
 * 
 * @package Controllers/adm
 * @name Index
 * @author Maykon Filipe Dacioli Batista<maykon.batista@tellks.com.br>
 * @copyright Copyright (c) 2015, Tellks - Solucoes em tecnologia ltda
 * @since 20/01/2015
 * 
 */

class Cadastro extends CI_Controller {
    
    /**
     * Método construtor
     * 
     * @name _construct
     * @author Alex Santini<alex.santini@tellks.com.br>
     * @since 20/01/2015
     * @param void
     * @return void
     */
    function __construct() {
        
        parent::__construct();
        
        $this->session->set_userdata('pagina_anterior', current_url()); 
        
        _login_ws(false);
        
        $this->load->model(array(
            $this->config->item('ws') . 'website_model',
            $this->config->item('ws') . 'categoria_model',
            $this->config->item('ws') . 'materia_model',
            $this->config->item('ws') . 'competidor_model'));
        
        $this->load->config('problema');
        
        // Carrega o helper de criptografia de senhas
        $this->load->helper('tk_joomla_encrypt_password');
        
        // Carrega os arquivos de linguagem necessarios nas views carregadas por esta
        // controladora
        $arquivos = array('formularios', 'mensagens'); 
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        
        $this->load->language($arquivos, $idioma);
    }
    
    /**
     * Carrega os dados do site
     * 
     * @name index
     * @author Maykon Filipe Dacioli Batista<maykon.batista@tellks.com.br>
     * @since 20/01/2015
     * @param void
     * @return void
     */
    function index() {
        
        $dados = array();
        $dados['website']    = $this->website_model->get_dados();
        
        $dados['categorias'] = $this->categoria_model->get_all();
        $dados['materias']   = $this->materia_model->get_all();
        
        $dados['url'] = 'cadastro/cadastrar';

        //view a ser carregada
        $dados['conteudo'] = 'cadastro/index';
        
        $dados['assets_js'][] = 'validacao/cadastro_ws.js';
        $dados['assets_js'][] = 'ajax/cadastro_ws.js';
        
        
        //$dados['qtd_sonhos_realizados'] = $this->sonho_model->get_qtd_realizados();
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
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
        $dados->ativo    = 1;
        $dados->idioma   = $this->input->post('com_idioma');

        $categorias = $this->input->post('com_categorias');
        $materias = $this->input->post('com_materias');
        
        $resultado = $this->competidor_model->insert($dados, $categorias, $materias);

        // Seta uma sessão com o resultado do Update ( True ou False )
        if ((bool)$resultado == TRUE) {

            $this->session->set_flashdata('msg', 'msg_insert-ok');
            $this->session->set_flashdata('email', $dados->email);
        } else {

            $this->session->set_flashdata('msg', 'msg_error');
        }
        
        $this->session->set_userdata('idioma', $dados->idioma);

        // Redireciona
        redirect($this->config->item('ws') . 'login', 'refresh');

    }
}