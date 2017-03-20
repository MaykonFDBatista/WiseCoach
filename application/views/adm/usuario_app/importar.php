<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View de importação de condôminos em massa
 * 
 * @package   Views/condomino
 * @name      Importar
 * @author    Claudia dos Reis Silva <claudia.silva@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     08/08/2013
 */

echo form_open_multipart($url, array('class' => 'form-horizontal', 'id' => 'form_importar_usuario'));

// Mostra os dados do app sendo gerenciado
$this->load->view($this->config->item('admin') . 'app/dados_app');
?>
<!-- General form elements -->
    
    <div class="box_a">
            
        
        <div class="box_a_heading">
                    <h3>&nbsp;</h3>
            </div>
            
            <div class="box_a_content cnt_a">
                <div class="alert margin" style="margin-top: 16px;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo _lang('msg_info_file_formato');?><br>
                    -&nbsp;<?php echo _lang('form_obrigatorios') . ':&nbsp;'; echo implode(', ', $this->config->item('campos-obrigatorios'))?>
                </div>
                <div class="formSep clearfix">
                    <label for="labelfor" class="control-label"><?php echo _lang('form_arquivo');?>:&nbsp;</label>
                    <div class="span6">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="input-append">
                                <div class="uneditable-input input-small">
                                    <i class="icon-file fileupload-exists"></i>
                                    <span class="fileupload-preview"></span>
                                </div>
                                <span class="btn btn-file">
                                    <span class="fileupload-new"><?php echo _lang("form_selecione"); ?></span>
                                    <span class="fileupload-exists"><?php echo _lang("form_alterar"); ?></span>
                                    <input type="file" name="arquivo" >
                                </span>
                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo _lang("form_remover"); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="formSep">
                    <button type="submit" class="btn btn-primary"><?php echo _lang('form_importar');?></button>
                    <button type="button" class="btn btn-danger" onClick="window.location='<?php echo base_url() . $url_cancelar; ?>'"><?php echo _lang('form_cancelar');?></button>
                </div>
            </div>
        </div>
<?php
echo form_close();
?>