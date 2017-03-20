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
                <h1><?php echo _lang('menu_recomendacoes'); ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <!-- Open Vacancies List -->
            <div class="col-sm-offset-2 col-sm-8">

                <div class="blog-post blog-single-post">
                    <h4 style="color: #4f8db3;"><b>Filtragem Baseada em Conteúdo</b></h4>
                    <table class="jobs-list">
                        <tr>
                            <th><?php echo _lang('form_id'); ?></th>
                            <th><?php echo _lang('form_nome'); ?></th>
                            <th><?php echo _lang('form_categoria'); ?></th>
                            <th><?php echo _lang('form_nivel'); ?></th>
                        </tr>
                        <?php
                        foreach ($problemas as $problema) {
                            ?>
                            <tr>
                             <!-- Id -->
                                <td class="job-type hidden-phone"><?php echo $problema->id; ?></td>
                                <!-- Nome -->
                                <td class="job-position">
                                    <a href="<?php echo base_url($this->config->item('ws')) . '/problema/visualizar/' . $problema->id; ?>"><?php echo $problema->nome; ?></a>
                                </td>
                                <!-- Categoria -->
                                <td class="job-location">
                                    <div class="job-country"><?php echo $problema->categoria; ?></div>
                                </td>
                                <!-- Nível -->
                                <td class="job-type hidden-phone">
                                    <span class="bar" data-nivel="<?php echo $problema->nivel_id; ?>">1,2,3,4,5,6,7</span> <?php echo $problema->nivel_id; ?>
                                </td>
                                
                            </tr>
                            <?php
                        }
                        ?>

                    </table>
                </div>
            </div>
        </div>   
        
        <div class="row">
            <!-- Open Vacancies List -->
            <div class="col-sm-offset-2 col-sm-8">

                <div class="blog-post blog-single-post">
                    <h4 style="color: #4f8db3;"><b>Usuários Similares</b></h4>
                    <table class="jobs-list">
                        <tr>
                            <th><?php echo _lang('form_id'); ?></th>
                            <th><?php echo _lang('form_nome'); ?></th>
                            <th><?php echo _lang('form_nivel'); ?></th>
                        </tr>
                        <?php
                        foreach ($competidores as $competidor) {
                            ?>
                            <tr>
                                <!-- Id -->
                                <td class="job-type hidden-phone"><?php echo $competidor->id; ?></td>
                                <!-- Nome -->
                                <td class="job-position">
                                    <a href="<?php echo base_url($this->config->item('ws')) . '/competidor/visualizar/' . $competidor->id; ?>"><?php echo $competidor->nome; ?></a>
                                </td>
                                <!-- Nível -->
                                <td class="job-type hidden-phone">
                                    <span class="bar" data-nivel="<?php echo $competidor->nivel_id; ?>">1,2,3,4,5,6,7</span> <?php echo $competidor->nivel_id; ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                    </table>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Open Vacancies List -->
            <div class="col-sm-offset-2 col-sm-8">

                <div class="blog-post blog-single-post">
                    <h4 style="color: #4f8db3;"><b>Filtragem Colaborativa</b></h4>
                    <table class="jobs-list">
                        <tr>
                            <th><?php echo _lang('form_id'); ?></th>
                            <th><?php echo _lang('form_nome'); ?></th>
                            <th><?php echo _lang('form_categoria'); ?></th>
                            <th><?php echo _lang('form_nivel'); ?></th>
                        </tr>
                        <?php
                        foreach ($problemas2 as $problema) {
                            ?>
                            <tr>
                             <!-- Id -->
                                <td class="job-type hidden-phone"><?php echo $problema->id; ?></td>
                                <!-- Nome -->
                                <td class="job-position">
                                    <a href="<?php echo base_url($this->config->item('ws')) . '/problema/visualizar/' . $problema->id; ?>"><?php echo $problema->nome; ?></a>
                                </td>
                                <!-- Categoria -->
                                <td class="job-location">
                                    <div class="job-country"><?php echo $problema->categoria; ?></div>
                                </td>
                                <!-- Nível -->
                                <td class="job-type hidden-phone">
                                    <span class="bar" data-nivel="<?php echo $problema->nivel_id; ?>">1,2,3,4,5,6,7</span> <?php echo $problema->nivel_id; ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>