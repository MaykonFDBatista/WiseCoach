<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View de edição de competidors.
 * 
 * @package   Views/adm/competidor
 * @name      Editar
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     2013
 */
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
        
        <?php
            echo form_open($url, array('class' => 'form-horizontal', 'id' => 'form_edita_competidor'));

            // Carrega a view com o conteudo do formulario
            $this->load->view($this->config->item('admin') . 'content/forms/competidor_editar');
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
