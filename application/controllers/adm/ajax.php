<?php
/**
 * 
 * Controller responsável pelo gerenciamento das chamadas ajax
 * 
 * @package Controllers/adm
 * @name Ajax
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since 2013
 * 
 */

class Ajax extends CI_Controller {
    
    /**
     * Método construtor
     * 
     * @name _construct
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function __construct() {
        
        parent::__construct();
    }
    
    /**
     * Método ajax que carrega as cidades do estado selecionado
     * 
     * @name cidade
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 2013
     * @param void
     * @return void
     */
    function cidade() {
        
        $this->load->model($this->config->item('admin') . 'cidade_model');
        $query = $this->cidade_model->getCidade($this->input->post('uf'));
        $opcoes = '';
        foreach($query->result() as $cidade) {
            $opcoes .= '<option value="' . $cidade->id_cidade . '">' . $cidade->nome . '</option>';
        }
        echo json_encode($opcoes);
    }
    
    function busca_endereco()
    {  
       $cep = $this->input->post('cep');
       $this->load->model($this->config->item('admin') . 'cidade_model');
       $query = $this->cidade_model->get_by_CEP($cep); 
       echo json_encode($query);
    }
    
    function materia() {
        
        $materia = $this->input->post('materia');
        
        $this->load->model($this->config->item('admin') . 'materia_model');
        $materias = $this->materia_model->get_by_nome($materia);
        
        $opcoes = array();
        
        foreach($materias as $i => $m) {
            $opcoes[$i]['id'] = $m->id;
            $opcoes[$i]['text'] = $m->nome;
        }
        
        echo json_encode($opcoes);
    }

    /**
     * Método ajax que verifica se não existe um usuário cadastrado com mesmo email que o digitado
     * 
     * @name usuario
     * @author Claudia dos Reis Silva <claudia.silva@tellks.com.br>
     * @since 09/07/2013
     * @param void
     * @return boolean 
     */
    function email() {
        
        $this->load->model($this->config->item('admin') . 'usuario_model');
        
        $id = $this->input->post('id');
        
        $dados = $this->usuario_model->get_by_email($this->input->post('email'));
        
        if($dados) {
            
            if($id == $dados->id) {
                
                echo '1';
            }
            else {
                
                echo '0';
            }
        }
        else {
            
            echo '1';
        }   
    }
    
    /**
     * Metodo ajax que remove uma imagem da galeria de um app
     * 
     * @name   remove_imagem
     * @author joao Claudio <joao.araujo@tellks.com.br>
     * @since  26/08/2013
     * @param  string $imagem Nome da imagem a ser removida
     * @return void
     */
    function remove_imagem($imagem) {
        
        unlink(_galeria() . $imagem);
    }
    
    function remove_imagem_produto_global($imagem, $id) {

        unlink($this->config->item('url_arquivos_app') . 'produtos_globais/' . $id . '/' . $imagem);
    }
    
    /**
     * Método ajax que cadastra uma requisicao de redefinicao de senha e envia o email da requisicao
     * 
     * @name requisitar_nova_senha
     * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
     * @since 24/09/2013
     * @param void
     * @return boolean 
     */
    function requisitar_nova_senha() {

        $this->load->library('autenticacao_library');

        $resultado = $this->autenticacao_library->redefinicao_senha('maykon.batista@tellks.com.br');

        // Se houve sucesso
        if ($resultado) {

            echo '<div class="alert alert-success">' . _lang('msg_email_enviado') . '</div>';
        } else {
            // Se ocorreu algum erro que impossibilitou o envio do email
            if ($resultado == NULL) {

                echo '<div class="alert alert-error">' . _lang('msg_erro_enviar_email') . '</div>';
            } else {
                // Nao encontrou o usuario no banco   
                echo '<div class="alert alert-error">' . _lang('msg_erro_usuario_inexistente') . '</div>';
            }
        }
    }
    
    /**
     * Método ajax que verifica se não existe um doador já cadastrado com mesmo email que o digitado
     * 
     * @name email_doador
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
     * @since 07/01/2015
     * @param void
     * @return boolean 
     */
    function email_doador() {
        
        $this->load->model($this->config->item('admin') . 'doador_model');
        
        $id = $this->input->post('id');
        
        $dados = $this->doador_model->get_by_email($this->input->post('email'));
        
        if($dados) {
            
            if($id == $dados->id) {
                
                echo '1';
            }
            else {
                
                echo '0';
            }
        }
        else {
            
            echo '1';
        }   
    }
    
    function remove_arquivo() {
        
        $id = $this->input->post('id');
        $arquivo = $this->input->post('arquivo');
        
        $url = $this->config->item('url_arquivos_admin') . '/problemas/' . $id . '/arquivos/' . $arquivo;
        
        if(file_exists($url)) {
            echo unlink($url);
        }
        else {
            echo 0;
        }
    }
    
    function formato() {
        
        $tipo = $this->input->post('tipo');
        
        $this->load->model($this->config->item('admin') . 'formato_objeto_aprendizagem_model');
        
        $formatos = $this->formato_objeto_aprendizagem_model->get_by_tipo_objeto_aprendizagem($tipo);
        
        echo json_encode($formatos);
    }
    
    function estilo_aprendizagem() {
        
        $arquivos = array('estilo_aprendizagem'); 
        
        $this->load->language($arquivos, $this->session->userdata('idioma'));
        
        $estilo = $this->input->post('estilo');
        
        $this->load->model($this->config->item('admin') . 'estilo_aprendizagem_model');
        
        $estilos = $this->estilo_aprendizagem_model->get_by_nome($estilo);
        
        $opcoes = array();
        
        foreach($estilos as $i => $e) {
            $opcoes[$i]['id'] = $e->id;
            $opcoes[$i]['text'] = _lang($e->nome);
        }
        
        echo json_encode($opcoes);
    }

}

?>
