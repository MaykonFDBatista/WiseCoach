<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View de edição dos dados cadastrais de um condominio.
 * 
 * @package   Views/adm/condominio
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
        echo form_open_multipart($url, array('class' => 'form-horizontal', 'id' => 'form_edita_site'));

        // Carrega a view com o conteudo do formulario
        $this->load->view($this->config->item('admin') . 'content/forms/site_editar');
        ?>
        <div class="formSep">
            <button type="submit" class="btn btn-primary"><?php echo _lang('form_salvar');?></button>
        </div>
        <?php
        echo form_close();
        ?>
    </div>
</div>