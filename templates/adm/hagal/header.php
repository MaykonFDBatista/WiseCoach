<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * View header
 * 
 * @package   templates/tellknologia
 * @name      header
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     19/06/2013
 * 
 */

echo doctype('html5');

?>

<html lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml">

<head>

    <title><?php echo $this->config->item('sis_nome') ; echo (isset($titulo))? ' | ' . _lang($titulo):''?></title>

<noscript>
    <meta http-equiv="Refresh" content="1; url=<?php echo base_url('assets/js_off.php') ?>">
</noscript>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<?php
$meta = array(
    array('name' => 'robots', 'content' => 'no-cache'),
    array('name' => 'description', 'content' => $this->config->item('sis_nome')),
    array('name' => 'keywords', 'content' => 'Tellks'),
    array('name' => 'robots', 'content' => 'no-cache'),
    array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
);

echo meta($meta);

echo link_tag($this->config->item('t_admin') . 'bootstrap/css/bootstrap.min.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('tpl_admin_js') . 'lib/footable/css/hagal_footable.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('tpl_admin_css') . 'elusive/css/elusive-webfont.css', 'stylesheet', 'text/css', 'screen');lnbreak();




echo link_tag(base_url() . 'assets/css/custom.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('t_admin') . 'js/lib/iCheck/skins/square/square.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('t_admin') . 'js/lib/select2/select2.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('t_admin') . 'js/lib/plupload/js/jquery.plupload.queue/css/plupload-hagal.css');lnbreak();

echo link_tag($this->config->item('t_admin') . 'js/lib/magnific/magnific-popup.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('t_admin') . 'js/lib/jqueryUI/css/Aristo/Aristo.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('t_admin') . 'js/lib/jqamp-ui-spinner/css/jqamp-ui-spinner.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('tpl_admin_css') . 'style.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('tpl_admin_css') . 'blue.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('t_admin') . 'js/lib/bootstrap-switch/bootstrapSwitch.css', 'stylesheet', 'text/css', 'screen');lnbreak();

echo link_tag($this->config->item('t_admin') . 'js/lib/datepicker/css/datepicker.css', 'stylesheet', 'text/css', 'screen');lnbreak();

// Importacao de arquivos javascript
if (isset($import_js)) {
    
    foreach ($import_js as $js) {

        echo script_tag($js, 'text/javascript');
        lnbreak();
    }
}
?>
<!--[if IE 8]><?php echo link_tag($this->config->item('tpl_admin_css') . 'css/ie8.css', 'stylesheet', 'text/css', 'screen');?><![endif]-->

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
<?php
    echo link_tag('http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300&amp;subset=latin,latin-ext', 'stylesheet', 'text/css', 'screen');lnbreak();
?>
</head>
    

