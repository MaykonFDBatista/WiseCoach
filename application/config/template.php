<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 | 
 | Configuracoes de template
 | @package Config
 |  
 | @author Tellks - Solucoes em tecnologia, Ltda <tellks.com.br>
 | @copyright Copyright (c) 2012, Tellks, Ltda.
 | @link http://tellks.com.br
 /


/*
|--------------------------------------------------------------------------
| Configuracoes de template
|--------------------------------------------------------------------------
|
| Configurações gerais de template da aplicacao
| Localizacao padrao: ./templates
|
*/

/*
| Parametros de configuracao
*/
$tpl_params['local']        = 'templates';                 //Localizacao dos templates. A partir do ./ do projeto
$tpl_params['tpl']          = 'hagal';                     //Define template padrao da aplicacao
$tpl_params['local_app']    = 'app';                       //Diretorio de templates da aplicacao dentro de $tpl_params['local']
$tpl_params['local_admin']  = 'adm';                       //Localizacao dos templates. A partir do ./$tpl_params['local']/
$tpl_params['local_ws']     = 'ws';                        //Localizacao dos templates. A partir do ./$tpl_params['local']/
$tpl_params['tpl_admin']    = 'hagal';                     //Define template padrao da administracao
$tpl_params['img']          = 'img';                       //Diretorio padrao de imagens
$tpl_params['css']          = 'css';                       //Diretorio padrao de Folhas de estilos CSS
$tpl_params['js']           = 'js';                        //Diretorio padrao de arquivos Javascript

/*
| Definicao das variaveis de template da aplicacao
*/
$config['t']                = $tpl_params['local'] . '/' . $tpl_params['local_app'] . '/' . $tpl_params['tpl'] . '/';
$config['tpl']              = '../../' . $config['t'] . 'index.php';                        //Carregado a partir de ./applications/controller/
$config['tpl_img']          = $config['t'] . $tpl_params['img'] . '/';
$config['tpl_css']          = $config['t'] . $tpl_params['css'] . '/';
$config['tpl_js']           = $config['t'] . $tpl_params['js'] . '/';

// Diretorio da aplicacao
//$config['app']              = $tpl_params['local_app'] . '/';

// View de login da aplicacao
$config['tpl_login']        = $tpl_params['local_admin'] . '/login';

// View de login do website
$config['tpl_login_ws']        = $tpl_params['local_ws'] . '/login';

$config['t_admin']          = $tpl_params['local'] . '/' . $tpl_params['local_admin'] . '/' . $tpl_params['tpl_admin'] . '/';
$config['tpl_admin']        = '../../' . $config['t_admin'] . 'index.php';
$config['tpl_admin_img']    = $config['t_admin'] . $tpl_params['img'] . '/';
$config['tpl_admin_css']    = $config['t_admin'] . $tpl_params['css'] . '/';
$config['tpl_admin_js']     = $config['t_admin'] . $tpl_params['js'] . '/';

// Diretorio da administracao da aplicacao
$config['admin']            = $tpl_params['local_admin'] . '/';

// Diretorio do site
$config['ws']               = $tpl_params['local_ws'] . '/';

/*
|--------------------------------------------------------------------------
| Sistema desativado
|--------------------------------------------------------------------------
|
| View exibida quando o sistema esta desativado
|
*/

$config['admin_desativado']    = '../../' . $config['t_admin'] . 'desativado';

$config['frontend_desativado'] = '../../' . $config['t'] . 'desativado';

/*
|--------------------------------------------------------------------------
| Copyright
|--------------------------------------------------------------------------
|
| Descricao dos direitos de copia. Exibido no footer do sistema
|
*/
$config['copyright'] = 'Copyright © ' . date('Y');

/*
|--------------------------------------------------------------------------
| Nome
|--------------------------------------------------------------------------
|
| Nome do sistema exibido no titulo da pagina
|
*/
$config['sis_nome'] = 'Wise Coach';


/*
|--------------------------------------------------------------------------
| Configuracoes do template pannonia
|--------------------------------------------------------------------------
|
| Contem urls de conteudos especificos do template
|
*/


// Imagens de loaders do backend
$config['adm_loaders'] = array(
                                $config['tpl_admin_img'] . 'loaders/1.gif',
                                $config['tpl_admin_img'] . 'loaders/1s.gif',
                                $config['tpl_admin_img'] . 'loaders/2.gif',
                                $config['tpl_admin_img'] . 'loaders/2s.gif',
                                $config['tpl_admin_img'] . 'loaders/3.gif',
                                $config['tpl_admin_img'] . 'loaders/3s.gif',
                                $config['tpl_admin_img'] . 'loaders/4.gif',
                                $config['tpl_admin_img'] . 'loaders/4s.gif',
                                $config['tpl_admin_img'] . 'loaders/5.gif',
                                $config['tpl_admin_img'] . 'loaders/5s.gif',
                                $config['tpl_admin_img'] . 'loaders/6.gif',
                                $config['tpl_admin_img'] . 'loaders/6s.gif',
                                $config['tpl_admin_img'] . 'loaders/7.gif',
                                $config['tpl_admin_img'] . 'loaders/7s.gif',
                                $config['tpl_admin_img'] . 'loaders/8.gif',
                                $config['tpl_admin_img'] . 'loaders/8s.gif',
                                $config['tpl_admin_img'] . 'loaders/9.gif',
                                $config['tpl_admin_img'] . 'loaders/9s.gif',
                                $config['tpl_admin_img'] . 'loaders/10.gif',
                                $config['tpl_admin_img'] . 'loaders/10s.gif',
                        );
// Imagens de loaders do frontend
$config['loaders'] = array(
                                $config['tpl_img'] . 'loaders/1.gif',
                                $config['tpl_img'] . 'loaders/1s.gif',
                                $config['tpl_img'] . 'loaders/2.gif',
                                $config['tpl_img'] . 'loaders/2s.gif',
                                $config['tpl_img'] . 'loaders/3.gif',
                                $config['tpl_img'] . 'loaders/3s.gif',
                                $config['tpl_img'] . 'loaders/4.gif',
                                $config['tpl_img'] . 'loaders/4s.gif',
                                $config['tpl_img'] . 'loaders/5.gif',
                                $config['tpl_img'] . 'loaders/5s.gif',
                                $config['tpl_img'] . 'loaders/6.gif',
                                $config['tpl_img'] . 'loaders/6s.gif',
                                $config['tpl_img'] . 'loaders/7.gif',
                                $config['tpl_img'] . 'loaders/7s.gif',
                                $config['tpl_img'] . 'loaders/8.gif',
                                $config['tpl_img'] . 'loaders/8s.gif',
                                $config['tpl_img'] . 'loaders/9.gif',
                                $config['tpl_img'] . 'loaders/9s.gif',
                                $config['tpl_img'] . 'loaders/10.gif',
                                $config['tpl_img'] . 'loaders/10s.gif',
                        );

/*
|--------------------------------------------------------------------------
| Configuracoes do template do ws
|--------------------------------------------------------------------------
|
| Contem urls de conteudos especificos do template do ws
|
*/

$config['tpl_index_default']  = '../../templates/ws/index.php';
$config['tpl_pasta']          = 'templates/ws/';
$config['tpl_ws']             = '../../' . $config['tpl_pasta'];

/* End of file template.php */
/* Location: ./application/config/template.php */
