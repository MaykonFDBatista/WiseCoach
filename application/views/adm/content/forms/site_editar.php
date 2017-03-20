<?php
if (!defined('BASEPATH'))
    exit('Sem permissao de acesso direto ao Script.');
/**
 * Conteudo do formulario de edicao de grupo
 * 
 * @package   views/content/forms
 * @name      site_editar   
 * @author    Maykon Filipe Dacioli Batista <maykon.batista@tellks.com.br>
 * @copyright Copyright (c) 2015, Tellks - Solucoes em tecnologia ltda
 * @since     07/01/2015
 */

//mensagens do cadastro
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
<div class="row-fluid">
    <div class="formSep">
        <div class="span6">
            <label for="site_titulo" class="req"><?php echo _lang('form_titulo'); ?>&nbsp;</label>
            <input type="text" name="site_titulo" placeholder="<?php echo _lang('form_titulo'); ?>" value="<?php echo ((isset($site->titulo)) ? $site->titulo : '') ?>" class="span11"  />
        </div>
        <div class="span2">
            <label><?php echo _lang('form_status'); ?>&nbsp;</label>
            <div class="switch switch-small" data-on="success" data-on-label="<?php echo _lang('form_ativo'); ?>" data-off="danger" data-off-label="<?php echo _lang('form_inativo'); ?>">
                <?php
                $checked = ($site->ativo == 1) ? true : false;
                
                echo form_checkbox('site_status', '1', $checked);
                ?>
            </div>
        </div>
        <div class="span4">
            <label for="site_video_institucional"><?php echo _lang('form_video_institucional'); ?>&nbsp;</label>
            <input type="text" name="site_video_institucional" placeholder="<?php echo _lang('form_video_institucional'); ?>" value="<?php echo ((isset($site->video)) ? $site->video : '') ?>" class="span12"  />
        </div>
    </div>
</div>

<div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="site_palavras_chave" class="req"><?php echo _lang('form_palavras_chaves'); ?>&nbsp;</label>
            <textarea type="text" name="site_palavras_chave" placeholder="<?php echo _lang('form_palavras_chaves'); ?>" class="span12" rows="3"><?php echo ((isset($site->palavras_chave)) ? $site->palavras_chave : '') ?></textarea>
        </div>
    </div>  
</div>

<div class="formSep">
    <div class="row-fluid">
        <div class="span8">
            <label for="site_descricao" class="req"><?php echo _lang('form_descricao'); ?>&nbsp;</label>
            <input type="text" name="site_descricao" placeholder="<?php echo _lang('form_descricao'); ?>" value="<?php echo ((isset($site->descricao)) ? $site->descricao : '') ?>" class="span12"  />
        </div>
        <div class="span4">
            <label for="site_email" class="req"><?php echo _lang('form_email'); ?>&nbsp;</label>
            <input type="text" name="site_email" placeholder="<?php echo _lang('form_email'); ?>" value="<?php echo ((isset($site->email)) ? $site->email : '') ?>" class="span12"  />
        </div>
    </div>
</div>

<div class="formSep">
    <div class="row-fluid">
        <div class="span8">
            <label for="site_endereco"><?php echo _lang('form_endereco'); ?>&nbsp;</label>
            <input type="text" name="site_endereco" placeholder="<?php echo _lang('form_endereco'); ?>" value="<?php echo ((isset($site->endereco)) ? $site->endereco : '') ?>" class="span12"  />
        </div>
        <div class="span4">
            <label for="site_telefone"><?php echo _lang('form_telefone'); ?>&nbsp;</label>
            <input type="text" name="site_telefone" placeholder="<?php echo _lang('form_telefone'); ?>" value="<?php echo ((isset($site->telefone)) ? $site->telefone : '') ?>" class="span12 telefone"  />
        </div>
    </div>
</div>

<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="site_facebook"><?php echo _lang('form_facebook'); ?>&nbsp;</label>
            <div class="input-prepend">
                <span class="add-on">
                    facebook.com/
                </span>
                <input type="text" name="site_facebook" value="<?php echo ((isset($site->facebook)) ? $site->facebook : '') ?>" class="span8"  />
            </div>
            
        </div>
        <div class="span4">
            <label for="site_twitter"><?php echo _lang('form_twitter'); ?>&nbsp;</label>
            <div class="input-prepend">
                <span class="add-on">
                    twitter.com/
                </span>
                <input type="text" name="site_twitter" value="<?php echo ((isset($site->twitter)) ? $site->twitter : '') ?>" class="span8"  />
            </div>
            
        </div>
        <div class="span4">
            <label for="site_google_plus"><?php echo _lang('form_google_plus'); ?>&nbsp;</label>
            <div class="input-prepend">
                <span class="add-on">
                    plus.google.com/+
                </span>
                <input type="text" name="site_google_plus" value="<?php echo ((isset($site->google_plus)) ? $site->google_plus : '') ?>" class="span8"  />
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="formSep">
        <div class="span12">
            <label for="site_texto_apresentacao" class=""><?php echo _lang('form_texto_apresentacao');?>:</label>
            <div class="box_a_content cnt_no_pad">
                <textarea class="wysiwg_editor" id="texto_apresentacao" name="site_texto_apresentacao" cols="30" rows="10"><?php  echo ((isset($site->texto_apresentacao)) ? $site->texto_apresentacao : ''); ?></textarea>
            </div>
        </div>
    </div>
</div>