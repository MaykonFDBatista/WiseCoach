<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View Login
 * Template de Login
 * 
 * @package   Views/adm
 * @name      login
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     2013
 */

echo doctype('html5');
?>

<html lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <title><?php echo $this->config->item('sis_nome') ;echo (isset($titulo)) ? ' | ' . _lang($titulo) : '' ?></title>

        <noscript>
            <meta http-equiv="Refresh" content="1; url=<?php echo base_url('assets/js_off.php') ?>">
        </noscript>
        
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
            
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

        <?php
        
        echo link_tag($this->config->item('t_admin') . 'bootstrap/css/bootstrap.min.css', 'stylesheet', 'text/css', 'screen');lnbreak();
        
        echo link_tag($this->config->item('tpl_admin_css') . 'login.css', 'stylesheet', 'text/css', 'screen');lnbreak();
        
        echo script_tag($this->config->item('tpl_admin_js') . 'jquery.min.js', 'text/javascript'); lnbreak();     
        
        echo script_tag($this->config->item('tpl_admin_js') . 'jquery.actual.min.js', 'text/javascript'); lnbreak();
        
        echo script_tag($this->config->item('tpl_admin_js') . 'lib/jquery-validation/jquery.validate.js', 'text/javascript'); lnbreak();
        
        echo script_tag($this->config->item('t_admin') . 'bootstrap/js/bootstrap.min.js', 'text/javascript'); lnbreak();
        
        echo script_tag('assets/javascript/ajax/login.js', 'text/javascript'); lnbreak();
        ?>
        
        <!--[if lt IE 9]>
            <style>
                select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {display:inline;min-height:20px !important}
            </style>
            <script src="js/ie/html5shiv.min.js"></script>
        <![endif]-->      
        
    </head>
    <body>
        <div class="login_box">
            <div class="box_top"><strong><?php echo _lang('msg_redefinir_senha_titulo'); ?></strong></div>
            <div class="box_content">
                <?php
                // Se ha mensagem para ser exibida
                if ($this->session->flashdata('msg') != "") {

                    switch ($this->session->flashdata('msg')) {

                        case 'msg_redefinir-senha-sucesso': {
                                $tp = 'alert alert-success';
                                // Indica que a senha foi alterada e que nao e mais preciso mostrar o formulario
                                $sucesso = TRUE;
                            } break;
                        default: {
                                $tp = 'alert alert-error';
                            } break;
                    }
                    // Exibe a mensagem de acordo com o tipo
                    echo '<div class="control-group"><div class="' . $tp . '" style="margin-bottom: 1px">' . _lang($this->session->flashdata('msg')) . " </div></div>";
                } else {
                    // Senao mostra a mensagem informativa sobre o que o usuario deve fazer
                    echo '<div class="control-group"><div class="alert alert-info" style="margin-bottom: 1px">' . _lang('msg_ola') . '&nbsp;' . $usuario->nome . '.<br>' . $this->config->item('redefinir-senha') . " </div></div>";
                }

                // Se ainda nao redefiniu a senha exibe o formulario
                if (!isset($sucesso) && isset($usuario)) {

                    echo form_open($url, array('class' => 'row-fluid', 'id' => 'form_redefinir_senha'));

                    echo form_input(array(
                        'name' => 'token',
                        'id' => 'token',
                        'value' => (isset($token)) ? $token : '',
                        'type' => 'hidden'));
                ?>
                <div class="control-group">
                    <label><?php echo _lang('form_email')?>:</label>
                    <div class="controls">
                        <?php 
                        echo form_input(array(
                                            'name'     => 'email',
                                            'id'       => 'email',
                                            'class'    => 'span12',
                                            'value'    => (isset($usuario->email)?$usuario->email:''), 
                                            'readonly' => '')); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo _lang('form_nova_senha')?>:</label>
                    <div class="controls">
                        <?php 
                        echo form_password(array(
                                               'name'  => 'nova_senha',
                                               'id'    => 'nova_senha',
                                               'class' => 'span12')); 
                        ?>
                    </div>
                </div>
                <!-- Solicita que redigite a senha -->
                <div class="control-group">
                    <label class="control-label"><?php echo _lang('form_confirmar_senha')?>:</label>
                    <div class="controls">
                        <?php 
                        echo form_password(array(
                                              'name'  => 'conf_senha',
                                              'id'    => 'conf_senha',
                                              'class' => 'span12')); 
                        ?>
                    </div>
                </div>

                <div class="login-btn">
                    <?php 
                    echo form_submit(array(
                                        'name'  => 'salvar',
                                        'value' => _lang('form_salvar'), 
                                        'class' => 'btn btn-block btn-primary btn-large')
                            ); 
                    ?>
                </div>
                <?php
                } else {
                    ?>
                    <div class="login-btn">
                    <?php
                    if (isset($sucesso))
                        echo anchor($this->config->item('admin') . 'login', _lang('form_entrar'), 'class="btn btn-block btn-primary btn-large"');
                    ?>
                    </div>
                        <?php
                    }
                    ?>
            </div>
        </div>
    </body>
</html>