<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * View Index
 * 
 * @package   templates/tellknologia
 * @name      index
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     19/06/2013
 * 
 */

$js[] = $this->config->item('tpl_admin_js') . 'jquery.min.js';
$js[] = $this->config->item('tpl_admin_js') . 'jquery-migrate-1.2.1.min.js';
$js[] = $this->config->item('tpl_admin_js') . 'jquery.jpanelmenu.js';
$js[] = $this->config->item('tpl_admin_js') . 'tinynav.js';
$js[] = $this->config->item('tpl_admin_js') . 'hagal_common.js';
$js[] = $this->config->item('tpl_admin_js') . 'jquery_cookie.js';

$js[] = $this->config->item('t_admin') . 'bootstrap/js/bootstrap.min.js';

$js[] = $this->config->item('tpl_admin_js') . 'custom/index.js';

$js[] = $this->config->item('tpl_admin_js') . 'lib/jqueryUI/jquery-ui-1.10.2.custom.min.js';
$js[] = $this->config->item('tpl_admin_js') . 'lib/inputmask/jquery.inputmask.bundle.js';
$js[] = $this->config->item('tpl_admin_js') . 'lib/iCheck/jquery.icheck.min.js';
$js[] = $this->config->item('tpl_admin_js') . 'lib/select2/select2.min.js';
$js[] = $this->config->item('tpl_admin_js') . 'lib/bootbox/bootbox.min.js';

$js[] = $this->config->item('tpl_admin_js') . 'pages/hagal_responsive_table.js';

$js[] = $this->config->item('tpl_admin_js') . 'lib/datepicker/js/bootstrap-datepicker.js';
$js[] = $this->config->item('tpl_admin_js') . 'lib/timepicker/js/bootstrap-timepicker.min.js';
$js[] = $this->config->item('tpl_admin_js') . 'lib/colorpicker/js/bootstrap-colorpicker.js';
$js[] = $this->config->item('tpl_admin_js') . 'lib/datepicker/js/locales/bootstrap-datepicker.' . _idioma() . '.js';
$js[] = $this->config->item('tpl_admin_js') . 'pages/hagal_form_elements.js';
$js[] = 'assets/javascript/ajax/index.js';

if(isset($assets_js)) {
        
    foreach($assets_js as $g) {
    
        $js[] = 'assets/javascript/' . $g;
    }
}

if(isset($template_js)) {
    
    foreach($template_js as $g) {
    
        $js[] = $this->config->item('tpl_admin_js') . $g;
    }
}
$dados_header['import_js'] = $js;
$this->load->view('../../'.$this->config->item('t_admin') . 'header',$dados_header);

?>
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
        <header id="header">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="logo_holder">
                            <?php 
                            $logo = _verifica_extensao($this->config->item('url_arquivos_default') . 'logo');
                            if($logo){
                            ?>
                            <a href="<?php echo base_url($this->config->item('admin'));?>" class="main_logo"><img src="<?php echo base_url($logo);?>" alt="<?php echo $this->config->item('sis_nome');?>"></a>
                            <?php
                            }
                            else{
                            ?>
                            <a href="<?php echo base_url($this->config->item('admin'));?>" class="main_logo"><img src="http://placehold.it/150x40&amp;text=Logotipo" alt="<?php echo _lang('form_logotipo');?>"></a>
                            <?php
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
        </header>
        
        <!-- Conteudo -->
        <section id="main_section">

            <div class="container-fluid">
                <div id="contentwrapper">

                    <!-- Content -->
                    <div id="content">

                        <!-- breadcrumbs -->
                        <section id="breadcrumbs">

                            <?php $this->load->view('../../' . $this->config->item('t_admin') . 'breadcrumbs'); ?>

                        </section>

                        <div class="row-fluid">
                            <div class="span12">
                                <!--<div class="box_a">-->
                                    <?php $this->load->view($conteudo); ?>
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /content -->
                <!-- Sidebar Menu -->
                    <?php $this->load->view('../../' . $this->config->item('t_admin') . 'menu'); ?>
                <!-- /sidebar -->
                <!-- Sidebar Filtro -->
                <?php
                
                //Verifica se deve carregar o filtro
                $data['filtro']['formulario'] = ((isset($filtro['formulario']))?$filtro['formulario']:FALSE);
                $this->load->view('../../' . $this->config->item('t_admin') . 'filtro',$data); 
                ?>
                <!-- /sidebar -->
                <div id="footer_space"></div>
            </div>
        </section>
    </div>
<!-- /conteudo -->

<!--Inicio footer-->

<?php $this->load->view('../../' . $this->config->item('t_admin') . 'footer'); ?>

<!--Final footer-->
</body>

</html>