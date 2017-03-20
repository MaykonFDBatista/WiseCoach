<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Configuracoes do servidor
$config['smtp_host']   = 'adm.tellks.com.br';  
$config['protocol']    = 'smtp';
$config['smtp_port']   = '587';  
$config['smtp_timeout']= '30';  
$config['smtp_user']   = 'sistema';  
$config['smtp_pass']   = 'tellks#mail*';

$config['envio_assincrono'] = FALSE;

// Configuracoes da mensagem
$config['mailtype']    = 'html';
$config['newline']     ="\r\n"; 
$config['charset']     = 'utf-8';

//Tempo de espera ao enviar um email em milisegundos
$config['tp_espera'] = '150';

// Remetente
$config['email_from'] = array(
                             'email' => 'administracao@yellow.com.br',
                             'nome'  => 'Amigos do sonho'
);