<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View de exibição dos materias.
 * 
 * @package   Views/adm/materia
 * @name      Index
 * @author    Alex Santini <alex.santini@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     2013
 */

// Itera sobre os materias retornados e gera uma tabela HTML
    $this->table->set_heading(form_checkbox('seleciona_todos', '', FALSE, 'class="icheck" id="seleciona_todos"'),
            _lang('form_id'), _lang('form_nome'), _lang('form_data_registro'));

    foreach ($filtro['resultado']['dados'] as $materia) {
        
        $this->table->add_row
                (
                // Checkbox que permite selecionar o registro para que seja aplicada alguma acao sobre ele
                form_checkbox('selecionados[]', $materia->id, FALSE, 'class="checkbox icheck" id="check' . $materia->id . '"'),
                $materia->id, 
                anchor($this->config->item('admin') . 'materia/editar/' . $materia->id, _lang($materia->nome)), 
                date(_lang('formato_data_hora'),strtotime($materia->data_registro)) 
        );
        
    }

// Seta a controladora responsavel pelas acoes dos botoes
$dados['controller'] = 'materia';

// Flag que indica que ha dados a serem exibidos
if (sizeof($filtro['resultado']['dados']) > 0) {

    $dados['tabela'] = TRUE;
}

//Prepara a paginacao para ser enviada para a proxima view a ser carregada
$dados['filtro']['resultado']['paginacao'] = $filtro['resultado']['paginacao'];

//Carrega a view default de gerenciamento de itens
$this->load->view($this->config->item('admin') . 'content/gerenciamento', $dados);


