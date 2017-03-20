<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 
 * @package   libraries
 * @name      filtro_library
 * @author    Claudia dos Reis Silva claudia.silva@tellks.com.br
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     22/05/2013
 * 
 */
class filtro_library {
    
    var $url;
    var $campos;
    var $model;
    var $por_pagina;
    var $valores_paginacao;
    var $status;
    var $campo_data;
    var $campo_status;
    var $controladora;
    
    /**
     * Seta os atributos globais para o funcionamento da library
     * 
     * @name   init
     * @author Joao Claudio Dias Araujo joao.araujo@tellks.com.br
     * @since  23/05/2013
     * @params String $model, String base_url, String $url, array $campos
     * @return void
     * 
     */
    function init($controladora,$model = '', $url = '', $por_pagina = 'T', $campos = array(), $data = 'data_registro', $status = FALSE,$campo_status = 'ativo'){
        
        $this->CI = & get_instance();
        
        $this->controladora = $controladora;

        $this->CI->session->set_userdata('model',  $model);
            
        $this->url = $url;
        
        if(sizeof($campos) > 0) {

            $this->campos = $campos;
            $this->campos[''] = _lang('form_selecione');
        }
        
        $this->model = $model;
        $this->CI->load->model($model);
        
        // Model utilizada
        $model = $this->model;
        
        // Seta se deve exibir o filtro por status
        $this->status = $status;
        
        // Se foi passado o valor da qtd de itens por pagina
        if($por_pagina != ''){
            
            $this->por_pagina = $por_pagina;
        } else {
            // Senao busca o valor na sessao
            if($this->CI->session->userdata('por_pagina') != ''){
                
                $this->por_pagina = $this->CI->session->userdata('por_pagina');
            }
            else {
                
                // Se nao foi informado um valor e nao existe esse dado na sessao, 
                // busca o valor no config
                $this->por_pagina = $this->CI->config->item('per_page');
            }
        }
        
        // Guarda o valor na sessao
        $this->CI->session->set_userdata('por_pagina',  $this->por_pagina);
        
        // Se optou por mostrar todos os registros busca no banco a qtd de registros
        if($this->por_pagina == 'T'){
            
            $this->por_pagina = $this->CI->$model->where_count_rows();
        }
        
        $this->campo_data = $data;
        $this->campo_status = $campo_status;
        
        $this->valores_paginacao = array('T'=>_lang('form_todos'),'10'=>'10','20'=>'20','50'=>'50','100'=>'100');
    }

