<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Conteudo do formulario de edicao de funcionalidade
 * 
 * @package   views/content/forms
 * @name      funcionalidade_editar      
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     18/09/2013
 */

echo form_hidden('fun_id', (isset($funcionalidade->id) ? $funcionalidade->id : ''));
?>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="fun_nome" class="req"><?php echo _lang('form_nome'); ?>&nbsp;</label>
            <input type="text" name="fun_nome" placeholder="<?php echo _lang('form_nome'); ?>" value="<?php echo ((isset($funcionalidade->nome)) ? $funcionalidade->nome : '') ?>" class="span10"  />
        </div>
        <div class="span4">
            <label for="fun_url" class="req"><?php echo _lang('form_url'); ?>&nbsp;</label>
            <input type="text" name="fun_url" placeholder="<?php echo _lang('form_url'); ?>" value="<?php echo ((isset($funcionalidade->url)) ? $funcionalidade->url : '') ?>" class="span10"  />
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="fun_modulo" class="req"><?php echo _lang('form_modulo'); ?>&nbsp;</label>
            <?php
            $modulos[''] = _lang('form_selecione');
            echo form_dropdown('fun_modulo', _lang($modulos), (isset($funcionalidade->modulo_id)) ? $funcionalidade->modulo_id : '', 'class="styled-select span6"');
            ?>
        </div>
        <div class="span4">
            <label for="fun_ordem" class="req"><?php echo _lang('form_ordem'); ?>&nbsp;</label>
            <input type="text" name="fun_ordem" placeholder="<?php echo _lang('form_ordem'); ?>" value="<?php echo ((isset($funcionalidade->ordem)) ? $funcionalidade->ordem : '') ?>" class="span7"  />
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="fun_ativo" class="req"><?php echo _lang('form_status'); ?>&nbsp;</label>
            <div class="switch switch-small" data-on="success" data-on-label="<?php echo _lang('form_ativa');?>" data-off="danger" data-off-label="<?php echo _lang('form_inativa');?>">
                <?php echo form_checkbox('fun_ativo', '1', ((isset($funcionalidade->ativo) && ($funcionalidade->ativo > 0)) ? true : false));?>
            </div>
        </div>
    </div>
</div>
<div class="formSep" id="grupos">
    <label for="fun_grupos"><?php echo _lang('form_grupos_acesso');?>&nbsp;</label>
    <div class="controls">
        <?php
        if (isset($grupos)) {

            foreach ($grupos as $grupo) {

                $checked = FALSE;

                if (isset($com_acesso)) {

                    for ($i = 0; $i < sizeof($com_acesso); $i++) {

                        if ($com_acesso[$i] == $grupo->id) {

                            $checked = TRUE;
                            break;
                        }
                    }
                }
                echo '<p>' . form_checkbox('fun_grupos[]', $grupo->id, $checked, 'class="checkbox icheck"') . nbs() . _lang($grupo->nome) . '</p>';
            }
            echo '<span id="verifica_checkbox" class="text-error" style="display: none;">' . _lang('funcionalidade_grupo_nao_selecionado') . '</span>';
        }
        ?>
    </div>
</div>