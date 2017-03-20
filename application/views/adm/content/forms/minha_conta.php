<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Conteudo do formulario Minha conta
 * 
 * @package   views/content
 * @name      minha_conta
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     18/09/2013
 */


echo form_input(array('name' => 'usu_id', 'id' => 'usu_id', 'value' => (isset($usuario->id) ? $usuario->id : ''), 'type' => 'hidden'));

?> 
<div class="formSep">
    <div class="row-fluid">
        <div class="span6">
            <label for="usu_nome" class="req"><?php echo _lang('form_nome'); ?>&nbsp;</label>
            <input type="text" name="usu_nome" placeholder="<?php echo _lang('form_nome'); ?>" value="<?php echo isset($usuario->nome) ? $usuario->nome : ''; ?>" class="span9"  />
        </div>
        <div class="span6">
            <label for="usu_email" class="req"><?php echo _lang('form_email'); ?>&nbsp;</label>
            <input type="text" name="usu_email" id="usu_email" placeholder="<?php echo _lang('form_email'); ?>" value="<?php echo ((isset($usuario->email)) ? $usuario->email : '') ?>" class="span8"  />
        </div>
    </div>
</div>
<div class="formSep">
    <label for="senha_anterior"><?php echo _lang('form_senha_atual'); ?>&nbsp;</label>
    <input type="password" name="senha_anterior" placeholder="<?php echo _lang('form_senha_atual'); ?>" value="" class="span4"  />
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span6">
            <label for="nova_senha"><?php echo _lang('form_nova_senha'); ?>&nbsp;</label>
            <input type="password" name="nova_senha" id="nova_senha" placeholder="<?php echo _lang('form_nova_senha'); ?>" value="" class="span8"/>
            <div id="pass_progressbar" class="progress progress-danger progress-small" style="max-width:48.7%;">
                <div id="pass_progress" class="bar"></div>
            </div>
            <div class="span4">
                <span id="complexityLabel"><?php echo _lang('form_complexidade');?>: </span>
                <span id="complexity">0%</span>
            </div>
        </div>
        <div class="span6">
            <label for="password"><?php echo _lang('form_redigite_senha'); ?>&nbsp;</label>
            <input type="password" name="nova_senha2" placeholder="<?php echo _lang('form_redigite_senha'); ?>" value="" class="span8"  />
        </div>
    </div>
</div>
<div class="formSep">
    <div class="span4 pb10">
        <label for="usu_telefone"><?php echo _lang('form_telefone'); ?>&nbsp;</label>
        <input type="text" name="usu_telefone" placeholder="<?php echo _lang('form_telefone'); ?>" data-inputmask="'mask': '(99)9999-9999[9]'" value="<?php echo ((isset($usuario->telefone)) ? $usuario->telefone : '') ?>" class="span12 telefone"  />
    </div>
    <div class="span4 pb10">
        <label for="usu_celular"><?php echo _lang('form_celular'); ?>&nbsp;</label>
    <input type="text" name="usu_celular" placeholder="<?php echo _lang('form_celular'); ?>" data-inputmask="'mask': '(99)9999-9999[9]'" value="<?php echo ((isset($usuario->celular)) ? $usuario->celular : '') ?>" class="span12 telefone"  />
    </div>
</div>
<div class="formSep">
    <label for="usu_idioma"><?php echo _lang('form_idioma'); ?>&nbsp;</label>
    <?php
    $idiomas = $this->config->item('sis_idiomas');
    $idiomas[''] = _lang('form_selecione');

    echo form_dropdown('usu_idioma', $idiomas, (isset($usuario->idioma)) ? $usuario->idioma : '', 'class="styled-select"');
    ?>
</div>