    /**
     * Metodo responsavel por gerar o código html do filtro automático
     * 
     * @name   filtro_html
     * @author Claudia dos Reis Silva claudia.silva@tellks.com.br
     * @author Joao Claudio Dias Araujo joao.araujo@tellks.com.br
     * @since  22/05/2013
     * @params array $campos Campos em que foi aplicado o filtro
     * @param  array $data Datas que limitam o filtro
     * @param  int $status em que o resultado sera filtrado
     * @return formulario html
     * 
     */
    function filtro_html($campos = array(), $data = FALSE, $status = ''){
        
        
        if($this->CI->session->userdata('model') != $this->model){
            
            if($data) {
                
                if(isset($data['inicial'])) $data['inicial'] = '';
                if(isset($data['final']))   $data['final'] = '';
            }
            
            if (sizeof($this->campos) > 0 ) {
                
                $campos = array();
            }
        }
        
        $filtro = form_open($this->url, array('class' => 'form','id' => 'form_filtrar'));
        $filtro .='<div class="row-fluid">';
        
        $filtro .= form_hidden('form_filtro', '1');
        
        // Filtro de data
        // Filtro de data
        if($data){
            
            $filtro .=      '<span>' . _lang('form_data_inicial') . ': </span>'.br();
            $filtro .=      '<div class="input-append bs_datepicker_pt_start date" data-date-format="'._lang('formato_data_js').'" data-date-autoclose="true" data-date-language="'._idioma().'">';
            $filtro .=      form_input( array( 
                                        'name'      => 'data_inicial',  
                                        'value'     => ((isset($data['inicial']) ? $data['inicial'] : '')),
                                        'type'      => 'text',
                                        'class'     => 'span10 data',
                                        )
                                );
            $filtro .=      '<span class="add-on"><i class="icon-calendar"></i></span></div>'.br();
            
            $filtro .=          '<span>' . _lang('form_data_final') . ': </span>'.br();
            $filtro .=      '<div class="input-append bs_datepicker_pt_end date" data-date-format="'._lang('formato_data_js').'" data-date-autoclose="true" data-date-language="'._idioma().'">';
            $filtro .=           form_input( array(
                                        'name'      => 'data_final',  
                                        'value'     => ((isset($data['final']) ? $data['final'] : '')),
                                        'type'      => 'text',
                                        'class'     => 'span10 data',
                                        ) 
                                    ) ;
            $filtro .=      '<span class="add-on"><i class="icon-calendar"></i></span></div>';
            
        } // Fim filtro de data

        // Array campos vazio indica que nao foi requisitado o filtro por campo
        if (sizeof($this->campos) > 0 ) {

            $filtro .= '<span>' . _lang('form_busca') . ': </span>' . br();
            $filtro .= form_input(array(
                        'name'  => 'valor',
                        'value' => (isset($campos['valor']['label']) ? $campos['valor']['label'] : ''),
                        'id'    => 'buscar_valor',
                        'class' => 'span11'
                        )
                    ) . br() ;

            $filtro .= '<span>' . _lang('form_campo') . ': </span><br>';

            $filtro .= ((is_array($campos)) ? form_dropdown('campo', $this->campos, ((isset($campos['campo'])) ? $campos['campo'] : ''), 'class= "styled-select span10" id="campo"') : '');

        }      
       
        // Se esta setado para exibir o filtro do status
        if ($this->status){
        
            $filtro .= '<br><span>' . _lang('form_status') . ': </span>' . br();
        
            $this->status[''] = _lang('form_selecione');
        
            $filtro .= form_dropdown('status', $this->status, $status, 'class= "styled-select span10"');
        }
        
        $filtro .= form_input(array(
                        'name'  => 'por_pagina',
                        'value' => $this->por_pagina,
                        'id'    => 'por_pagina',
                        'type'  => 'hidden'
                        )
                    );
        
        $filtro .= '<br>' . form_submit('btn_filtrar', _lang('form_filtrar'),'class="btn btn-primary btn-block"') ;
        
        $filtro .= form_submit('btn_limpar', _lang('form_limpar_filtro'),'class="btn btn-block" id="btn_filtrar"') ;
        
        $filtro .= '</div>'.form_close();
        
        return $filtro; 
    }

