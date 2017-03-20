<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
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

class Problema extends CI_Controller {
    
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
        $this->session->set_userdata('pagina_anterior_login', current_url()); 
        
        $this->load->model(array(
            $this->config->item('ws') . 'website_model',
            $this->config->item('ws') . 'problema_model',
            $this->config->item('ws') . 'submissao_model',
            $this->config->item('ws') . 'materia_model',
            $this->config->item('ws') . 'objeto_aprendizagem_model'));
        
        $this->load->config('submissao');
        
        $this->load->helper('tk_folder');
        $this->load->helper('tk_process_helper');
        
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
     * @author Alex Santini <alexsantini_spfc@hotmail.com>
     * @since 20/01/2015
     * @param void
     * @return void
     */
    function index() {
        
        $competidor_id = $this->session->userdata('id');
        
        $dados = array();
        $dados['website']    = $this->website_model->get_dados();
        $dados['problemas']    = $this->problema_model->get_all_ws($competidor_id);

        //view a ser carregada
        $dados['conteudo'] = 'problema/index';
        
        $dados['pagina'] = 'problema';
        
        $dados['assets_js'][] = 'plugins/peity-master/jquery.peity.min.js';
        $dados['assets_js'][] = 'ajax/problema_ws.js';
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }
    
    function categoria($categoria_id) {
        
        $competidor_id = $this->session->userdata('id');
        
        $dados = array();
        $dados['website']    = $this->website_model->get_dados();
        $dados['problemas']    = $this->problema_model->get_by_categoria($categoria_id, $competidor_id);

        //view a ser carregada
        $dados['conteudo'] = 'problema/index';
        
        $dados['pagina'] = 'problema';
        
        $dados['assets_js'][] = 'plugins/peity-master/jquery.peity.min.js';
        $dados['assets_js'][] = 'ajax/problema_ws.js';
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }
    
    /**
     * Carrega os dados do site
     * 
     * @name index
     * @author Alex Santini <alexsantini_spfc@hotmail.com>
     * @since 20/01/2015
     * @param void
     * @return void
     */
    function visualizar($id) {
        
        $dados = array();
        $dados['website']    = $this->website_model->get_dados();
        $dados['problema']    = $this->problema_model->get_by_id($id);

        //view a ser carregada
        $dados['conteudo'] = 'problema/visualizar';
        
        $dados['pagina'] = 'problema';
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }
    
