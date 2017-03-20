<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Conteudo do formulario de edicao de modulo
 * 
 * @package   views/content/forms
 * @name      modulo_editar
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     18/09/2013
 */

echo form_hidden('mod_id', (isset($modulos->id) ? $modulos->id : ''));
?>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="mod_nome" class="req"><?php echo _lang('form_nome'); ?>&nbsp;</label>
            <input type="text" name="mod_nome" placeholder="<?php echo _lang('form_nome'); ?>" value="<?php echo ((isset($modulos->nome)) ? $modulos->nome : '') ?>" class="span8"  />
        </div>
        <div class="span4">
            <label for="mod_ordem" class="req"><?php echo _lang('form_ordem'); ?>&nbsp;</label>
            <input type="text" name="mod_ordem" placeholder="<?php echo _lang('form_ordem'); ?>" value="<?php echo ((isset($modulos->ordem)) ? $modulos->ordem : '') ?>" class="span8"  />
        </div>
    </div>
</div>
<div class="formSep">
    <label for="mod_ativo" class="req"><?php echo _lang('form_status'); ?>&nbsp;</label>
    <div class="switch switch-small" data-on="success" data-on-label="<?php echo _lang('form_ativo');?>" data-off="danger" data-off-label="<?php echo _lang('form_inativo');?>">
        <?php echo form_checkbox('mod_ativo', '1', ((isset($modulos->ativo) && ($modulos->ativo > 0)) ? true : false));?>
    </div>
</div>