    /**
     * Metodo responsavel por buscar os dados do filtro automático na model e retorná-los para a aplicação
     * 
     * @name   filtrar
     * @author 
     * @since  22/05/2013
     * @param  array $campo Chave corresponde ao nome do campo da tabela e o conteudo o valor
     * @param  array $data Contem a data inicial e a data final do filtro
     * @param  int $status Filtro por status
     * @param  int $limite inicio da paginacao
     * @return array
     * 
     */
    function filtrar($campo = FALSE, $data = FALSE, $status = '', $limite = 0) {
        
        // Model utilizada
        $model = $this->model;
        
        $where = array();
            
        if ($this->CI->session->userdata('model') == $this->model) {

            if ($campo){
                
                // Se o campo for um numero adiciona uma clausula WHERE comum
                if ( is_numeric($campo['valor']['value'])){
                    
                    $where = array($campo['campo'] => $campo['valor']['value']);
                }else{
                    // Senao adiciona uma clausula WHERE com o operador LIKE
                    $where = array($campo['campo'] . ' like ' => '%' . $campo['valor']['value'] . '%');
                }
            }
            
            // Se deve filtrar pelo status
            if ($status != ''){
                
                $where[$this->campo_status] = $status;
            }
        
            if($data) {
                
                if($data['inicial'] != ''){
                    
                    $date = DateTime::createFromFormat('!'._lang('formato_data'), $data['inicial']);
                    $dt_inicio = $date->format('Y-m-d H:i:s');

                    $where[$this->campo_data . ' >='] = $dt_inicio;
                    
                }
                if($data['final'] != ''){
                    
                    $date = DateTime::createFromFormat('!'._lang('formato_data'), $data['final']);
                    $dt_final = $date->format('Y-m-d') . ' 23:59:59';

                    $where[$this->campo_data . ' <='] = $dt_final;
                    
                }
            }
    }
        // Preparando o limite da paginacao
        $limite = ( $limite < 0 || $limite == 1 ) ? 0 : (int) $limite;
        
        // Paginacao
        $config_paginacao                = $this->CI->config->item('paginacao');
        $config_paginacao['base_url']    = base_url($this->url);
        $config_paginacao['per_page']    = $this->por_pagina;        
        $config_paginacao['uri_segment'] = $this->CI->config->item('uri_segment');
        $config_paginacao['total_rows']  = $this->CI->$model->where_count_rows($where);
        $config_paginacao['use_page_numbers'] = FALSE;
        $config_paginacao['cur_page']  = $limite;//(int) $limite/$this->por_pagina;
        $this->CI->pagination->initialize($config_paginacao);

        $retorno['paginacao'] = '<div class="pull-left span4" style="vertical-align: text-bottom;"><div style="float:left;">' . _lang('form_exibir') . ':&nbsp;</div>' . form_dropdown('por_pagina', $this->valores_paginacao, $this->por_pagina,'class="styled-select span4" id="paginacao"') . '</div>' . 
                                '<div class="pull-right">' . $this->CI->pagination->create_links() . '</div>';
        

        // Busca os dados no banco
        $retorno['dados'] = $this->CI->$model->get_all_where($where, $limite, $this->por_pagina);
        
        return $retorno;
    }

