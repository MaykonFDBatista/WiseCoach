<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
      //if(PHP_SAPI !== 'cli')   exit('Sem permissao de acesso web ao Script.');
/**
 * 
 * Controller inicial da administracao da aplicacao
 * 
 * @package Controllers/adm
 * @name Index
 * @author Alex Santini<alex.santini@tellks.com.br>
 * @copyright Copyright (c) 2015, Tellks - Solucoes em tecnologia ltda
 * @since 20/01/2015
 * 
 */

class Juiz extends CI_Controller {
    
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
        
        $this->load->model(array(
            $this->config->item('ws') . 'website_model',
            $this->config->item('ws') . 'submissao_model'));
        
        $this->load->config('submissao');
        
        $this->load->helper('tk_folder_helper');
        $this->load->helper('tk_process_helper');
        $this->load->helper('tk_data_helper');
        
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
     * 
     * 
     * @name index
     * @author Alex Santini <alex.santini@tellks.com.br>
     * @since 20/01/2015
     * @param void
     * @return void
     */
    function index() {
        
    }
    
    function julgar($id){
        
        $this->remove_arquivos($id);
        
        $submissao = $this->submissao_model->get_by_id($id);
        
        $pasta_servidor = exec("pwd");
        
        $pasta_servidor = str_replace("\n", "", $pasta_servidor);
        
        $extensao = $this->config->item('extensoes')[$submissao->linguagem];
        
        $caminho_problema = $pasta_servidor . '/' . $this->config->item('url_problemas') . $submissao->problema_id;
        
        $caminho_submissao = $pasta_servidor . '/' . $this->config->item('url_submissoes') . $id;
        
        $codigo_fonte = $caminho_submissao . '/Main.'.$extensao;
        echo $codigo_fonte;
        $compilado = $caminho_submissao . '/main';
        
        $entrada_problema = $caminho_problema . '/input.in';
        
        $saida_problema = $caminho_problema . '/output.out';
        
        $saida_submissao = $caminho_submissao . '/output.out';
        
        switch($extensao){
            case 'c' :
                $comando_compilar       = "gcc ". $codigo_fonte ." -o " . $compilado . " 2>&1";
                $comando_testar_loop    = $compilado . " < " . $entrada_problema;
                $comando_tempo_execucao = "time " . $compilado . " < " . $entrada_problema . " 2>&1";
                $comando_executar       = $compilado . " < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "diff -i -E -Z -b -w -B " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "diff " . $saida_problema . " " . $saida_submissao . " 2>&1";
                break;
            case 'cpp' :
                $comando_compilar       = "g++ ". $codigo_fonte ." -o " . $compilado . " 2>&1";
                $comando_testar_loop    = $compilado . " < " . $entrada_problema;
                $comando_tempo_execucao = "time " . $compilado . " < " . $entrada_problema . " 2>&1";
                $comando_executar       = $compilado . " < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "diff -i -E -Z -b -w -B " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "diff " . $saida_problema . " " . $saida_submissao . " 2>&1";
                break;
            case 'java' :
                $comando_compilar       = "javac \"". $codigo_fonte . "\" 2>&1";
                $comando_testar_loop    = "cd " . $caminho_submissao . " && java Main < " . $entrada_problema;
                $comando_tempo_execucao = "cd " . $caminho_submissao . " && time java Main < " . $entrada_problema . " 2>&1";
                $comando_executar       = "cd " . $caminho_submissao . " && java Main < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "diff -i -E -Z -b -w -B " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "diff " . $saida_problema . " " . $saida_submissao . " 2>&1";
                break;
            case 'pas' :
                $comando_compilar       = "gpc ". $codigo_fonte ." -o " . $compilado . " 2>&1";
                $comando_testar_loop    = $compilado . " < " . $entrada_problema;
                $comando_tempo_execucao = "time " . $compilado . " < " . $entrada_problema . " 2>&1";
                $comando_executar       = $compilado . " < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "diff -i -E -Z -b -w -B " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "diff " . $saida_problema . " " . $saida_submissao . " 2>&1";
                break;
            case 'py' :
                $comando_compilar       = "python " . $codigo_fonte ." < " . $entrada_problema . " 2>&1";
                $comando_testar_loop    = "python " . $compilado . " < " . $entrada_problema;
                $comando_tempo_execucao = "time python " . $compilado . " < " . $entrada_problema . " 2>&1";
                $comando_executar       = "python " . $compilado . " < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "diff -i -E -Z -b -w -B " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "diff " . $saida_problema . " " . $saida_submissao . " 2>&1";
                break;
            default :
                $comando_compilar       = "gcc ". $codigo_fonte ." -o " . $compilado . " 2>&1";
                $comando_testar_loop    = $compilado . " < " . $entrada_problema;
                $comando_tempo_execucao = "time " . $compilado . " < " . $entrada_problema . " 2>&1";
                $comando_executar       = $compilado . " < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "diff -i -E -Z -b -w -B " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "diff " . $saida_problema . " " . $saida_submissao . " 2>&1";
        }
               
        $submissao2 = new stdClass();
        $submissao2->id = $id;
        
        if($extensao == 'py'){
            
            $nao_loop = $this->testar_loop($comando_testar_loop);

            if(!$nao_loop){
                $submissao2->resposta = 4;
                $submissao2->tempo = -1;
                $this->submissao_model->update($submissao2);
                echo "Time Limit Exceeded Loop";
                $this->remove_arquivos($id);
                return;
            }

            echo "2) Nao entrou em loop<br><br>";
            
            $compilou = $this->compilar($comando_compilar, $extensao);

            if(!$compilou){
                $submissao2->resposta = 2;
                $this->submissao_model->update($submissao2);
                echo "Compilation error";
                $this->remove_arquivos($id);
                return;
            }
            
            print_r("Compilou<br><br>");
        
        }
        else{
            $compilou = $this->compilar($comando_compilar, $extensao);

            if(!$compilou){
                $submissao2->resposta = 2;
                $this->submissao_model->update($submissao2);
                echo "Compilation error";
                $this->remove_arquivos($id);
                return;
            }

            print_r("Compilou<br><br>");

            $nao_loop = $this->testar_loop($comando_testar_loop);

            if(!$nao_loop){
                $submissao2->resposta = 4;
                $submissao2->tempo = -1;
                $this->submissao_model->update($submissao2);
                echo "Time Limit Exceeded Loop";
                $this->remove_arquivos($id);
                return;
            }

            echo "2) Nao entrou em loop<br><br>";
        }
        
        $tempo_execucao = $this->tempo_execucao($comando_tempo_execucao);
        $submissao2->tempo = $tempo_execucao;
        
        if(isset($submissao->timelimit)){
            if($tempo_execucao > $submissao->timelimit){
                $submissao2->resposta = 4;
                $this->submissao_model->update($submissao2);
                echo "Time Limit Exceeded";
                $this->remove_arquivos($id);
                return;
            }
        }
        
        $executou = $this->executar($comando_executar);
        
        if(!$executou){
            $submissao2->resposta = 3;
            $this->submissao_model->update($submissao2);
            echo "Runtime error";
            $this->remove_arquivos($id);
            return;
        }
        
        $comparacao = $this->comparar($comando_comparar1, $comando_comparar2);
        
        if($comparacao == "w"){
            $submissao2->resposta = 6;
            $this->submissao_model->update($submissao2);
            echo "Wrong answer";
            $this->remove_arquivos($id);
            return;
            
        }
        else if($comparacao == "p"){
            $submissao2->resposta = 5;
            echo "Presentation error";
            $this->submissao_model->update($submissao2);
            $this->remove_arquivos($id);
            return;
            
        }
        
        $submissao2->resposta = 1;
        echo "Accepted";
        $this->submissao_model->update($submissao2);
        $this->remove_arquivos($id);
        return;
    }
    
