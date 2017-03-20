<!DOCTYPE HTML>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <?php
        $meta = array(
            array(
                'name' => 'Content-type',
                'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
            array(
                'http-equiv' => 'X-UA-Compatible',
                'content' => 'IE=edge,chrome=1'),
            array(
                'name' => 'description',
                'content' => $website->descricao),
            array(
                'name' => 'keywords',
                'content' => $website->palavras_chave),
            array(
                'name' => 'author',
                'content' => 'Alex Santini - alexsantini_spfc@hotmail.com'),
            array(
                'name' => 'viewport',
                'content' => 'width=device-width')
        );

        echo meta($meta);
        
        echo link_tag(base_url() . $this->config->item('tpl_pasta') . 'css/bootstrap.min.css', 'stylesheet', 'text/css', 'screen'), lnbreak();
        echo link_tag(base_url() . 'assets/css/jasny-bootstrap.min.css', 'stylesheet', 'text/css', 'screen'), lnbreak();
        echo link_tag(base_url() . 'assets/javascript/plugins/icheck/skins/square/_all.css', 'stylesheet', 'text/css', 'screen'), lnbreak();
        echo link_tag(base_url() . $this->config->item('tpl_pasta') . 'css/icomoon-social.css', 'stylesheet', 'text/css', 'screen'), lnbreak();
        echo link_tag(base_url() . $this->config->item('tpl_pasta') . 'css/coming-soon-social.css', 'stylesheet', 'text/css', 'screen'), lnbreak();
        echo link_tag('https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800', 'stylesheet', 'text/css', 'screen'), lnbreak();
        echo link_tag(base_url() . $this->config->item('tpl_pasta') . 'css/leaflet.css', 'stylesheet', 'text/css', 'screen'), lnbreak();
        ?>
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="<?php echo base_url() . $this->config->item('tpl_pasta') . 'css/leaflet.ie.css'?>" />
        <![endif]-->
        <?php
        echo link_tag(base_url() . $this->config->item('tpl_pasta') . 'css/main.css', 'stylesheet', 'text/css', 'screen'), lnbreak();
        
        echo link_tag(base_url() . 'assets/css/custom.css', 'stylesheet', 'text/css', 'screen'), lnbreak();
        
        echo script_tag($this->config->item('tpl_pasta') . 'js/modernizr-2.6.2-respond-1.1.0.min.js', 'text/javascript'), lnbreak();
        
        echo '<title>', $website->titulo, '</title>';
        ?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe"><?php echo _lang('msg_navegador_desatualizado');?></p>
        <![endif]-->
        
        <input type="hidden" id="base_url" value="<?php echo base_url() ?>">
        
        <?php
        if ($website->ativo == 1) {
            $this->load->view($this->config->item('tpl_ws') . 'menu');

            $this->load->view('ws/' . $conteudo);

            $this->load->view($this->config->item('tpl_ws') . 'rodape');
            
            echo script_tag($this->config->item('tpl_pasta') . 'js/jquery-1.9.1.min.js', 'text/javascript'), lnbreak();
            echo script_tag($this->config->item('tpl_pasta') . 'js/bootstrap.min.js', 'text/javascript'), lnbreak();
            echo script_tag('assets/javascript/plugins/jasny-bootstrap.min.js', 'text/javascript'), lnbreak();
            echo script_tag('http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js', 'text/javascript', TRUE), lnbreak();
            echo script_tag($this->config->item('tpl_pasta') . 'js/jquery.fitvids.js', 'text/javascript'), lnbreak();
            echo script_tag($this->config->item('tpl_pasta') . 'js/jquery.sequence-min.js', 'text/javascript'), lnbreak();
            echo script_tag($this->config->item('tpl_pasta') . 'js/jquery.bxslider.js', 'text/javascript'), lnbreak();
            echo script_tag($this->config->item('tpl_pasta') . 'js/main-menu.js', 'text/javascript'), lnbreak();
            echo script_tag($this->config->item('tpl_pasta') . 'js/template.js', 'text/javascript'), lnbreak();
        
            echo script_tag('assets/javascript/plugins/jquery.form.min.js', 'text/javascript'), lnbreak();
            echo script_tag('assets/javascript/plugins/jquery.validate.js', 'text/javascript'), lnbreak();
            echo script_tag('assets/javascript/plugins/inputmask/js/inputmask.js', 'text/javascript'), lnbreak();
            echo script_tag('assets/javascript/plugins/inputmask/js/jquery.inputmask.js', 'text/javascript'), lnbreak();
            $idioma_selecionado = $this->session->userdata('idioma');
            if($idioma_selecionado == ''){
                $idioma_selecionado = $this->config->item('idioma_default');
            }
            echo script_tag('assets/javascript/validacao/mensagens/'. $idioma_selecionado .'.js', 'text/javascript'); lnbreak();
            echo script_tag('assets/javascript/validacao/funcoes.js', 'text/javascript'), lnbreak();
            echo script_tag('assets/javascript/ajax/index_ws.js', 'text/javascript'), lnbreak();
            
            
            if (isset($assets_js) && is_array($assets_js)) {

                foreach ($assets_js as $js) {

                    echo script_tag('assets/javascript/' . $js, 'text/javascript'), lnbreak();
                }
            }

            if (isset($template_js) && is_array($template_js)) {

                foreach ($template_js as $js) {

                    echo script_tag($this->config->item('tpl_pasta') . 'js/' . $js, 'text/javascript'), lnbreak();
                }
            }

            if (isset($internet_js) && is_array($internet_js)) {

                foreach ($internet_js as $js) {
                    echo '<script src="' . $js . '"></script>', lnbreak();
                }
            }
        } else {
            $this->load->view($this->config->item('tpl_ws') . 'desativado');
        }
        ?>
        <script type="text/javascript" src="<?php echo base_url('clickheat/js/clickheat.js')?>"></script>
        <noscript><p><a href="http://www.dugwood.com/index.html">Heatmap plugin</a></p></noscript>
        <script type="text/javascript">
        var pagina = document.location.pathname.split('/');
        pagina = ((pagina.length >= 4) ? pagina[3] + '-' + pagina[4] : pagina[3]);
        
        clickHeatSite = 'wisecoach';
        clickHeatGroup = pagina;
        clickHeatServer = 'http://labsoft.muz.ifsuldeminas.edu.br/wisecoach2/clickheat/click.php';
        initClickHeat();
        </script>

    </body>
</html>
