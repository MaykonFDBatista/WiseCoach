<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

?>

<div class="box_a">
    <div class="box_a_heading">
            <h3>&nbsp;</h3>
    </div>

    <div class="box_a_content cnt_a">

        <div class="alert margin">
            <button type="button" class="close" data-dismiss="alert">×</button>
            * <?php echo _lang('form_obrigatorio');?>
        </div>
        <div id="msg" style="display:none;">
            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
        <?php
            echo form_open($url, array('class' => 'form-horizontal', 'id' => 'form_regra_pontuacao'));

            // Carrega a view com o conteudo do formulario
            $this->load->view($this->config->item('admin') . 'content/forms/regra_pontuacao_editar');
        ?>
        <div class="formSep">
            <button type="submit" class="btn btn-primary"><?php echo _lang('form_salvar');?></button>
            <button type="button" class="btn btn-danger" onClick="window.location='<?php echo base_url() . $url_cancelar; ?>'"><?php echo _lang('form_cancelar');?></button>
        </div>
        <?php
        echo form_close();
        ?>
    </div>
</div>


