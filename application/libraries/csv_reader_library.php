<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* CSVReader Class
*
* $Id: csvreader.php 147 2007-07-09 23:12:45Z Pierre-Jean $
*
* Allows to retrieve a CSV file content as a two dimensional array.
* The first text line shall contains the column names.
*
* @author        Pierre-Jean Turpeau
* @link        http://www.codeigniter.com/wiki/CSVReader
*/
class csv_reader_library {
    
    var $fields;        /** columns names retrieved after parsing */
    var $separator = ',';    /** separator used to explode each line */
    
    /**
     * Parse a text containing CSV formatted data.
     *
     * @access    public
     * @param    string
     * @return    array
     */
    function parse_text($p_Text) {
        $lines = explode("\n", $p_Text);
        return $this->parse_lines($lines);
    }
    
    /**
     * Parse a file containing CSV formatted data.
     *
     * @access    public
     * @param    string
     * @return    array
     */
    function parse_file($p_Filepath) {
        $lines = file($p_Filepath);
        return $this->parse_lines($lines);
    }
    /**
     * Parse an array of text lines containing CSV formatted data.
     *
     * @access    public
     * @param    array
     * @return    array
     */
    function parse_lines($p_CSVLines) {    
        $content = FALSE;
        foreach( $p_CSVLines as $line_num => $line ) {
            if( $line != '' ) { // skip empty lines
                $elements = explode($this->separator, $line);
 
                if( !is_array($content) ) { // the first line contains fields names
                    $this->fields = $elements;
                    $content = array();
                } else {
                    $item = array();
                    foreach( $this->fields as $id => $field ) {
                        if( isset($elements[$id]) ) {
                            $item[trim($field)] = trim($elements[$id]);
                        }
                    }
                    $content[] = $item;
                }
            }
        }
        return $content;
    }
    
    /**
     * Funcão que verifica que os campos obrigatórios estão presentes no array de dados criado
     * 
     * @name   campos_obrigatorios
     * @author Claudia dos Reis Silva <claudia.silva@tellks.com.br>
     * @since  09/08/2013
     * @param  array $dados array com os dados do condômino
     * @return boolean (false/true) se os campos existem ou não
     * @return int linha com dado obrigatório nulo
     */ 
    function campos_obrigatorios($dados = array()) {
        
        $this->CI = & get_instance();
        
        $campos = $this->CI->config->item('campos-obrigatorios');

        foreach ($campos as $campo) {
            
            //Verifica se existe aquela chave 
            if( ! array_key_exists($campo, $dados[0])) {
                // Se a chave obrigatória não existir no vetor
                return false;
            }
            else {//Se a chave existir, verifica se seus valores não são nulos
                for($i=0; $i<sizeof($dados); $i++) {
                    
                    //Se for nulo 
                    if($dados[$i][$campo] == '') {
                        
                        return $i+2;
                    }
                }
            }
        }
        return true;
    }
    
}
/*
 * http://blog.insicdesigns.com/2009/03/reading-csv-file-in-codeigniter/
 */