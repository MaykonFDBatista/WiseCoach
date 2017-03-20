<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * @package   application/helpers
 * @name      tk_folder_helper
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     24/07/2013
 * 
 */

/**
 * Copia o diretorio informado e todos os seus sub-diretorios e arquivos de 
 * forma recursiva para o destino informado.
 * 
 * ATENCAO!!!
 * Separador Linux ("/")
 * $destino deverá ser completo, com o nome do diretorio a ser criado.
 * 
 * @name   copia_dir
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @since  14/10/2013
 * @param  string $origem Diretorio de origem
 * @param  string $destino Diretorio de destino
 * @return void
 */
if (!function_exists('copia_dir')) {

    function copia_dir($origem, $destino) {

        mkdir($destino, 0777, true);
        
        if ($dd = opendir($origem)) {
            while (false !== ($Arq = readdir($dd))) {
                
                if ($Arq != "." && $Arq != "..") {
                    
                    $PathIn = "$origem/$Arq";
                    $PathOut = "$destino/$Arq";
                    if (is_dir($PathIn)) {
                        
                        copia_dir($PathIn, $PathOut);
                    } elseif (is_file($PathIn)) {
                        
                        copy($PathIn, $PathOut);
                    }
                }
            }
            closedir($dd);
        }
    }

}

/**
 * Remove o diretorio informado e todos os seus sub-diretorios e arquivos de 
 * forma recursiva.
 * 
 * ATENCAO!!!
 * Separador Linux ("/")
 * 
 * @name   remove_dir
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @since  13/07/2013
 * @param  string $Dir Caminho do diretorio a ser removido
 * @return void
 */
if (!function_exists('remove_dir')) {

    function remove_dir($Dir) {
        
        if(is_dir($Dir)) {
            
            if ($dd = opendir($Dir)) {

                while (false !== ($Arq = readdir($dd))) {

                    if ($Arq != '.' && $Arq != '..') {

                        $Path = $Dir . '/' . $Arq;

                        if (is_dir($Path)) {
                            //Remove os diretorios de forma recursiva
                            remove_dir($Path);
                        } 
                        elseif (is_file($Path)) {
                            //Remove os arquivos
                            unlink($Path);
                        }
                    }
                }
                closedir($dd);
            }
            rmdir($Dir);
        }
    }

}

/**
 * Remove um arquivo sem que seja necessario informar a sua extensao
 * 
 * @name   remove_arquivo
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @since  26/08/2013
 * @param  string $path Url do arquivo
 * @param  string $arquivo Nome do arquivo
 * @return boolean Resultado da operacao, se obteve sucesso ou nao
 */
if (!function_exists('remove_arquivo')) {

    function remove_arquivo($path,$arquivo) {

        $resp = FALSE;
        
        $diretorio = dir($path);

        while ($aux = $diretorio->read()) {

            $aux_nome = substr($aux,0,strrpos($aux,".")) . '.'; 
         
            if ($aux_nome == $arquivo) {
                
                unlink($path . '/' . $aux);
                
                $resp = TRUE;
            }
        }
        
        $diretorio->close();
        
        return $resp;         
    }

}

/**
 * Remove um arquivo sem que seja necessario informar a sua extensao
 * 
 * @name   remove_arquivo
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>   
 * @since  26/08/2013
 * @param  string $path Url do arquivo
 * @param  string $arquivo Nome do arquivo
 * @return boolean Resultado da operacao, se obteve sucesso ou nao
 */
if (!function_exists('remove_arquivo_extensao')) {

    function remove_arquivo_extensao($path,$extensao) {

        $resp = FALSE;
        
        $diretorio = dir($path);

        while ($aux = $diretorio->read()) {

            $aux_nome = substr($aux,strrpos($aux,"."),  strlen($aux)-1); 
            
            if ($aux_nome == $extensao) {
                
                unlink($path . '/' . $aux);
                
                $resp = TRUE;
            }
        }
        
        $diretorio->close();
        
        return $resp;         
    }

}