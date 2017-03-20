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

//echo '<pre>';
//print_r($app);
//die('</pre>');
//    
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
        echo form_open_multipart($url, array('class' => 'form-horizontal', 'id' => 'form_edita_app'));

        // Carrega a view com o conteudo do formulario
        $this->load->view($this->config->item('admin') . 'content/forms/app_editar');
        ?>
        <div class="formSep">
            <button type="submit" class="btn btn-primary"><?php echo _lang('form_salvar');?></button>
            <button type="button" class="btn btn-danger" onClick="window.location='<?php echo base_url() . $url_cancelar; ?>'"><?php echo _lang('form_cancelar');?></button>
            <?php
              if(!isset($app->id)){
            ?>
            <button type="submit" name="proximo" value="1" class="btn btn-info"><?php echo _lang('form_proximo_passo');?></button>
            <?php
              }
            ?>
        </div>
        <?php
        echo form_close();
        ?>
    </div>
</div>