<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View de exibição dos condomínios.
 * 
 * @package   Views/adm/app
 * @name      Index
 * @author    Claudia dos Reis Silva <claudia.silva@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     02/07/2013
 */

// Define o cabecalho da tabela
$this->table->set_heading(form_checkbox('seleciona_todos', '', FALSE, 'class="icheck" id="seleciona_todos"'),
        _lang('form_id'), _lang('form_nome'),  _lang('form_telefone'), _lang('form_contato'), _lang('form_status'), _lang('form_data_registro'));

// Itera sob os itens criando as linhas da tabela
foreach ($filtro['resultado']['dados'] as $app) {

    $this->table->add_row(
            form_checkbox('selecionados[]', $app->id, FALSE, 'class="checkbox icheck" id="check' . $app->id . '"'), 
            $app->id, 
            anchor($this->config->item('admin') . 'app/editar/' . $app->id,$app->nome), 
            $app->telefone, 
            $app->contato,
            (($app->ativo > 0) ? '<span class="label label-success">' . _lang('form_ativo') . '</span>' 
                               : '<span class="label label-important">' . _lang('form_inativo') . '</span>'),
            date(_lang('formato_data_hora'),strtotime($app->data_registro))
            
    );
}

// Seta a controladora responsavel pelas acoes dos botoes
$dados['controller'] = 'app';

// Botao da acao usuarios
$btn_usuarios = array('url'       => $this->config->item('admin') .  'usuario_app/all/0/',
                      'label'     => _lang('menu_usuarios'),
                      'atributos' => array('class' => 'btn btn-inverse btn-with_action', 'id' => 'btn-usuarios')
                    );
// Botao da acao controle de acesso
$btn_controle_acesso = array('url'       => $this->config->item('admin') .  $dados['controller'] . '/controle_acesso/',
                             'label'     => _lang('menu_controle_acesso'),
                             'atributos' => array('class' => 'btn btn-success btn-with_action', 'id' => 'btn-controle_acesso')
                            );

// Acoes extras que deve ser exibidas na view de gerenciamento
$dados['acoes'] = array($btn_usuarios,$btn_controle_acesso);

// Flag que indica que ha dados a serem exibidos
if (sizeof($filtro['resultado']['dados']) > 0) {

    $dados['tabela'] = TRUE;
}
//Prepara a paginacao para ser enviada para a proxima view a ser carregada
$dados['filtro']['resultado']['paginacao'] = $filtro['resultado']['paginacao'];

//Carrega a view default de gerenciamento de itens
$this->load->view($this->config->item('admin') . 'content/gerenciamento', $dados);