    function compilar($comando, $extensao){
        
        exec($comando, $saida, $retorno);

        echo "1) <pre>";
        print_r ($saida);
        echo "</pre><br>";
        
        if($retorno != 0 && $extensao == 'py'){
            foreach($saida as $s){
                if((substr($s, 0, 13) === "SyntaxError: ") || (substr($s, 0, 11) === "NameError: ")){
                    return false;
                }
            }
            return true;
        }
        
        if($retorno != 0){
            return false;
        }
        
        return true;
        
    }
    
    function testar_loop($comando){
        
        $output = PsExecute($comando);

        return $output;
    }
    
    
    
    function tempo_execucao($comando){   
        
        $tempo_execucao_soma = 0;
        
        $qtd_iteracoes = 10;
        
        for($i=0; $i<$qtd_iteracoes; $i++){
            
            $saida = array();

            exec($comando, $saida);
            
            echo "3) <pre>";
            print_r ($saida);
            echo "</pre><br>";

            if(sizeof($saida) < 2){
                return -1;
            }

            $tempo_execucao = $saida[sizeof($saida)-2];
            
            $tempo_execucao = explode(" ", $tempo_execucao);            
            $tempo_execucao = $tempo_execucao[2];
            
            $tempo_execucao = explode(":", $tempo_execucao);
            $tempo_execucao = $tempo_execucao[1];
            
            $tempo_execucao = str_replace("elapsed", "", $tempo_execucao);
            
            $tempo_execucao_soma += $tempo_execucao;
        
        }
        
        $tempo_execucao = $tempo_execucao_soma / $qtd_iteracoes;

        print_r("Tempo de execucao: " . $tempo_execucao);
        echo "<br><br>";

        return $tempo_execucao;
    }
    
    function executar($comando){

        exec($comando, $saida, $retorno);
                
        echo "5) <pre>";
        print_r ($saida);
        echo "</pre><br><br>";
        
        if($retorno != 0){
            return false;
        }
        
        return true;
    }
    
    function comparar($comando1, $comando2){
        
        exec($comando1, $saida1);
        
        echo "6) <pre>";
        print_r ($saida1);
        echo "</pre><br><br>";
        
        if(sizeof($saida1)>0){
            return "w";
        }
        
        exec($comando2, $saida2);  
        
        echo "6) <pre>";
        print_r ($saida2);
        echo "</pre><br><br>";
        
        if(sizeof($saida2)>0){
            return "p";
        }
        
        return "a";
        
    }
    
    function remove_arquivos($id, $excluir_compilado = true){
        
        $caminho_submissao = './' . $this->config->item('url_submissoes') . $id;
        
        if($excluir_compilado){
            if(file_exists($caminho_submissao . '/main')){
                unlink($caminho_submissao . '/main');
            }
            remove_arquivo_extensao($caminho_submissao, '.class');
        }
        remove_arquivo($caminho_submissao, 'output.');
        
    }
    
}