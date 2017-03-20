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
                <h1><?php echo _lang('menu_loja'); ?></h1>
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
                    <form role="form" id="form_loja" action="<?php echo $url; ?>" method="post" enctype="multipart/form-data">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="jumbotron">
                                    <p><i class="glyphicon glyphicon-tags"></i> <?php echo _lang('form_voce_possui') . ' <span class="label label-primary">' . $competidor->pontos . 'pts</span>';?></p>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="regra_loja"><b><?php echo _lang('form_escolha_um_dos_itens_abaixo') . ', ' . _lang('form_para_trocar_seus_pontos'); ?>&nbsp;</b></label>
                                            <?php
                                            if (isset($regras_loja)) {

                                                foreach ($regras_loja as $regra) {
                                                    echo '<p>' . form_radio('regras[]', $regra->id, false,'class="icheck" data-icheck-color="aero"') . nbs() . _lang($regra->descricao) . ' - <span class="label label-default">' . $regra->pontos . ' ' . _lang('form_pontos') . '</span></p>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="regra_pontuacao"><b><?php echo _lang('form_adquira_pontos'); ?>&nbsp;</b></label>
                                            <?php
                                            if (isset($regra_pontuacao)) {

                                                foreach ($regra_pontuacao as $regra) {
                                                    echo '<p>' . _lang($regra->descricao) . ' - <span class="label label-info">' . $regra->pontos . ' ' . _lang('form_pontos') . '</span></p>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><?php echo _lang('form_problema');?></label>
                                            <?php echo form_dropdown('problema_id', array(),'','class="form-control"');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <button type="submit" class="btn"><?php echo _lang('form_comprar'); ?></button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>