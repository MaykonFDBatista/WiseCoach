<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

// Itera sobre os oas retornados e gera uma tabela HTML
$this->table->set_heading(form_checkbox('seleciona_todos', '', FALSE, 'class="icheck" id="seleciona_todos"'), _lang('form_id'), _lang('form_descricao'),  _lang('form_pontos'),_lang('form_data_registro'));

foreach ($filtro['resultado']['dados'] as $loja) {
    
    $this->table->add_row(
            // Checkbox que permite selecionar o registro para que seja aplicada alguma acao sobre ele
            form_checkbox('selecionados[]', $loja->id, FALSE, 'class="checkbox icheck" id="check' . $loja->id . '"'), 
            $loja->id,
            // Transforma o campo nome em um link para edicao do registro
            anchor($this->config->item('admin') . 'loja/editar/' . $loja->id, _lang($loja->descricao)), 
            $loja->pontos,
            date(_lang('formato_data_hora'), strtotime($loja->data_registro))
    );
}

// Seta a controladora responsavel pelas acoes dos botoes
$dados['controller'] = 'loja';

$dados['disable_cadastrar'] = TRUE;
$dados['disable_remover'] = TRUE;

// Flag que indica que ha dados a serem exibidos
if (sizeof($filtro['resultado']['dados']) > 0) {

    $dados['tabela'] = TRUE;
}

//Prepara a paginacao para ser enviada para a proxima view a ser carregada
$dados['filtro']['resultado']['paginacao'] = $filtro['resultado']['paginacao'];

//Carrega a view default de gerenciamento de itens
$this->load->view($this->config->item('admin') . 'content/gerenciamento', $dados);


