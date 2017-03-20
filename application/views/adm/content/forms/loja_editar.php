<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

echo form_hidden('id', (isset($loja->id) ? $loja->id : ''));
?>
<div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="descricao" class=""><?php echo _lang('form_descricao'); ?>&nbsp;</label>
            <input type="text" name="descricao" id="descricao" placeholder="<?php echo _lang('form_descricao'); ?>" class="span10" value="<?php echo ((isset($loja->descricao)) ? $loja->descricao : '') ?>" />
        </div>
    </div>
</div>
 <div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="pontos" class=""><?php echo _lang('form_pontos'); ?>&nbsp;</label>
            <?php 
            echo form_input('pontos',((isset($loja->pontos)) ? $loja->pontos : ''),'class="span8" id="pontos"');
            ?>
        </div>
    </div>
</div>