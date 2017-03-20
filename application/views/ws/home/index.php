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
                <h1><?php echo _lang('menu_home'); ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <!-- Open Vacancies List -->
            
                        <?php
                        foreach ($categorias as $i => $categoria) {
                            ?>
                            <div class="<?php echo (($i%2 == 0) ? 'col-sm-offset-2' : '');?> col-sm-4">
                                <div class="blog-post blog-single-post">
                                    <h4><a href="<?php echo base_url($this->config->item('ws')) . '/problema/categoria/' . $categoria->id; ?>"><?php echo '<i class="glyphicon glyphicon-star-empty"></i> ' . $categoria->nome; ?></a></h4>
                                    <?php echo $categoria->qtd_problemas . ' problema(s)';?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
               

        </div>
    </div>
</div>