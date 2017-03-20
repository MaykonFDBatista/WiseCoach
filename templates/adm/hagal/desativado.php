<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * View exibida quando o sistema esta desativado
 * 
 * @package   views
 * @name      desativado
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     20/06/2013
 * 
 */

?>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->config->item('sis_nome') . ' - ' . _lang('msg_sis_manutencao');?></title>
        <style type="text/css">
		/* reset */
		html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{border:0;font-size:100%;font:inherit;vertical-align:top;margin:0;padding:0}
                article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:none}table{border-collapse:collapse;border-spacing:0}
		body {padding:0px;font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;border-top:6px solid #E9E9E9}
		.error_wrapper {width:80%;margin:0 auto;border:1px solid #ddd;background:#f8f8f8;padding:20px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;}
        p.main_head {color:#424242;font-size:48px;margin-bottom:30px}
		p.sub_head {color:#BCBCBC;font-size:20px;text-transform:uppercase;line-height:1.3;margin-bottom:10px}
		p.sub_head a {color:#3299BB;text-decoration:none}
		p.sub_head a:hover {text-decoration:underline}
	</style>
        <?php 
        
        echo link_tag($this->config->item('t_admin') . 'bootstrap/css/bootstrap.min.css', 'stylesheet', 'text/css', 'screen');lnbreak();
        echo link_tag($this->config->item('tpl_admin_css') . 'style.css', 'stylesheet', 'text/css', 'screen');lnbreak();
        
        echo script_tag($this->config->item('tpl_admin_js') . 'jquery.min.js', 'text/javascript'); lnbreak();
        echo script_tag($this->config->item('t_admin') . 'bootstrap/js/bootstrap.min.js', 'text/javascript');lnbreak();
        ?>
    </head>
    <body>
        <!-- main wrapper (without footer) -->
        <div id="main-wrapper">
            <!--Inicio cabecalho-->
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container-fluid">

                        <?php $this->load->view('../../' . $this->config->item('t_admin') . 'cabecalho');?> 

                    </div>
                </div>
            </div>
            <!--Final cabecalho-->

            <div class="error_wrapper">
                <p class="main_head">Offline</p>
                <p class="sub_head"><?php echo _lang('msg_sis_desativado'); ?></p>
            </div>
        </div>
    </body>
</html>