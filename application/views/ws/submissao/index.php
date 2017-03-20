<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$respostas = $this->config->item('respostas');
$linguagens = $this->config->item('linguagens');
$cores = $this->config->item('cores');

?>

<!-- Page Title -->
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?php echo _lang('menu_submissoes'); ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <!-- Open Vacancies List -->
            <div class="col-sm-offset-1 col-sm-10">
                
                <?php
                if ($this->session->flashdata('msg') != "") {
    
                    switch ($this->session->flashdata('msg')) {

                        case 'msg_submissao-ok': {
                                $tp = 'alert alert-success';
                            } break;
                        case 'msg_vazio': {
                                $tp = 'alert alert-danger';
                            } break;
                        case 'msg_error': {
                                $tp = 'alert alert-danger';
                            } break;
                        default: {
                                $tp = 'alert alert-warning';
                            } break;
                    }
                    echo '<div class="' . $tp . '">' . _lang($this->session->flashdata('msg')) . "<button type='button' class='close' data-dismiss='alert'>×</button> </div>";
                }
                ?>

                <div class="blog-post blog-single-post">
                    <table class="jobs-list">
                        <tr>
                            <th><?php echo _lang('form_id'); ?></th>
                            <th><?php echo _lang('form_problema'); ?></th>
                            <th><?php echo _lang('form_linguagem'); ?></th>
                            <th><?php echo _lang('form_resposta'); ?></th>
                            <th><?php echo _lang('form_tempo'); ?></th>
                            <th><?php echo _lang('form_data'); ?></th>
                        </tr>
                        <?php
                        foreach ($submissoes as $submissao) {
                            ?>
                            <tr>
                                <!-- Id -->
                                <td class="job-type hidden-phone">
                                    <?php echo $submissao->id; ?>
                                </td>
                                <!-- Problema -->
                                <td class="job-position">
                                    <a href="<?php echo base_url($this->config->item('ws')) . '/problema/visualizar/' . $submissao->problema_id; ?>"><?php echo $submissao->problema; ?></a>
                                </td>
                                <!-- Linguagem -->
                                <td class="job-location">
                                    <div class="job-country"><?php echo _lang($linguagens[$submissao->linguagem]); ?></div>
                                </td>
                                <!-- Resposta -->
                                <td class="job-location">
                                    <div class="job-country <?php echo $cores[$submissao->resposta];?>"><?php echo _lang($respostas[$submissao->resposta]); ?></div>
                                </td>
                                <!-- Tempo -->
                                <td class="job-type hidden-phone">
                                    <?php 
                                    if($submissao->tempo == -1){
                                        $submissao->tempo = "Loop";
                                    }
                                    echo $submissao->tempo;
                                    ?>
                                </td>
                                <!-- Data -->
                                <td class="job-type hidden-phone">
                                    <?php echo date('d/m/Y H:i:s', strtotime($submissao->data_registro)); ?>
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