    /**
     * Interface entre a controller e os metodos que Geram o filtro e buscam os dados
     * 
     * @name   Gerar_filtro
     * @author Joao Claudio Dias Araujo joao.araujo@tellks.com
     * @since  23/05/2013
     * @param  array $campo Chave corresponde ao nome do campo da tabela e o conteudo o valor
     * @param  array $data Contem a data inicial e a data final do filtro
     * @param  int $limite inicio da paginacao
     * @param  int $por_pagina qtd de itens por pagina
     * @return array $filtro Contendo o formulario, os dados e a paginacao
     * 
     */
    function gerar_filtro($limite = 0, $campo = array(), $data = FALSE, $status = FALSE) {       
        
        // Limpar filtro
        if ($this->CI->input->post('btn_limpar') != '') {
            
            // Ignora o filtro de campo
            $campo = array();
            
            // Ignora o status
            $status = '';

            // Ignora o filtro de data
            if($data)$data = array('inicial'=>'','final'=>'');
            
            //Limpa a paginacao
            //$this->CI->session->unset_userdata('por_pagina');
            //$this->por_pagina = $this->CI->config->item('per_page');  
            
            $this->CI->session->set_userdata('limite','');
            $this->CI->session->set_userdata('campo','');
            $this->CI->session->set_userdata('valor','');
            $this->CI->session->set_userdata('dt_inicial','');
            $this->CI->session->set_userdata('dt_final','');
            $this->CI->session->set_userdata('status','');
            
        } else if($this->CI->input->post('form_filtro') != '') {
            
            // Se foram informados valores para o nome do campo e o valor eles sao gravados numa sessao 
            if (isset($campo['campo']) && isset($campo['valor'])) {

                $this->CI->session->set_userdata('campo', $campo['campo']);
                $this->CI->session->set_userdata('valor', $campo['valor']);
            }

            if (isset($campo['campo']) && (($campo['campo'] == '') || ($campo['valor']['value'] == ''))) {
                
                $campo = array();
            }
            
            // Foi requisitado o filtro de data
            if ($data) {

                // Se ha valores para as datas eles sao gravados numa sessao 
                if (isset($data['inicial']) || isset($data['final'])) {

                    $this->CI->session->set_userdata('dt_inicial', $data['inicial']);
                    $this->CI->session->set_userdata('dt_final', $data['final']);
                }
                
            }
            
            $this->CI->session->set_userdata('status',$status);

            $this->CI->session->set_userdata('limite',$limite); 
            
        }
        else {
            // Nao foi informado o nome do campo ou o valor
            if (isset($campo['campo']) && (($campo['campo'] == '') || ($campo['valor']['value'] == ''))) {
                // Verifica se ha o valor deles esta na sessao
                if (($this->CI->session->userdata('controladora') == $this->controladora) && ($this->CI->session->userdata('campo') != "") && ($this->CI->session->userdata('valor') != "") && ($this->CI->session->userdata('model') == $this->model)) {

                    $campo['campo'] = $this->CI->session->userdata('campo');
                    $campo['valor'] = $this->CI->session->userdata('valor');
                } else {
                    // Se nao ha valores na sessao 
                    $campo = array();
                    $this->CI->session->set_userdata('campo','');
                    $this->CI->session->set_userdata('valor','');
                }
            }

            // Se foram informados valores para o nome do campo e o valor eles sao gravados numa sessao 
            if (isset($campo['campo']) && isset($campo['valor'])) {

                $this->CI->session->set_userdata('campo', $campo['campo']);
                $this->CI->session->set_userdata('valor', $campo['valor']);
            }

            // Foi requisitado o filtro de data
            if ($data) {

                // Se nao foram informados valores para as datas
                if (($data['inicial'] == '') && ($data['final'] == '')) {

                    // Verifica se ha valores na sessao 
                    if (($this->CI->session->userdata('controladora') == $this->controladora) && (($this->CI->session->userdata('dt_inicial') != "") || ($this->CI->session->userdata('dt_final') != "")) && ($this->CI->session->userdata('model') == $this->model)) {

                        $data['inicial'] = $this->CI->session->userdata('dt_inicial');
                        $data['final'] = $this->CI->session->userdata('dt_final');
                    } else {
                        // Nao ha valores para datas na sessao 
                        // O filtro de data e desabilitado
                        $data = array('inicial'=>'','final'=>'');
                        
                        $this->CI->session->set_userdata('dt_inicial','');
                        $this->CI->session->set_userdata('dt_final','');
                    }
                }

                // Se ha valores para as datas eles sao gravados numa sessao 
                if (isset($data['inicial']) || isset($data['final'])) {

                    $this->CI->session->set_userdata('dt_inicial', $data['inicial']);
                    $this->CI->session->set_userdata('dt_final', $data['final']);
                }
            }
            
            if(($this->CI->session->userdata('controladora') == $this->controladora) && ($status == '')) {

                $status = $this->CI->session->userdata('status');
            }
            else if($this->CI->session->userdata('controladora') != $this->controladora) {

                $this->CI->session->set_userdata('status','');
            }
            else {
                
                $this->CI->session->set_userdata('status',$status);
            }
            
//            if(($this->CI->session->userdata('controladora') == $this->controladora) && $limite == 0){
//                
//                $limite = $this->CI->session->userdata('limite'); 
//            }
//            else {
//
//               $this->CI->session->set_userdata('limite',$limite); 
//            }
        }
        
        // Gera o formulario do filtro e armazena para ser retornado junto com os dados e a paginacao
        $filtro['formulario'] = $this->filtro_html($campo, $data,$status);
            
        // Realiza a consulta ao banco realizando a filtragem e gerando a paginacao
        $filtro['resultado'] = $this->filtrar($campo, $data, $status, $limite);
        
        $this->CI->session->set_userdata('controladora',$this->controladora);
        
        return $filtro;
    }

}
?>
