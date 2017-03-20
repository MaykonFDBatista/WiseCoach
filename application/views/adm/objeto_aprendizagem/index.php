<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

// Itera sobre os oas retornados e gera uma tabela HTML
$this->table->set_heading(form_checkbox('seleciona_todos', '', FALSE, 'class="icheck" id="seleciona_todos"'), _lang('form_id'), _lang('form_nome'), _lang('form_tipo'), _lang('form_data_registro'));

foreach ($filtro['resultado']['dados'] as $objeto_aprendizagem) {

    $this->table->add_row(
            // Checkbox que permite selecionar o registro para que seja aplicada alguma acao sobre ele
            form_checkbox('selecionados[]', $objeto_aprendizagem->id, FALSE, 'class="checkbox icheck" id="check' . $objeto_aprendizagem->id . '"'), 
            $objeto_aprendizagem->id,
            // Transforma o campo nome em um link para edicao do registro
            anchor($this->config->item('admin') . 'objeto_aprendizagem/editar/' . $objeto_aprendizagem->id, _lang($objeto_aprendizagem->titulo)), 
            // Verifica o status e define a cor e a palavra a ser exibida
             '<span class="label">' . $objeto_aprendizagem->tipo  . '</span>', 
            date(_lang('formato_data_hora'), strtotime($objeto_aprendizagem->data_registro))
    );
}

// Seta a controladora responsavel pelas acoes dos botoes
$dados['controller'] = 'objeto_aprendizagem';

// Flag que indica que ha dados a serem exibidos
if (sizeof($filtro['resultado']['dados']) > 0) {

    $dados['tabela'] = TRUE;
}

//Prepara a paginacao para ser enviada para a proxima view a ser carregada
$dados['filtro']['resultado']['paginacao'] = $filtro['resultado']['paginacao'];

//Carrega a view default de gerenciamento de itens
$this->load->view($this->config->item('admin') . 'content/gerenciamento', $dados);


