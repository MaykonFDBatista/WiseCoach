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
     * Método ajax que verifica se não existe um doador já cadastrado com mesmo email que o digitado
     * 
     * @name email_doador
     * @author Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
     * @since 07/01/2015
     * @param void
     * @return boolean 
     */
    function email_competidor() {
        
        $this->load->model($this->config->item('ws') . 'competidor_model');
        
 
        
        $dados = $this->competidor_model->get_by_email($this->input->post('email'));
        
        if($dados) {
       
            echo '0';
 
        }
        else {
            
            echo '1';
        }   
    }
    
    function identifica_estilo_aprendizagem() {
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        $this->load->language(array('estilo_aprendizagem','formularios'), $idioma);
        
        $json = array();
        
        $this->load->model(array(
            $this->config->item('ws') . 'estilo_aprendizagem_model',
            $this->config->item('ws') . 'competidor_model'));
        
        $questoes = $this->input->post();
        
        $pontuacao = array();
        
        for($i=1;$i<=44;$i++) {
            
            $indice = 'form_estilo_aprendizagem_questao_' . $i;
            
            if (array_key_exists($indice, $questoes)) {
                
                $estilo_escolhido = $questoes[$indice];

                if(array_key_exists($estilo_escolhido, $pontuacao)) {
                    $pontuacao[$estilo_escolhido] += 1;
                }
                else {
                    $pontuacao[$estilo_escolhido] = 1;
                }
            }
        }
        
        $competidor_id = $this->session->userdata('id');
        
        $inseriu = $this->competidor_model->insert_estilos_aprendizagem($competidor_id, $pontuacao);
        
        if($inseriu) {
            
            $this->load->library('badge_library');
            
            $concedeu = $this->badge_library->concede_badge(1,'estilo_aprendizagem', $competidor_id);
        }
        
        $estilos = $this->estilo_aprendizagem_model->get_all();
        
        for($i=0; $i < sizeof($estilos); $i++) {
            $dimensao = $estilos[$i]->dimensao;
            $estilos[$i]->pontuacao = $pontuacao[$estilos[$i]->id];
            $estilos[$i]->dimensao = _lang($estilos[$i]->dimensao);
            $estilos[$i]->nome = _lang($estilos[$i]->nome);
            $estilos[$i]->descricao = _lang($estilos[$i]->descricao);
            $estilos[$i]->ponto = _lang('form_pontos');
            $json[$dimensao][] = $estilos[$i];
        }
        
        echo json_encode($json);
    }

    function grafico_submissoes_por_resposta() {
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        $this->load->language(array('formularios'), $idioma);
        
        $this->load->model(array($this->config->item('ws') . 'submissao_model'));
        
        $this->load->config('submissao');
        
        $nome_respostas = $this->config->item('respostas');
        
        $problema_id = $this->input->post('problema');
        
        $respostas = $this->submissao_model->get_qtd_resposta_por_problema($problema_id);
        
        $json = array();
        
        $soma = 0;
        foreach ($respostas as $r) {
            $soma += ($r->qtd);
        }
        $tamanho = sizeof($respostas);
        $labels = array();
        $porcentagens = array();
        foreach ($respostas as $r) {
            $labels[] = _lang($nome_respostas[$r->resposta]);
            $porcentagem = ($soma > 0 ? ($r->qtd/$soma)*100 : 0);
            $p = array();
            for($i=0;$i<$tamanho;$i++) {
                $p[] = ($tamanho>0) ? $porcentagem/$tamanho : 0;
            }
            $porcentagens[] = $p;
        }
        
        $json['labels'] = $labels;
        $json['porcentagens'] = $porcentagens;
        
        echo json_encode($json);
    }
    
    function grafico_submissoes_por_linguagem() {
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        $this->load->language(array('formularios'), $idioma);
        
        $this->load->model(array($this->config->item('ws') . 'submissao_model'));
        
        $this->load->config('submissao');
        
        $nome_linguagens = $this->config->item('linguagens');
        
        $problema_id = $this->input->post('problema');
        
        $linguagens = $this->submissao_model->get_qtd_linguagem_por_problema($problema_id);
        
        $soma = 0;
        foreach($linguagens as $l) {
            $soma += $l->qtd;
        }
        
        $labels = array();
        $valores = array();
        foreach($linguagens as $l) {
            $labels[] = _lang($nome_linguagens[$l->linguagem]);
            $valores[] = $l->qtd;
        }
        
        $json = array('labels' => $labels,
                      'valores' => $valores);
        
        echo json_encode($json);
    }
    
    function get_notificacoes_nao_lidas() {
        
        $this->load->model($this->config->item('ws') . 'notificacao_model');
        
        $competidor_id = $this->session->userdata('id');
        
        $notificacoes = $this->notificacao_model->get_nao_lidas_by_competidor($competidor_id);
        
        echo json_encode($notificacoes);
    }
    
    function marcar_como_lida() {
        
        $notificacao_id = $this->input->post('notificacao_id');
        
        $this->load->model($this->config->item('ws') . 'notificacao_model');
        
        $competidor_id = $this->session->userdata('id');
        
        $ok = $this->notificacao_model->marcar_como_lida($competidor_id, $notificacao_id);
        
        echo json_encode($ok);
    }
    
    function grafico_submissoes_competidor_por_linguagem() {
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        $this->load->language(array('formularios'), $idioma);
        
        $this->load->model(array($this->config->item('ws') . 'submissao_model'));
        
        $this->load->config('submissao');
        
        $nome_linguagens = $this->config->item('linguagens');
        
        $competidor_id = $this->session->userdata('id');
        
        $linguagens = $this->submissao_model->get_qtd_linguagem_por_competidor($competidor_id);
        
        $soma = 0;
        foreach($linguagens as $l) {
            $soma += $l->qtd;
        }
        
        $labels = array();
        $valores = array();
        foreach($linguagens as $l) {
            $labels[] = _lang($nome_linguagens[$l->linguagem]);
            $valores[] = $l->qtd;
        }
        
        $json = array('labels' => $labels,
                      'valores' => $valores);
        
        echo json_encode($json);
    }

    function grafico_submissoes_competidor_por_resposta() {
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        $this->load->language(array('formularios'), $idioma);
        
        $this->load->model(array($this->config->item('ws') . 'submissao_model'));
        
        $this->load->config('submissao');
        
        $nome_respostas = $this->config->item('respostas');
        
        $competidor_id = $this->session->userdata('id');
        
        $respostas = $this->submissao_model->get_qtd_resposta_por_competidor($competidor_id);
        
        $json = array();
        
        $soma = 0;
        foreach ($respostas as $r) {
            $soma += ($r->qtd);
        }
        $tamanho = sizeof($respostas);
        $labels = array();
        $porcentagens = array();
        foreach ($respostas as $r) {
            $labels[] = _lang($nome_respostas[$r->resposta]);
            $porcentagem = ($soma > 0 ? ($r->qtd/$soma)*100 : 0);
            $p = array();
            for($i=0;$i<$tamanho;$i++) {
                $p[] = ($tamanho>0) ? $porcentagem/$tamanho : 0;
            }
            $porcentagens[] = $p;
        }
        
        $json['labels'] = $labels;
        $json['porcentagens'] = $porcentagens;
        
        echo json_encode($json);
    }
    
    function grafico_submissoes_competidor_por_categoria() {
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        $this->load->language(array('formularios'), $idioma);
        
        $this->load->model(array($this->config->item('ws') . 'submissao_model'));
        
        $this->load->config('submissao');
        
        $competidor_id = $this->session->userdata('id');
        
        $categorias = $this->submissao_model->get_qtd_categoria_por_competidor($competidor_id);
        
        $labels = array();
        $valores = array();
        foreach($categorias as $c) {
            $labels[] = $c->categoria;
            $valores[] = $c->qtd;
        }
        
        $json = array('labels' => $labels,
                      'valores' => $valores);
        
        echo json_encode($json);
    }
    
    function grafico_submissoes_competidor_por_data() {
        
        $idioma = $this->session->userdata('idioma');
        if($idioma == ''){
            $idioma = $this->config->item('idioma_default');
        }
        $this->load->language(array('formularios'), $idioma);
        
        $this->load->model(array($this->config->item('ws') . 'submissao_model'));
        
        $this->load->config('submissao');
        
        $competidor_id = $this->session->userdata('id');
        
        $categorias = $this->submissao_model->get_qtd_data_por_competidor($competidor_id);
        
        $labels = array();
        $valores = array();
        foreach($categorias as $c) {
            $labels[] = date('d-m-Y', strtotime($c->data_registro)) ;
            $valores[] = $c->qtd;
        }
        
        $json = array('labels' => $labels,
                      'valores' => $valores);
        
        echo json_encode($json);
    }
}

?>
