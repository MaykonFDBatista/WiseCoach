<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

echo form_hidden('id', (isset($badge->id) ? $badge->id : ''));

echo form_hidden('nome', (isset($badge->nome) ? $badge->nome : ''));
?>
<div class="formSep">
    <div class="span12">
        <label for="arquivo" class="req"><?php echo _lang('form_arquivo'); ?>&nbsp;</label>
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input input-large">
                    <i class="icon-file fileupload-exists"></i>
                    <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                    <span class="fileupload-new"><?php echo _lang('form_selecione');?></span>
                    <span class="fileupload-exists"><?php echo _lang('form_alterar');?></span>
                    <input type="file" name="arquivo" id="arquivo">
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo _lang('form_remover');?></a>
            </div>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="descricao" class=""><?php echo _lang('form_descricao'); ?>&nbsp;</label>
            <textarea name="descricao" id="descricao" placeholder="<?php echo _lang('form_descricao'); ?>" class="span10"><?php echo ((isset($badge->descricao)) ? $badge->descricao : '') ?></textarea>
        </div>
    </div>
</div>
 <div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="regra_concessao" class=""><?php echo _lang('form_regra_concessao'); ?>&nbsp;</label>
            <?php 
            echo form_dropdown('regra_concessao',$regras,((isset($badge->regra_concessao)) ? $badge->regra_concessao : ''),'class="formated_select span8" id="regra_concessao"');
            ?>
        </div>
    </div>
</div>
 <div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="parametro_concessao" class=""><?php echo _lang('form_parametro_concessao'); ?>&nbsp;</label>
            <?php 
            echo form_input('parametro_concessao',((isset($badge->parametro_concessao)) ? $badge->parametro_concessao : ''),'class="span8" id="parametro_concessao"');
            ?>
        </div>
    </div>
</div>