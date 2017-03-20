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
                <h1><?php echo _lang('menu_perfil'); ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-10">
                <?php
                if ($this->session->flashdata('msg') != "") {

                    switch ($this->session->flashdata('msg')) {

                        case 'msg_update-ok': {
                                $tp = 'alert alert-success';
                            } break;
                        case 'msg_error': {
                                $tp = 'alert alert-danger';
                            } break;
                        default: {
                                $tp = 'alert alert-warning';
                            } break;
                    }
                    echo '<div class="' . $tp . '">' . _lang($this->session->flashdata('msg')) . "<button type='button' class='close' data-dismiss='alert'>×</button> </div>";
                }
                ?>
                <div class="basic-login">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#perfil" aria-controls="perfil" role="tab" data-toggle="tab"><?php echo _lang('form_dados_pessoais'); ?></a></li>
                        <li role="presentation"><a href="#estilo" aria-controls="estilo" role="tab" data-toggle="tab"><?php echo _lang('form_estilo_aprendizagem'); ?></a></li>
                        <li role="presentation"><a href="#estatisticas" aria-controls="estatisticas" role="tab" data-toggle="tab"><?php echo _lang('form_estatisticas'); ?></a></li>
                        <li role="presentation"><a href="#badge" aria-controls="badge" role="tab" data-toggle="tab"><?php echo _lang('form_badges'); ?></a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="perfil">
                            <form role="form" id="form_perfil" action="<?php echo $url; ?>" method="post" enctype="multipart/form-data">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                                            <img src="<?php echo _foto_competidor(); ?>" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                                        <div>
                                                            <span class="btn btn-default btn-file"><span class="fileinput-new"><?php echo _lang('form_selecione'); ?></span>
                                                                <span class="fileinput-exists"><?php echo _lang('form_alterar'); ?></span>
                                                                <input type="file" name="foto"></span>
                                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><?php echo _lang('form_remover'); ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <?php
                                                                $atributos_id = array('type' => 'hidden',
                                                                    'value' => (isset($competidor) ? $competidor->id : ''),
                                                                    'name' => 'com_id'
                                                                );
                                                                echo form_input($atributos_id);
                                                                ?>
                                                                <label for="com_nome"><i class="icon-user"></i> <b><?php echo _lang('form_nome'); ?>&nbsp;*</b></label>
                                                                <input name="com_nome" value="<?php echo (isset($competidor) ? $competidor->nome : ''); ?>" class="form-control" id="com_nome" type="text" placeholder="<?php echo _lang('form_nome'); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">        
                                                        <div class="col-sm-12">
                                                            <label for="com_email"><i class="icon-user"></i> <b><?php echo _lang('form_email'); ?>&nbsp;*</b></label>
                                                            <input name="com_email" value="<?php echo (isset($competidor) ? $competidor->email : ''); ?>" class="form-control" id="email" type="text" placeholder="<?php echo _lang('form_email'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="com_senha"><i class="icon-lock"></i> <b><?php echo _lang('form_senha'); ?>&nbsp;*</b></label>
                                                    <input name="com_senha" class="form-control" id="nova_senha" type="password" placeholder="<?php echo _lang('form_senha'); ?>">
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
                                                    <label for="com_telefone"><i class="icon-user"></i> <b><?php echo _lang('form_telefone'); ?></b></label>
                                                    <input name="com_telefone" value="<?php echo (isset($competidor) ? $competidor->telefone : ''); ?>" class="form-control telefone" id="com_telefone" type="text" placeholder="<?php echo _lang('form_telefone'); ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="com_celular"><i class="icon-user"></i> <b><?php echo _lang('form_celular'); ?></b></label>
                                                    <input name="com_celular" value="<?php echo (isset($competidor) ? $competidor->celular : ''); ?>" class="form-control telefone" id="com_celular" type="text" placeholder="<?php echo _lang('form_celular'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 product-details">
                                                    <label for="com_idioma"><i class="icon-user"></i> <b><?php echo _lang('form_idioma'); ?>&nbsp;*</b></label>
                                                    <input name="com_idioma" class="form-control" id="com_idioma" type="hidden" value="<?php echo (isset($competidor) ? $competidor->idioma : ''); ?>">
                                                    <table class="shop-item-selections">
                                                        <tr>
                                                            <td>
                                                                <div class="dropdown choose-item-color">
                                                                    <a id="idioma_selecionado" class="btn btn-sm btn-grey" data-toggle="dropdown" href="#">
                                                                        <?php
                                                                        $idioma_selecionado_label = $idiomas[$competidor->idioma];
                                                                        $bandeira_selecionado = strtolower(substr($competidor->idioma, -2));
                                                                        ?>
                                                                        <img src="<?php echo base_url() . $this->config->item('tpl_pasta') . 'img/flags/' . $bandeira_selecionado . '.png'; ?>" alt="<?php echo $competidor->idioma; ?>"> <?php echo $idioma_selecionado_label; ?> <b class="caret"></b>
                                                                    </a>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                        <?php
                                                                        foreach ($idiomas as $idioma => $idioma_label) {
                                                                            $bandeira = strtolower(substr($idioma, -2));
                                                                            ?>
                                                                            <li role="menuitem">
                                                                                <a class="idioma_item apontador" data-key="<?php echo $idioma; ?>">
                                                                                    <img src="<?php echo base_url() . $this->config->item('tpl_pasta') . 'img/flags/' . $bandeira . '.png'; ?>" alt="<?php echo $idioma; ?>"> <?php echo $idioma_label; ?>
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
                                                    <label for="com_materias"><i class="icon-user"></i> <b><?php echo _lang('form_materias_conhecimento'); ?>&nbsp;*</b></label>
                                                    <?php
                                                    if (isset($materias)) {

                                                        foreach ($materias as $materia) {
                                                            echo '<p>' . form_checkbox('com_materias[]', $materia->id, in_array($materia->id, $competidor_materias),'class="icheck" data-icheck-color="aero"') . nbs() . _lang($materia->nome) . '</p>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="com_categorias"><i class="icon-user"></i> <b><?php echo _lang('form_categorias_conhecimento'); ?>&nbsp;*</b></label>
                                                    <?php
                                                    if (isset($categorias)) {

                                                        foreach ($categorias as $categoria) {
                                                            echo '<p>' . form_checkbox('com_categorias[]', $categoria->id, in_array($categoria->id, $competidor_categorias),'class="icheck" data-icheck-color="aero"') . nbs() . _lang($categoria->nome) . '</p>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" class="btn"><?php echo _lang('form_salvar'); ?></button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="estilo">
                            <?php $this->load->view($this->config->item('ws') . 'perfil/estilo_aprendizagem');?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="estatisticas">
                            <?php $this->load->view($this->config->item('ws') . 'perfil/estatisticas');?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="badge">
                            <?php $this->load->view($this->config->item('ws') . 'perfil/badge');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>