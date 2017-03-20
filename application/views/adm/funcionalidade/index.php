<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View de exibição das funcionalidades.
 * 
 * @package   Views/adm/funcionalidade
 * @name      Index
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     2013
 */

// Itera sobre as funcionalidades retornados e gera uma tabela HTML
$this->table->set_heading(form_checkbox('seleciona_todos', '', FALSE, 'class="icheck" id="seleciona_todos"'), _lang('form_id'), _lang('form_nome'), _lang('form_status'), _lang('form_data_registro'));

foreach ($filtro['resultado']['dados'] as $funcionalidade) {

    $this->table->add_row(
            form_checkbox('selecionados[]', $funcionalidade->id, FALSE, 'class="checkbox icheck" id="check' . $funcionalidade->id . '"'), 
            $funcionalidade->id, 
            anchor($this->config->item('admin') . 'funcionalidade/editar/' . $funcionalidade->id, _lang($funcionalidade->nome)), 
            // Verifica o status e define a cor e a palavra a ser exibida
            (($funcionalidade->ativo > 0) ? '<span class="label label-success">' . _lang('form_ativa') . '</span>' 
                                          : '<span class="label label-important">' . _lang('form_inativa') . '</span>'), 
            date(_lang('formato_data_hora'), strtotime($funcionalidade->data_registro))
    );
}

// Seta a controladora responsavel pelas acoes dos botoes
$dados['controller'] = 'funcionalidade';

// Flag que indica que ha dados a serem exibidos
if (sizeof($filtro['resultado']['dados']) > 0) {

    $dados['tabela'] = TRUE;
}

//Prepara a paginacao para ser enviada para a proxima view a ser carregada
$dados['filtro']['resultado']['paginacao'] = $filtro['resultado']['paginacao'];

//Carrega a view default de gerenciamento de itens
$this->load->view($this->config->item('admin') . 'content/gerenciamento', $dados);
 


