<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View exibe os dados do usuário
 * 
 * @package   Views/adm
 * @name      minha_conta
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     13/05/2013
 */

if($this->session->flashdata('msg') != ""){
    ?>
    <div class="<?php echo $this->session->flashdata('tp'); ?>" style="margin-bottom: 1px;">
        <?php echo _lang($this->session->flashdata('msg')); ?>
        <button type="button" class="close" data-dismiss="alert">×</button> 
    </div>
    <br>
<?php
}
?> 
    <div class="box_a">
        <div class="box_a_heading">
            <h3>&nbsp;</h3>
        </div>

        <div class="box_a_content cnt_a user_profile">
            <div class="row-fluid">
                <?php
                echo form_open_multipart($url, array('class' => 'form-horizontal', 'id' => 'minha_conta'));
                ?>
                <div class="row-fluid">
                    <div class="span2">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 130px; height: 130px;">
                                <?php
                                $foto = _verifica_extensao($this->config->item('url_arquivos_admin_usuarios') . $this->session->userdata('usuario_id'));
                                $foto_default = _verifica_extensao($this->config->item('url_arquivos_default') . 'user_default');
                                if($foto){
                                    $url_foto = base_url($foto);
                                }
                                else if($foto_default){
                                    $url_foto = base_url($foto_default);
                                }
                                else{
                                    $url_foto = 'http://placehold.it/140x140&amp;text=Foto';
                                }
                                ?>
                                <img src="<?php echo $url_foto; ?>" alt="">
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                            <div>
                                <span class="btn btn-small btn-file">
                                    <span class="fileupload-new"><?php echo _lang('form_alterar'); ?></span>
                                    <span class="fileupload-exists"><?php echo _lang('form_alterar'); ?></span>
                                    <input type="file" name="userfile">
                                </span>
                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo _lang('form_remover'); ?></a>
                            </div>
                        </div>
                            <!--<img class="thumbnail" alt="" src="img/avatars/avatar_14.jpg">-->
                    </div>
                    <div class="span10">
                        <div class="tabbable tabbable-bordered">

                            <div class="tab-content">
                                <div id="tbp_a" class="tab-pane active">
                                    <?php
                                    //Carrega o conteudo do formulario
                                    $this->load->view($this->config->item('admin') . 'content/forms/minha_conta');
                                    ?>
                                    <div class="formSep">
                                        <button type="submit" class="btn btn-primary"><?php echo _lang('form_salvar'); ?></button>
                                        <button type="button" class="btn btn-danger" onClick="window.location='<?php echo base_url() . $this->config->item('admin') ?>'"><?php echo _lang('form_cancelar'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>

