<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$linguagens = $this->config->item('linguagens');

echo form_hidden('problema_id', $problema->id);
?>
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <?php
                    echo _lang('menu_problemas');
                    echo nbs() . '&rsaquo;' . nbs();
                    echo anchor(base_url($this->config->item('ws') . 'problema/visualizar/' . $problema->id), $problema->nome, '');
                    echo nbs() . '&rsaquo;' . nbs();
                    echo _lang('form_estatisticas');
                    ?>
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
                        <?php echo $this->load->view($this->config->item('ws') . 'problema/submenu'); ?>
                    </div>
                    <div class="col-sm-9">
                        <div class="blog-post blog-single-post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><?php echo _lang('form_submissoes_por_linguagem');?></div>
                                        <div class="panel-body">
                                            <div id="grafico_barras" style="width: 100%;"></div>
                                        </div>
                                      </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><?php echo _lang('form_submissoes_por_resposta');?></div>
                                        <div class="panel-body">
                                            <div id="chart" style="width:100%;">
                                            </div>
                                            <div id="clickerWrapper">
                                                <div id="progress"></div>
                                            </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="row">
                            <?php
                            if (isset($submissoes)) {
                                echo heading(_lang('form_top_20'), 3);
                                ?>

                                <table class="jobs-list">
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo _lang('form_id'); ?></th>
                                        <th><?php echo _lang('form_competidor'); ?></th>
                                        <th><?php echo _lang('form_linguagem'); ?></th>
                                        <th><?php echo _lang('form_tempo'); ?></th>
                                        <th><?php echo _lang('form_data'); ?></th>
                                    </tr>
                                    <?php
                                    foreach ($submissoes as $i => $submissao) {
                                        ?>
                                        <tr>
                                            <!-- Resposta -->
                                            <td class="job-location">
                                                <div><?php echo ($i+1); ?></div>
                                            </td>
                                            <!-- Id -->
                                            <td class="job-type hidden-phone">
                                                <?php echo $submissao->id; ?>
                                            </td>
                                            <!-- Competidor -->
                                            <td class="job-position">
                                                <?php echo $submissao->competidor; ?>
                                            </td>
                                            <!-- Linguagem -->
                                            <td class="job-location">
                                                <div class="job-country"><?php echo _lang($linguagens[$submissao->linguagem]); ?></div>
                                            </td>
                                            <!-- Tempo -->
                                            <td class="job-type hidden-phone">
                                                <?php
                                                if ($submissao->tempo == -1) {
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
                            <?php }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>