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
                <h1><?php echo _lang('menu_login');?></h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
                <?php
                $msg = '';
                if ($this->session->flashdata('msg') != "") {
    
                    switch ($this->session->flashdata('msg')) {

                        case 'msg_insert-ok': {
                                $tp = 'alert alert-success';
                                $msg = 'msg_efetue_login';
                            } break;
                        case 'msg_error': {
                                $tp = 'alert alert-danger';
                            } break;
                        case 'msg_email_incorreto': {
                                $tp = 'alert alert-danger';
                            } break;
                        case 'msg_senha_incorreta': {
                                $tp = 'alert alert-danger';
                            } break;
                        case 'msg_logout-ok': {
                                $tp = 'alert alert-success';
                            } break;
                        default: {
                                $tp = 'alert alert-warning';
                            } break;
                    }
                    echo '<div class="' . $tp . '">' . _lang($this->session->flashdata('msg')) . " " . _lang($msg) . "<button type='button' class='close' data-dismiss='alert'>×</button> </div>";
                }
                ?>
                <div class="basic-login">
                    <form role="form" role="form" id="form_login" method="post" action="<?php echo $url;?>">
                        <div class="form-group">
                            <label for="email"><i class="icon-user"></i> <b><?php echo _lang('form_email'); ?></b></label>
                            <input class="form-control" name="email" id="email" type="text" value="<?php echo ($this->session->flashdata('email') != "") ? $this->session->flashdata('email') : '';  ?>" placeholder="<?php echo _lang('form_email'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="login-password"><i class="icon-lock"></i> <b><?php echo _lang('form_senha'); ?></b></label>
                            <input class="form-control" name="senha" id="senha" type="password" placeholder="<?php echo _lang('form_senha'); ?>">
                        </div>
                        <div class="form-group">
                            <a href="page-password-reset.html" class="forgot-password" id="esqueceu_senha"><?php echo _lang('form_esqueceu_senha'); ?></a>
                            <button type="submit" class="btn pull-right"><?php echo _lang('form_login'); ?></button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="not-member">
                                <p><?php echo _lang('form_nao_possui_conta'); ?> <a href="<?php echo base_url($this->config->item('ws')) . '/cadastro';?>"><?php echo _lang('form_cadastre_se'); ?></a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>