    /**
     * Realiza uma submissão
     * 
     * @name submeter
     * @author Alex Santini <alexsantini_spfc@hotmail.com>
     * @since 2013
     * @return boolean 
     */
    public function submeter($id) {
        
        _login_ws();
        
        $dados = array();
        $dados['website']     = $this->website_model->get_dados();
        $dados['problema']    = $this->problema_model->get_by_id($id);
        $dados['url']         = $this->config->item('ws') . 'problema/enviar_submissao/'.$id;

        //view a ser carregada
        $dados['conteudo'] = 'problema/submeter';
        
        $dados['pagina'] = 'problema';
        
        $dados['assets_js'][] = 'plugins/ace/ace.js';
        $dados['assets_js'][] = 'plugins/edit_area/edit_area_full.js';
        $dados['assets_js'][] = 'ajax/problema_ws.js';
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);

    }
    
    /**
     * Realiza uma submissão
     * 
     * @name submeter
     * @author Alex Santini <alexsantini_spfc@hotmail.com>
     * @since 2013
     * @return boolean 
     */
    public function enviar_submissao($id) {
        
        _login_ws();
        
        $dados = new stdClass();
        
        $dados->problema_id = $id;
        
        $dados->competidor_id = $this->session->userdata('id');
        
        $dados->linguagem = $this->input->post('linguagem');
        
        $resultado = $this->submissao_model->insert($dados);
        
        $redireciona = $this->config->item('ws') . 'problema/submeter/'.$id;

        if($resultado > 0){
            
            $extensao = $this->config->item('extensoes')[$dados->linguagem];
            $upload_codigo_fonte = $this->upload_codigo_fonte($resultado, true, $extensao);
            if($upload_codigo_fonte == 'ok'){
        
                $pasta_servidor = exec("pwd");
        
                $pasta_servidor = str_replace("\n", "", $pasta_servidor);
                
                $caminho_submissao = $pasta_servidor . '/' . $this->config->item('url_submissoes') . $id;
                
                $comando = "php " . $pasta_servidor . "/index.php ". $this->config->item('ws') . "juiz julgar " . $resultado;
                
                PsExec($comando);

                $this->session->set_flashdata('msg', 'msg_submissao-ok');
                $redireciona = $this->config->item('ws') . 'submissao';
            }
            else{
                if($upload_codigo_fonte == 'vazio'){
                    $this->session->set_flashdata('msg', 'msg_vazio');
                }
                else{
                    $this->session->set_flashdata('msg', $upload_codigo_fonte);
                }
            }
        }
        else{
            $this->session->set_flashdata('msg', 'msg_error');
        }

        // Redireciona
        redirect($redireciona, 'refresh');

    }
    
         /**
     * Salva o código fonte
     * 
     * @name upload_banner
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 19/03/2015
     * @param int $id id do banner
     * @return void
     */
    function upload_codigo_fonte($id, $excluir_registro = false, $extensao) {
        
        $resultado = 'vazio';
        
        $config['allowed_types'] = $extensao;
        
        $config['encrypt_name'] = true;
        $config['upload_path'] = './' . $this->config->item('url_submissoes') . $id .'/';

        // Se o usuario enviou a foto
        if(isset($_FILES['userfile']['name'])){
            
            if ($_FILES['userfile']['name'] != '') {
                
                remove_dir($config['upload_path']);
                
                if(!is_dir($config['upload_path'])){
                    mkdir($config['upload_path'],0777,TRUE);
                }                    

                $this->load->library('upload', $config);
                

                if ($this->upload->do_upload()) {
                    

                    $codigo_fonte = $this->upload->data();

//                    $novo_nome = 'input.' . end(explode(".", $arquivo_entrada['file_name']));
                    $novo_nome = 'Main.'.$extensao;

                    // renomeia a nova foto do doador para que o seu nome seja o id do doador
                    rename($config['upload_path'] . $codigo_fonte['file_name'], $config['upload_path'] . $novo_nome);

                    $resultado = 'ok';

                } else {
                    if($excluir_registro){
                        $this->submissao_model->delete($id);
                        remove_dir($config['upload_path']);
                    }
                    // retorna o erro que ocorreu
                    $resultado = strip_tags($this->upload->display_errors());
                }
            }
            else{
                if($this->input->post('codigo_fonte') != ''){
                    remove_dir($config['upload_path']);

                    if(!is_dir($config['upload_path'])){
                        mkdir($config['upload_path'],0777,TRUE);
                    } 

                    $fp = fopen($config['upload_path'].'Main.'.$extensao, "w");

                    // Escreve "exemplo de escrita" no bloco1.txt
                    $escreve = fwrite($fp, $this->input->post('codigo_fonte'));

//                    // Fecha o arquivo
                    fclose($fp);
                    $resultado = 'ok';
                }
            }
        }
        

        return $resultado;
    }

    
    public function visualizar_objetos_aprendizagem($id) {
        
        $competidor_id = $this->session->userdata('id');
        
        $objetos = $this->objeto_aprendizagem_model->get_por_problema($id, $competidor_id);
//        echo $this->db->last_query();die;
        $dados = array();
        $dados['website'] = $this->website_model->get_dados();
        $dados['problema'] = $this->problema_model->get_by_id($id);
        $dados['materias'] = $this->materia_model->get_por_problema($id);
        $dados['objetos'] = $objetos;
        
        //view a ser carregada
        $dados['conteudo'] = 'problema/visualizar_objeto_aprendizagem';
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }
    
    public function visualizar_estatisticas($id) {
        
        $dados = array();
        $dados['website'] = $this->website_model->get_dados();
        $dados['problema'] = $this->problema_model->get_by_id($id);
        $dados['submissoes'] = $this->submissao_model->get_top_20($id);
                
        //view a ser carregada
        $dados['conteudo'] = 'problema/visualizar_estatisticas';
        
        $dados['assets_js'][] = 'plugins/morris/morris.min.js';
        $dados['assets_js'][] = 'ajax/visualizar_estatisticas_ws.js';
        
        // Carrega a view passando os dados a serem exibidos.
        $this->load->view($this->config->item('tpl_index_default'), $dados);
    }
    
}