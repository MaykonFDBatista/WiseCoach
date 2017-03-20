<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['respostas'] = array('0' => 'form_not_answered_yet',
                             '1' => 'form_accepted',
                             '2' => 'form_compilation_error',
                             '3' => 'form_runtime_error',
                             '4' => 'form_time_limit_exceeded',
                             '5' => 'form_presentation_error',
                             '6' => 'form_wrong_answer');

$config['resposta_aceita'] = '1';

$config['cores'] = array('0' => 'cinza',
                         '1' => 'verde',
                         '2' => 'roxo',
                         '3' => 'laranja',
                         '4' => 'azul',
                         '5' => 'amarelo',
                         '6' => 'vermelho');

$config['linguagens'] = array('1' => 'form_c',
                              '2' => 'form_cpp',
                              '3' => 'form_java',
                              '4' => 'form_pascal',
                              '5' => 'form_python');

$config['extensoes'] = array('1' => 'c',
                             '2' => 'cpp',
                             '3' => 'java',
                             '4' => 'pas',
                             '5' => 'py');

$config['extensoes_compilado'] = array('1' => '.exe',
                                       '2' => '.exe',
                                       '3' => '',
                                       '4' => '.exe',
                                       '5' => '');

$config['highlighters'] = array('1' => 'c_cpp',
                                '2' => 'c_cpp',
                                '3' => 'java',
                                '4' => 'pascal',
                                '5' => 'python');

