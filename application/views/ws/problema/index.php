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
                <h1><?php echo _lang('menu_problemas'); ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <!-- Open Vacancies List -->
            <div class="col-sm-offset-1 col-sm-10">
                <div class="blog-post blog-single-post">
                    <table class="jobs-list">
                        <tr>
                            <th><?php echo _lang('form_id'); ?></th>
                            <th><?php echo _lang('form_resolvido'); ?></th>
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
                                <td class="job-type hidden-phone">
                                    <?php if((!empty($problema->resolvido)) && ($problema->resolvido > 0)):?>
                                      <div class="balloon">
                                        <div></div>
                                      </div>
                                    <?php endif; ?>
                                </td>
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