<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View de exibição dos modulos.
 * 
 * @package   Views/adm/modulo
 * @name      Index
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     2013
 */

// Itera sobre os modulos retornados e gera uma tabela HTML
    $this->table->set_heading(form_checkbox('seleciona_todos', '', FALSE, 'class="icheck" id="seleciona_todos"'),
            _lang('form_id'), _lang('form_nome'), _lang('form_ordem'), _lang('form_status'), _lang('form_data_registro'));

    foreach ($filtro['resultado']['dados'] as $modulo) {
        
        $this->table->add_row
                (
                // Checkbox que permite selecionar o registro para que seja aplicada alguma acao sobre ele
                form_checkbox('selecionados[]', $modulo->id, FALSE, 'class="checkbox icheck" id="check' . $modulo->id . '"'),
                $modulo->id, 
                anchor($this->config->item('admin') . 'modulo/editar/' . $modulo->id, _lang($modulo->nome)), 
                $modulo->ordem,
                // Verifica o status e define a cor e a palavra a ser exibida
                (($modulo->ativo > 0)?'<span class="label label-success">' . _lang('form_ativo') . '</span>'
                                     :'<span class="label label-important">' . _lang('form_inativo') . '</span>'),
                date(_lang('formato_data_hora'),strtotime($modulo->data_registro)) 
        );
        
    }

// Seta a controladora responsavel pelas acoes dos botoes
$dados['controller'] = 'modulo';

// Flag que indica que ha dados a serem exibidos
if (sizeof($filtro['resultado']['dados']) > 0) {

    $dados['tabela'] = TRUE;
}

//Prepara a paginacao para ser enviada para a proxima view a ser carregada
$dados['filtro']['resultado']['paginacao'] = $filtro['resultado']['paginacao'];

//Carrega a view default de gerenciamento de itens
$this->load->view($this->config->item('admin') . 'content/gerenciamento', $dados);


