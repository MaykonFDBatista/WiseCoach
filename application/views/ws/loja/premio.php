<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!-- Page Title -->
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <?php echo _lang('menu_loja'); ?>
                    &rsaquo;
                    <?php echo _lang('menu_premio'); ?>
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-10">
                <?php
                    echo '<div class="alert alert-warning"><strong>' . _lang('form_atencao') . '!</strong> ' . _lang('form_este_conteudo_nao_estara_mais_disponivel_ao_sair_desta_pagina') . "<button type='button' class='close' data-dismiss='alert'>×</button> </div>";
                ?>
                <div class="basic-login">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php 
                            if(isset($regra) && isset($problema)) {
                                echo '<div class="problema-cabecalho">' . heading($problema->nome,1) . '</div>';
                                if($regra->id == 1){
                                    echo heading(_lang('form_entrada'),3);
                                    echo '<pre>' . $entrada_problema . '</pre>';
                                }
                                else if($regra->id == 2){
                                    echo heading(_lang('form_dicas'),3);
                                    echo $problema->dicas;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>