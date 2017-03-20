<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!-- Page Title -->
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?php echo _lang('menu_cadastrar');?></h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-8">
                <div class="basic-login">
                    <form role="form" id="form_cadastro_competidor" action="<?php echo $url;?>" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="com_nome"><i class="icon-user"></i> <b><?php echo _lang('form_nome');?>&nbsp;*</b></label>
                                    <input name="com_nome" class="form-control" id="com_nome" type="text" placeholder="<?php echo _lang('form_nome');?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="com_email"><i class="icon-user"></i> <b><?php echo _lang('form_email');?>&nbsp;*</b></label>
                                    <input name="com_email" class="form-control" id="email" type="text" placeholder="<?php echo _lang('form_email');?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="com_senha"><i class="icon-lock"></i> <b><?php echo _lang('form_senha');?>&nbsp;*</b></label>
                                    <input name="com_senha" class="form-control" id="nova_senha" type="password" placeholder="<?php echo _lang('form_senha');?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="com_senha2"><i class="icon-lock"></i> <b><?php echo _lang('form_confirmar_senha'); ?>&nbsp;*</b></label>
                                    <input name="com_senha2" class="form-control" id="com_senha2" type="password" placeholder="<?php echo _lang('form_confirmar_senha'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="com_telefone"><i class="icon-user"></i> <b><?php echo _lang('form_telefone');?></b></label>
                                    <input name="com_telefone" class="form-control telefone" id="com_telefone" type="text" placeholder="<?php echo _lang('form_telefone');?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="com_celular"><i class="icon-user"></i> <b><?php echo _lang('form_celular');?></b></label>
                                    <input name="com_celular" class="form-control telefone" id="com_celular" type="text" placeholder="<?php echo _lang('form_celular');?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6 product-details">
                                    <label for="com_idioma"><i class="icon-user"></i> <b><?php echo _lang('form_idioma');?>&nbsp;*</b></label>
                                    <?php
                                        $idioma_selecionado = $this->session->userdata('idioma');
                                        if($idioma_selecionado == ''){
                                            $idioma_selecionado = $this->config->item('idioma_default');
                                        }
                                    ?>
                                    <input name="com_idioma" class="form-control" id="com_idioma" type="hidden" value="<?php echo $idioma_selecionado; ?>">
                                    <table class="shop-item-selections">
                                        <tr>
                                            <td>
                                                <div class="dropdown choose-item-color">
                                                    <a id="idioma_selecionado" class="btn btn-sm btn-grey" data-toggle="dropdown" href="#">
                                                        <?php
                                                        $idiomas = $this->config->item('sis_idiomas');
                                                        $idioma_selecionado_label = $idiomas[$idioma_selecionado];
                                                        $bandeira_selecionado = strtolower(substr($idioma_selecionado, -2));
                                                        ?>
                                                        <img src="<?php echo base_url() . $this->config->item('tpl_pasta') . 'img/flags/'. $bandeira_selecionado .'.png'; ?>" alt="<?php echo $idioma_selecionado; ?>"> <?php echo $idioma_selecionado_label; ?> <b class="caret"></b>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <?php
                                                        foreach($idiomas as $idioma => $idioma_label){
                                                            $bandeira = strtolower(substr($idioma, -2));
                                                        ?>
                                                        <li role="menuitem">
                                                            <a class="idioma_item apontador" data-key="<?php echo $idioma;?>">
                                                                <img src="<?php echo base_url() . $this->config->item('tpl_pasta') . 'img/flags/'. $bandeira .'.png'; ?>" alt="<?php echo $idioma; ?>"> <?php echo $idioma_label; ?>
                                                            </a>
                                                        </li>
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="com_materias"><i class="icon-user"></i> <b><?php echo _lang('form_materias_conhecimento');?>&nbsp;*</b></label>
                                    <?php
                                    if (isset($materias)) {

                                        foreach ($materias as $materia) {
                                            echo '<p>' . form_checkbox('com_materias[]', $materia->id, false) . nbs() . _lang($materia->nome) . '</p>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-6">
                                    <label for="com_categorias"><i class="icon-user"></i> <b><?php echo _lang('form_categorias_conhecimento');?>&nbsp;*</b></label>
                                    <?php
                                    if (isset($categorias)) {

                                        foreach ($categorias as $categoria) {
                                            echo '<p>' . form_checkbox('com_categorias[]', $categoria->id, false) . nbs() . _lang($categoria->nome) . '</p>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn pull-right"><?php echo _lang('form_cadastrar'); ?></button>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>