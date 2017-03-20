<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

// Itera sobre os oas retornados e gera uma tabela HTML
$this->table->set_heading(form_checkbox('seleciona_todos', '', FALSE, 'class="icheck" id="seleciona_todos"'), _lang('form_id'), _lang('form_badge'), _lang('form_descricao'), _lang('form_data_registro'));

foreach ($filtro['resultado']['dados'] as $badge) {
    
    $this->table->add_row(
            // Checkbox que permite selecionar o registro para que seja aplicada alguma acao sobre ele
            form_checkbox('selecionados[]', $badge->id, FALSE, 'class="checkbox icheck" id="check' . $badge->id . '"'), 
            $badge->id,
            // Transforma o campo nome em um link para edicao do registro
            anchor($this->config->item('admin') . 'badge/editar/' . $badge->id, img(array('src' => $this->config->item('badge_url') . $badge->nome))), 
            // Verifica o status e define a cor e a palavra a ser exibida
             '<span class="label">' . $badge->descricao  . '</span>', 
            date(_lang('formato_data_hora'), strtotime($badge->data_registro))
    );
}

// Seta a controladora responsavel pelas acoes dos botoes
$dados['controller'] = 'badge';

// Flag que indica que ha dados a serem exibidos
if (sizeof($filtro['resultado']['dados']) > 0) {

    $dados['tabela'] = TRUE;
}

//Prepara a paginacao para ser enviada para a proxima view a ser carregada
$dados['filtro']['resultado']['paginacao'] = $filtro['resultado']['paginacao'];

//Carrega a view default de gerenciamento de itens
$this->load->view($this->config->item('admin') . 'content/gerenciamento', $dados);


