<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Conteudo do formulario de edicao de usuario
 * 
 * @package   views/content/forms
 * @name      usuario_editar
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     18/09/2013
 */

echo form_hidden('usu_id', (isset($usuario->id) ? $usuario->id : ''));

echo form_input(array('name' => 'url_email_ajax' , 'id'=> 'url_email_ajax' , 'value' => base_url('ajax/email'), 'type' => 'hidden'));
?>
<div class="formSep">
    <div class="row-fluid">
        <div class="span5">
            <label for="usu_nome" class="req"><?php echo _lang('form_nome'); ?>&nbsp;</label>
            <input type="text" name="usu_nome" placeholder="<?php echo _lang('form_nome'); ?>" value="<?php echo ((isset($usuario->nome)) ? $usuario->nome : '') ?>" class="span11"  />
        </div>
        <div class="span5">
            <label for="usu_email" class="req"><?php echo _lang('form_email'); ?>&nbsp;</label>
            <input type="text" name="usu_email" id="usu_email" placeholder="<?php echo _lang('form_email'); ?>" value="<?php echo ((isset($usuario->email)) ? $usuario->email : '') ?>" class="span10"  />
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="usu_telefone"><?php echo _lang('form_telefone'); ?>&nbsp;</label>
            <input type="text" name="usu_telefone" placeholder="<?php echo _lang('form_telefone'); ?>" data-inputmask="'mask': '(99)9999-9999[9]'" value="<?php echo ((isset($usuario->telefone)) ? $usuario->telefone : '') ?>" class="span11"  />
        </div>
        <div class="span4">
            <label for="usu_celular"><?php echo _lang('form_celular'); ?>&nbsp;</label>
            <input type="text" name="usu_celular" placeholder="<?php echo _lang('form_celular'); ?>" data-inputmask="'mask': '(99)9999-9999[9]'" value="<?php echo ((isset($usuario->celular)) ? $usuario->celular : '') ?>" class="span11"  />
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="usu_senha"><?php echo _lang('form_senha'); ?>&nbsp;</label>
            <input type="password" name="usu_senha" placeholder="<?php echo _lang('form_senha'); ?>" value="" class="span11" id="nova_senha"  />
            <div id="pass_progressbar" class="progress progress-danger progress-small" style="max-width:48.7%;">
                <div id="pass_progress" class="bar"></div>
            </div>
            <div class="span4">
                <span id="complexityLabel"><?php echo _lang('form_complexidade');?>: </span>
                <span id="complexity">0%</span>
            </div>
        </div>
        <div class="span4">
            <label for="usu_senha2"><?php echo _lang('form_confirmar_senha'); ?>&nbsp;</label>
            <input type="password" name="usu_senha2" placeholder="<?php echo _lang('form_confirmar_senha'); ?>" value="" class="span11"  />
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span2">
            <label for="usu_ativo" class="req"><?php echo _lang('form_status'); ?>&nbsp;</label>
            <div class="switch switch-small" data-on="success" data-on-label="<?php echo _lang('form_ativo');?>" data-off="danger" data-off-label="<?php echo _lang('form_inativo');?>">
                <?php echo form_checkbox('usu_ativo', '1', ((isset($usuario->ativo) && ($usuario->ativo > 0)) ? true : false));?>
            </div>
        </div>
        <div class="span2">
            <label for="usu_idioma"><?php echo _lang('form_idioma'); ?>&nbsp;</label>
            <?php
            $idiomas = $this->config->item('sis_idiomas');
            $idiomas[''] = _lang('form_selecione');

            echo form_dropdown('usu_idioma', $idiomas, (isset($usuario->idioma)) ? $usuario->idioma : '', 'class="styled-select"');
            ?>
        </div>
    </div>
</div>
<div class="formSep">
    <label for="usu_grupos" class="req"><?php echo _lang('form_grupos'); ?>&nbsp;</label>
    
    <?php
    if (isset($grupos)) {

        foreach ($grupos as $grupo) {

            $checked = FALSE;
            if (isset($pertence)) {

                for ($i = 0; $i < sizeof($pertence); $i++) {

                    if ($pertence[$i] == $grupo->id) {

                        $checked = TRUE;
                        break;
                    }
                }
            }

            echo '<p>' . form_checkbox('usu_grupos[]', $grupo->id, $checked, 'class="checkbox icheck"') . nbs() . _lang($grupo->nome) . '</p>';
        }
        echo '<span id="verifica_checkbox" class="text-error" style="display: none;">' . _lang('usuario_grupo_nao_selecionado') . '</span>';
    }
    ?>
</div>