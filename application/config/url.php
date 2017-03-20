<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 | 
 | Configuracoes de URL do sistema
 | @package Config
 |  
 | @author Tellks - Solucoes em tecnologia, Ltda <tellks.com.br>
 | @copyright Copyright (c) 2012, Tellks, Ltda.
 | @link http://tellks.com.br
*/

$config['fn_default'] = 'sistema';

/*
|--------------------------------------------------------------------------
| Login da aplicacao
|--------------------------------------------------------------------------
|
| Controller de login
|
*/

$config['login'] = 'login';

/*
|--------------------------------------------------------------------------
| Logout da aplicacao
|--------------------------------------------------------------------------
|
| Controller de logout
|
*/

$config['logout'] = 'logout';

/*
|--------------------------------------------------------------------------
| Urls dos diretorios dos arquivos dos usuarios da aplicacao
|--------------------------------------------------------------------------
*/

// Raiz
$config['url_arquivos']         = 'assets/arquivos/';

// Arquivos dos usuarios frontend
$config['url_arquivos_default'] = $config['url_arquivos'] . 'default/';
$config['url_imagens']          = 'img/';
$config['url_usuarios']         = 'usuarios/';
$config['url_documentos']       = 'documentos/';
$config['url_produtos']         = 'produtos/';


// Arquivos dos usuarios backend
$config['url_arquivos_admin']                 = $config['url_arquivos'] . 'adm/';
$config['url_arquivos_admin_usuarios']        = $config['url_arquivos_admin'] . 'usuarios/';
$config['url_banners']                        = $config['url_arquivos_admin'] . 'banners/';
$config['url_problemas']                      = $config['url_arquivos_admin'] . 'problemas/';
$config['url_submissoes']                      = $config['url_arquivos_admin'] . 'submissoes/';

$config['url_arquivos_ws']                    = $config['url_arquivos'] . 'ws/';

$config['url_servidor'] = 'C:\xampp\htdocs';


