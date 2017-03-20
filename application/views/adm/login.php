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
        
        echo script_tag('assets/javascript/validacao/mensagens/pt-BR.js', 'text/javascript'); lnbreak();
        
        echo script_tag($this->config->item('t_admin') . 'bootstrap/js/bootstrap.min.js', 'text/javascript'); lnbreak();
        
        echo script_tag('assets/javascript/ajax/login.js', 'text/javascript'); lnbreak();
        ?>
        
        <!--[if lt IE 9]>
            <style>
                select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {display:inline;min-height:20px !important}
            </style>
            <script src="<?php echo base_url('templates/adm/hagal/js/ie/html5shiv.min.js');?>"></script>
        <![endif]-->      
        
    </head>
    <body>
        <?php 
        echo form_input(array('name' => 'base_url' , 'id'=> 'base_url' , 'value' => base_url(), 'type' => 'hidden'));
        ?>
        <div class="login_box">
            <?php echo form_open($url, array('class' => 'row-fluid', 'id' => 'login_form')); ?>
            
            <div class="box_top">
                <?php 
                $logo = _verifica_extensao($this->config->item('url_arquivos_default') . 'logo');
                if($logo){
                ?>
                <img src="<?php echo base_url($logo);?>" alt="<?php echo $this->config->item('sis_nome');?>">
                <?php
                }
                else{
                ?>
                <img src="http://placehold.it/305x88&amp;text=Logotipo" alt="<?php echo _lang('form_logotipo');?>">
                <?php
                }
                ?>
            </div>
                <div class="box_content">
                    
                    <div class="row-fluid text-center"><strong><?php echo _lang('form_administracao');?></strong></div>
                    
                    <?php
                    if(validation_errors() != ''){
                        
                        echo '<div class="alert alert-error">' . validation_errors() . '</div>';
                    }
                    ?>
                    
                    <div class="row-fluid">
                        <?php 
                        // Carrega a view com os campos a serem preenchidos no login
                        $this->load->view($this->config->item('admin') . 'content/forms/login');
                        
                        echo form_submit(array('name' => 'entrar', 'value' => _lang('form_entrar'), 'class' => 'btn btn-block btn-primary btn-large'));
                        ?>
                        <p class="text-center minor_text"><a class="form_toggle" href="#pass_form"><?php echo _lang('form_esqueceu_senha');?></a></p>
                    </div>
                </div>
            <?php 
            
            echo form_close();
            ?>
            <form action="#" method="post" id="pass_form" style="display:none">
                <div class="box_top"><strong><?php echo _lang('form_esqueceu_senha'); ?></strong></div>    
                <div class="box_content">
                    <div class="row-fluid">
                        <?php 
                        
                         // Informa a url da imagem load que aparece no modal esqueci minha senha
                         $loaders = $this->config->item('adm_loaders');
                        
                         $this->load->view($this->config->item('admin') . 'content/forms/solicitar_redefinicao_senha',array('loader' =>$loaders[13]))
                        ?>
                        <a class="btn btn-block btn-primary btn-large" id="redefinir_senha"><?php echo _lang('form_enviar'); ?></a>
                    </div>
                </div>
                <div class="box_footer text-center clearfix minor_text">
                    <a class="form_toggle" href="#login_form">Voltar</a>
                </div>
            </form>
        </div>
    </body>
</html>