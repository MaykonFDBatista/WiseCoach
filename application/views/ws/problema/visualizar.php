<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <?php echo _lang('menu_problemas'); ?>
                    &rsaquo;
                    <?php echo $problema->nome; ?>
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-10">
                <div class="row">
                    <div class="col-sm-3">
                        <?php echo $this->load->view($this->config->item('ws') . 'problema/submenu');?>
                    </div>
                    <div class="col-sm-9">

                        <div class="blog-post blog-single-post">	

                            <?php
                            if($problema->nome != ''){
                            ?>
                            <div class="problema-cabecalho">
                                <h1><?php echo $problema->nome; ?></h1>
                                <?php
                                if($problema->timelimit != ''){
                                ?>
                                <strong><?php echo _lang('form_timelimit'). ':&nbsp;' . $problema->timelimit; ?></strong>
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            }
                            ?>
                            <div class="problema">
                                <?php
                                if($problema->descricao != ''){
                                    echo $problema->descricao;
                                }
                                if($problema->entrada != ''){
                                    echo '<h2>' . _lang('form_entrada') . '</h2>'; 
                                    echo $problema->entrada; 
                                }
                                if($problema->saida != ''){
                                    echo '<h2>' . _lang('form_saida') . '</h2>'; 
                                    echo $problema->saida; 
                                }
                                if($problema->restricoes != ''){
                                    echo '<h2>' . _lang('form_restricoes') . '</h2>'; 
                                    echo $problema->restricoes; 
                                }
                                ?>
                                <?php
                               if($problema->exemplo_entrada != '' || $problema->exemplo_saida != ''){
                                ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <td><?php echo _lang('form_exemplo_entrada');?></td>
                                            <td><?php echo _lang('form_exemplo_saida');?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="divisao">
                                                <?php
                                                if($problema->exemplo_entrada != ''){
                                                    echo $problema->exemplo_entrada; 
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($problema->exemplo_entrada != ''){
                                                    echo $problema->exemplo_saida; 
                                                }
                                                ?>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                }
                                ?>
                            </div>
                            <div style="text-align: center;">
                                <a href="<?php echo base_url($this->config->item('ws')) . '/problema/submeter/'.$problema->id ;?>"><button type="button" class="btn"><?php echo _lang('form_submeter'); ?></button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>