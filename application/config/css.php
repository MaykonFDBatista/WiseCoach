<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Config das classes css para facilitar a condificacao
 * 
 * @package   application/config
 * @name      css
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     08/08/2013
 * 
 */

// ATENCAO! Nao altere a ordem
$config['css_labels'] = array(
    'label',
    'label label-success',
    'label label-warning',
    'label label-important',
    'label label-info',
    'label label-inverse');


$config['css_status_ocorrencia'] = array(
    $config['css_labels'][2],
    $config['css_labels'][4],
    $config['css_labels'][1]
    );

$config['calendar-color'] = array(
    
    'reuniao' => '#dc6868',
    'mudanca' => '#75c386',
    'reserva' => '#6fbbd4'
);