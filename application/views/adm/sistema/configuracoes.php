<?php
if (!defined('BASEPATH'))
    exit('Sem permissao de acesso direto ao Script.');
/**
 * View de edicao das configuracoes do sistema
 * 
 * @package   views/adm
 * @name      configuracoes
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     28/06/2013
 * 
 */
if ($this->session->flashdata('msg') != "") {

    switch ($this->session->flashdata('msg')) {

        case 'msg_sucesso': {
                $tp = 'alert alert-success';
            } break;
        case 'msg_error': {
                $tp = 'alert alert-error';
            } break;
    }
    echo '<div class="' . $tp . '">' . _lang($this->session->flashdata('msg')) . "<button type='button' class='close' data-dismiss='alert'>×</button> </div>";
}
echo form_open($url, array('class' => 'form-horizontal', 'id' => 'form_configuracoes'));
?>
<div class="box_a">
    <div class="box_a_heading">
        <h3><?php echo _lang('form_sis_status'); ?></h3>
    </div>

    <div class="box_a_content">

        <div class="formSep">
            <div class="span2">
                <label for="labelfor"><?php echo _lang('form_sistema'); ?>:&nbsp;</label>
                <div>
                    <div class="switch switch-small" data-on="success" data-on-label="<?php echo _lang('form_ativo'); ?>" data-off="danger" data-off-label="<?php echo _lang('form_inativo'); ?>">
                        <?php echo form_checkbox('ativo', '1', ((isset($sistema->ativo) && ($sistema->ativo > 0)) ? true : false)); ?>
                    </div>
                </div>
            </div>
            <div class="span2">
                <label for="labelfor"">Frontend:&nbsp;</label>
                <div>
                    <div class="switch switch-small" data-on="success" data-on-label="<?php echo _lang('form_ativo'); ?>" data-off="danger" data-off-label="<?php echo _lang('form_inativo'); ?>">
                        <?php echo form_checkbox('frontend_ativo', '1', ((isset($sistema->frontend_ativo) && ($sistema->frontend_ativo > 0)) ? true : false)); ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="formSep">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <button type="button" class="btn btn-danger" onClick="window.location = '<?php echo base_url() . $url_cancelar; ?>'">Cancelar</button>
        </div>
    </div>
</div>
<?php
echo form_close();
?>
