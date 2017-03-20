<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View index padrao na qual e montada todas as telas de gerenciamento
 * 
 * @package   views/content
 * @name      index_padrao
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     30/09/2013
 */

// Mensagens exibidas nos bootbox de remocao
echo form_input(array('name' => 'msg_nenhum_registro' , 'id'=> 'msg_nenhum_registro' , 'value' => _lang('msg_nenhum_registro'), 'type' => 'hidden'));

echo form_input(array('name' => 'msg_confirm_remocao' , 'id'=> 'msg_confirm_remocao' , 'value' => _lang('msg_confirm_remocao'), 'type' => 'hidden'));

echo form_input(array('name' => 'form_cancelar' , 'id'=> 'form_cancelar' , 'value' => _lang('form_cancelar'), 'type' => 'hidden'));

if ($this->session->flashdata('msg') != "") {
    
    switch ($this->session->flashdata('msg')) {
        
        case 'msg_insert-ok': {
                $tp = 'alert alert-success';
            } break;
        case 'msg_update-ok': {
                $tp = 'alert alert-success';
            } break;
        case 'msg_delete-ok': {
                $tp = 'alert alert-success';
            } break;
        case 'msg_error': {
                $tp = 'alert alert-error';
            } break;
        case 'msg_some_errors_remove': {
                $tp = 'alert alert-error';
            } break;
        default: {
                $tp = 'alert alert-warning';
            } break;
    }
    echo '<div class="' . $tp . '">' . _lang($this->session->flashdata('msg')) . "<button type='button' class='close' data-dismiss='alert'>×</button> </div>";
}
?>
<div class="box_a">
    <div class="box_a_heading" style="padding-bottom: 4px;">
        <div class="pull-left">
            <?php
            if (!isset($disable_cadastrar))
                echo anchor($this->config->item('admin') . $controller . '/novo', _lang('form_cadastrar'), array('class' => 'btn btn-primary')) . nbs(2);

            if (isset($acoes)) {

                foreach ($acoes as $a) {

                    echo anchor($a['url'], $a['label'], $a['atributos']) . nbs(2);
                }
            }

            if (!isset($disable_remover))
                echo anchor($this->config->item('admin') . $controller . '/remover', _lang('form_remover'), array('class' => 'btn btn-danger', 'id' => 'btn-remover')) . nbs(2);
            ?>
        </div>
        <div class="pull-right">
            <?php echo anchor($this->config->item('admin') . $controller . '#', '<i class="elusive-icon-search"></i>&nbsp;' . _lang('form_filtrar'), array('class' => 'jpanel-trigger btn')) . nbs(2); ?>

        </div>

    </div>

    <div class="box_a_content">
        <?php
        // Seta o template da tabela
        $tmpl = array('table_open' => '<table class="footable table table-striped" id="table">');
        $this->table->set_template($tmpl);

        // Se existem itens a serem exibidos renderiza a tabela com os dados
        if (isset($tabela)) {

            echo $this->table->generate();
        } else {
            // Senao exibe a view de nenhum registro
            $this->load->view($this->config->item('admin') . 'content/nenhum_registro');
        }
        ?>
        <table class="footable table" data-page-size="8" data-filter="#foo_filter" data-filter-disable-enter="true">
            <thead>
            </thead>
            <tbody>    
            </tbody>
            <tfoot class="footable-pagination">
                <tr>
                    <td colspan="5">
                        <div class="pagination">
                            <?php
                            echo $filtro['resultado']['paginacao'];
                            ?>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table> 
    </div>
</div>