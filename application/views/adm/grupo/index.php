<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View de exibição dos grupos.
 * 
 * @package   Views/adm/grupo
 * @name      Index
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     2013
 */

// Itera sobre os grupos retornados e gera uma tabela HTML
$this->table->set_heading(form_checkbox('seleciona_todos', '', FALSE, 'class="icheck" id="seleciona_todos"'), _lang('form_id'), _lang('form_nome'), _lang('form_status'), _lang('form_data_registro'));

foreach ($filtro['resultado']['dados'] as $grupo) {

    $this->table->add_row(
            // Checkbox que permite selecionar o registro para que seja aplicada alguma acao sobre ele
            form_checkbox('selecionados[]', $grupo->id, FALSE, 'class="checkbox icheck" id="check' . $grupo->id . '"'), 
            $grupo->id,
            // Transforma o campo nome em um link para edicao do registro
            anchor($this->config->item('admin') . 'grupo/editar/' . $grupo->id, _lang($grupo->nome)), 
            // Verifica o status e define a cor e a palavra a ser exibida
            (($grupo->ativo > 0) ? '<span class="label label-success">' . _lang('form_ativo') . '</span>' 
                                 : '<span class="label label-important">' . _lang('form_inativo') . '</span>'), 
            date(_lang('formato_data_hora'), strtotime($grupo->data_registro))
    );
}

// Seta a controladora responsavel pelas acoes dos botoes
$dados['controller'] = 'grupo';

// Flag que indica que ha dados a serem exibidos
if (sizeof($filtro['resultado']['dados']) > 0) {

    $dados['tabela'] = TRUE;
}

//Prepara a paginacao para ser enviada para a proxima view a ser carregada
$dados['filtro']['resultado']['paginacao'] = $filtro['resultado']['paginacao'];

//Carrega a view default de gerenciamento de itens
$this->load->view($this->config->item('admin') . 'content/gerenciamento', $dados);


