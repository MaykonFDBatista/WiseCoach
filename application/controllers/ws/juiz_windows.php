<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
      if(PHP_SAPI !== 'cli')   exit('Sem permissao de acesso web ao Script.');
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

class Juiz_windows extends CI_Controller {
    
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
     * @author Alex Santini<alex.santini@tellks.com.br>
     * @since 20/01/2015
     * @param void
     * @return void
     */
    function index() {
        
    }
    
    function julgar($id){
        
        $this->remove_arquivos($id);
        
        $submissao = $this->submissao_model->get_by_id($id);
        
        $pasta_servidor = exec("chdir");
        
        $pasta_servidor = str_replace("\n", "", $pasta_servidor);
        
        $extensao = $this->config->item('extensoes')[$submissao->linguagem];
        
        $extensao_compilado = $this->config->item('extensoes_compilado')[$submissao->linguagem];
        
        $caminho_problema = $pasta_servidor . '/' . $this->config->item('url_problemas') . $submissao->problema_id;
        
        $caminho_submissao = $pasta_servidor . '/' . $this->config->item('url_submissoes') . $id;
        
        $codigo_fonte = $caminho_submissao . '/main.'.$extensao;
        
        $compilado = $caminho_submissao . '/main';
        
        $compilado_extensao = $compilado . $extensao_compilado;
        
        $entrada_problema = $caminho_problema . '/input.in';
        
        $saida_problema = $caminho_problema . '\\output.out';
        
        $saida_submissao = $caminho_submissao . '/output.out';
        
        $script = $caminho_submissao . '/script.bat';
        
        copy("timer.bat", $this->config->item("url_submissoes"). $id . "/timer.bat");
        
        switch($extensao){
            case 'c' :
                $comando_compilar       = "gcc -o ". $compilado ." " . $codigo_fonte . " 2>&1";
                $comando_testar_loop    = $compilado_extensao . " < " . $entrada_problema;
                $comando_tempo_execucao = "timer \"" . $compilado_extensao . " < " . $entrada_problema . "\"";
                $comando_executar       = $compilado_extensao . " < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "fc /c /w " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "fc " . $saida_problema . " " . $saida_submissao . " 2>&1";
                break;
            case 'cpp' :
                $comando_compilar       = "g++ -o ". $compilado ." " . $codigo_fonte . " 2>&1";
                $comando_testar_loop    = $compilado_extensao . " < " . $entrada_problema;
                $comando_tempo_execucao = "timer \"" . $compilado_extensao . " < " . $entrada_problema . "\"";
                $comando_executar       = $compilado_extensao . " < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "fc /c /w " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "fc " . $saida_problema . " " . $saida_submissao . " 2>&1";
                break;
            case 'java' :
                $comando_compilar       = "javac \"". $codigo_fonte . "\" 2>&1";
                $comando_testar_loop    = "cd " . $caminho_submissao . " && java main < " . $entrada_problema;
                $comando_tempo_execucao = "cd " . $caminho_submissao . " && timer \"java main < " . $entrada_problema . "\"";
                $comando_executar       = "cd " . $caminho_submissao . " && java main < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "fc /c /w " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "fc " . $saida_problema . " " . $saida_submissao . " 2>&1";
                break;
            case 'pas' :
                $comando_compilar       = "gpc -o ". $compilado ." " . $codigo_fonte . " 2>&1";
                $comando_testar_loop    = $compilado_extensao . " < " . $entrada_problema;
                $comando_tempo_execucao = "timer \"" . $compilado_extensao . " < " . $entrada_problema . "\"";
                $comando_executar       = $compilado_extensao . " < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "fc /c /w " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "fc " . $saida_problema . " " . $saida_submissao . " 2>&1";
                break;
            case 'py' :
                $comando_compilar       = "python " . $codigo_fonte ." < " . $entrada_problema . " 2>&1";
                $comando_testar_loop    = "python " . $codigo_fonte . " < " . $entrada_problema;
                $comando_tempo_execucao = "timer \"python " . $codigo_fonte . " < " . $entrada_problema . "\"";
                $comando_executar       = "python " . $codigo_fonte . " < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "fc /c /w " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "fc " . $saida_problema . " " . $saida_submissao . " 2>&1";
                break;
            default :
                $comando_compilar       = "gcc -o ". $compilado ." " . $codigo_fonte . " 2>&1";
                $comando_testar_loop    = $compilado_extensao . " < " . $entrada_problema;
                $comando_tempo_execucao = "timer \"" . $compilado_extensao . " < " . $entrada_problema . "\"";
                $comando_executar       = $compilado_extensao . " < " . $entrada_problema . " > " . $saida_submissao . " 2>&1";
                $comando_comparar1      = "fc /c /w " . $saida_problema . " " . $saida_submissao . " 2>&1";
                $comando_comparar2      = "fc " . $saida_problema . " " . $saida_submissao . " 2>&1";;
        }
        
        $submissao2 = new stdClass();
        $submissao2->id = $id;
        
        if($extensao != 'py'){
        
            $compilou = $this->compilar($comando_compilar, $extensao);

            if(!$compilou){
                $submissao2->resposta = 2;
                $this->submissao_model->update($submissao2);
                echo "Compilation error";
                $this->remove_arquivos($id);
                return;
            }

            print_r("Compilou<br><br>");

            $nao_loop = $this->testar_loop($comando_testar_loop, $script);

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
        else{
            $nao_loop = $this->testar_loop($comando_testar_loop, $script);

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
    
    function testar_loop($comando, $script){

        $fp = fopen($script, "w");

        // Escreve "exemplo de escrita" no bloco1.txt
        $escreve = fwrite($fp, $comando);

//                    // Fecha o arquivo
        fclose($fp);
        
        $output = PsExecute($script);
                
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
            
            $data_inicial = $saida[0];
            $data_final = $saida[sizeof($saida) - 1];
            
            $data_inicial = str_replace(",", ".", $data_inicial);
            list($data, $espaco, $hora) = explode(" ", $data_inicial);
            list($dia, $mes, $ano) = explode("/", $data);
            $data_inicial = $mes . '/' . $dia . '/' . $ano . ' ' . $hora;
            
            $data_final = str_replace(",", ".", $data_final);
            list($data, $espaco, $hora) = explode(" ", $data_final);
            list($dia, $mes, $ano) = explode("/", $data);
            $data_final = $mes . '/' . $dia . '/' . $ano . ' ' . $hora;
            
            $data_inicial = date_create($data_inicial);
            $data_inicial = date_format($data_inicial,"m/d/Y H:i:s.u");

            $data_final = date_create($data_final);
            $data_final = date_format($data_final,"m/d/Y H:i:s.u");

            $data_inicial = new DateTime($data_inicial);
            $data_final = new DateTime($data_final);    
            
            echo mdiff($data_inicial, $data_final) . "<br>";

            $tempo_execucao_soma += mdiff($data_inicial, $data_final);
        
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
        
        if(sizeof($saida1)>3){
            return "w";
        }
        
        exec($comando2, $saida2);
        
        echo "6) <pre>";
        print_r ($saida2);
        echo "</pre><br><br>";
        
        if(sizeof($saida2)>3){
            return "p";
        }       
        
        return "a";
        
    }
    
    function remove_arquivos($id, $excluir_compilado = true){
        
        $caminho_submissao = './' . $this->config->item('url_submissoes') . $id;
        
        if($excluir_compilado){
            remove_arquivo_extensao($caminho_submissao, '.exe');
            remove_arquivo_extensao($caminho_submissao, '.class');
        }
        remove_arquivo($caminho_submissao, 'output.');
        remove_arquivo($caminho_submissao, 'script.');
        remove_arquivo($caminho_submissao, 'timer.');
        remove_arquivo($caminho_submissao, 'juiz.');
        
    }
    
}