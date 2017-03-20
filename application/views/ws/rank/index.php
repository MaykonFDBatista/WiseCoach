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
?>

<!-- Page Title -->
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?php echo _lang('menu_rank'); ?></h1>
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
                    <table class="jobs-list tabela">
                        <tr>
                            <th><?php echo _lang('form_posicao'); ?></th>
                            <th><?php echo _lang('form_nome'); ?></th>
                            <th><?php echo _lang('form_resolvidos'); ?></th>
                            <th><?php echo _lang('form_erros'); ?></th>
                            <th><?php echo _lang('form_data_cadastro'); ?></th>
                        </tr>
                        <?php
                        $posicao = 1;
                        $posicao_anterior = 1;
                        $resolvidos_anterior = -1;
                        foreach ($competidores as $competidor) {
                            ?>
                            <tr <?php echo (($competidor->id == $this->session->userdata('id'))? 'class="linha-destaque"' : '')?>>
                                <!-- Posição -->
                                <td class="job-type hidden-phone">
                                    <?php
                                        echo $posicao;
                                        $posicao++;
                                    ?>
                                </td>
                                <!-- Nome -->
                                <td class="job-position tabela-esquerda">
                                    <a href="<?php echo base_url($this->config->item('ws')) . '/competidor/visualizar/' . $competidor->id; ?>"><?php echo $competidor->nome; ?></a>
                                </td>
                                <!-- Resolvidos -->
                                <td class="job-type hidden-phone">
                                    <?php echo $competidor->resolvidos; ?>
                                </td>
                                <!-- Erros -->
                                <td class="job-type hidden-phone">
                                    <?php echo $competidor->erros; ?>
                                </td>
                                <!-- Data de cadastro -->
                                <td class="job-type hidden-phone">
                                    <?php echo date('d/m/Y H:i:s', strtotime($competidor->data_registro)); ?>
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