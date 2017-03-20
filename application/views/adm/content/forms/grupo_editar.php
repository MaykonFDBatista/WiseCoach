<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Conteudo do formulario de edicao de grupo
 * 
 * @package   views/content/forms
 * @name      grupo_editar   
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     18/09/2013
 */

echo form_hidden('gru_id', (isset($grupo->id) ? $grupo->id : ''));
?>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="gru_nome" class="req"><?php echo _lang('form_nome'); ?>&nbsp;</label>
            <input type="text" name="gru_nome" placeholder="<?php echo _lang('form_nome'); ?>" value="<?php echo ((isset($grupo->nome)) ? $grupo->nome : '') ?>" class="span10"  />
        </div>
        <div class="span2">
            <label for="gru_ativo" class="req"><?php echo _lang('form_status'); ?>&nbsp;</label>
            <div class="switch switch-small" data-on="success" data-on-label="<?php echo _lang('form_ativo');?>" data-off="danger" data-off-label="<?php echo _lang('form_inativo');?>">
                <?php echo form_checkbox('gru_ativo', '1', ((isset($grupo->ativo) && ($grupo->ativo > 0)) ? true : false));?>
            </div>
        </div>
    </div>
</div>