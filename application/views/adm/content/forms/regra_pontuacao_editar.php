<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

echo form_hidden('id', (isset($regra_pontuacao->id) ? $regra_pontuacao->id : ''));
?>
<div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="descricao" class=""><?php echo _lang('form_descricao'); ?>&nbsp;</label>
            <input type="text" name="descricao" id="descricao" placeholder="<?php echo _lang('form_descricao'); ?>" class="span10" value="<?php echo ((isset($regra_pontuacao->descricao)) ? $regra_pontuacao->descricao : '') ?>" />
        </div>
    </div>
</div>
 <div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="pontos" class=""><?php echo _lang('form_pontos'); ?>&nbsp;</label>
            <?php 
            echo form_input('pontos',((isset($regra_pontuacao->pontos)) ? $regra_pontuacao->pontos : ''),'class="span8" id="pontos"');
            ?>
        </div>
    </div>
</div>