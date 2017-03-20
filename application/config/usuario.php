<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Super usuario do sistema
|--------------------------------------------------------------------------

*/

$config['super_users']    = 1;
$config['foto_default']   = 'user_default.png';
$config['status_usuario'] = array('1' => 'form_ativo',
                                  '2' => 'form_bloqueado',
                                  '0' => 'form_inativo');

// Campos obrigatorios na importacao de usuarios
$config['campos-obrigatorios'] = array(); 

// Grupo default em que sao inseridos os usuarios cadastrados atraves da
// importacao em massa
$config['grupo_default'] = 3;

// Status do usuario ao ser cadastrado atraves da importacao em massa
$config['status_usuario_default'] = 1;

$config['formas_acesso'] = array(
                                'adm' => 'form_administracao'
                            );
//$config['formas_acesso'] = array(
//                                'adm' => 'form_administracao',
//                                'app' => 'form_aplicacao'
//                            );