<?php 

echo form_open(base_url($this->config->item('ws') . 'ajax/identifica_estilo_aprendizagem'),array('id' => 'form_estilo_aprendizagem'));

$form_ja_respondido = ((is_array($competidor_estilos)) && (sizeof($competidor_estilos) > 0));

?>
<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="<?php echo (($form_ja_respondido) ? 'disabled' : 'active'); ?>">
                <a href="#form-estilo-1" aria-controls="form-estilo-1" role="tab" data-toggle="tab"><?php echo _lang('form_estilo_passo_1'); ?></a>
            </li>
            <li role="presentation" class="disabled">
                <a href="#form-estilo-2" aria-controls="form-estilo-2"><?php echo _lang('form_estilo_passo_2'); ?></a>
            </li>
            <li role="presentation" class="disabled">
                <a href="#form-estilo-3" aria-controls="form-estilo-3"><?php echo _lang('form_estilo_passo_3'); ?></a>             
            </li>
            <li role="presentation" class="disabled">
               <a href="#form-estilo-4" aria-controls="form-estilo-4"><?php echo _lang('form_estilo_passo_4'); ?></a>           
            </li>
            <li role="presentation" class="<?php echo (($form_ja_respondido) ? 'active' : 'disabled'); ?>">
                <a href="#form-estilo-5" aria-controls="form-estilo-5" role="tab" data-toggle="tab"><?php echo _lang('form_estilo_passo_5'); ?></a>               
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane <?php echo (($form_ja_respondido) ? '' : 'active'); ?>" id="form-estilo-1">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <?php 
                        for($i=1;$i<12;$i++) {
                            
                            $radio_a = form_radio( array('name' => 'form_estilo_aprendizagem_questao_' . $i,
                                    'value' => $this->config->item('form_estilo_aprendizagem_questao_' . $i . '_alternativa_a'),
                                    'class' => 'icheck radio_estilo',
                                    'data-icheck-color' => 'blue'));
                            
                            $radio_b = form_radio( array('name' => 'form_estilo_aprendizagem_questao_' . $i,
                                'value' => $this->config->item('form_estilo_aprendizagem_questao_' . $i . '_alternativa_b'),
                                'class' => 'icheck radio_estilo',
                                'data-icheck-color' => 'blue'));
                            
                            echo '<div class="checkbox">';
                            echo '<p>' . $i . '. ' . _lang('form_estilo_aprendizagem_questao_' . $i) . '</p>';
                            echo form_label($radio_a . ' ' . _lang('form_estilo_aprendizagem_questao_' . $i . '_alternativa_a')) . br();
                            echo form_label($radio_b . ' ' . _lang('form_estilo_aprendizagem_questao_' . $i . '_alternativa_b')) . br();
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <div class="panel-footer">
                        <a href="#form-estilo-2" aria-controls="form-estilo-2" class="btn  btn-primary btn-tab"><?php echo _lang('form_proximo') . ' &raquo;'; ?></a>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="form-estilo-2">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <?php 
                        for($i=12;$i<23;$i++) {
                            
                            $radio_a = form_radio( array('name' => 'form_estilo_aprendizagem_questao_' . $i,
                                    'value' => $this->config->item('form_estilo_aprendizagem_questao_' . $i . '_alternativa_a'),
                                    'class' => 'icheck',
                                    'data-icheck-color' => 'green'));
                            
                            $radio_b = form_radio( array('name' => 'form_estilo_aprendizagem_questao_' . $i,
                                'value' => $this->config->item('form_estilo_aprendizagem_questao_' . $i . '_alternativa_b'),
                                'class' => 'icheck',
                                'data-icheck-color' => 'green'));
                            
                            echo '<div class="checkbox">';
                            echo '<p>' . $i . '. ' . _lang('form_estilo_aprendizagem_questao_' . $i) . '</p>';
                            echo form_label($radio_a . ' ' . _lang('form_estilo_aprendizagem_questao_' . $i . '_alternativa_a')) . br();
                            echo form_label($radio_b . ' ' . _lang('form_estilo_aprendizagem_questao_' . $i . '_alternativa_b')) . br();
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <div class="panel-footer">
                        <a href="#form-estilo-1" aria-controls="form-estilo-1" class="btn  btn-primary btn-tab"><?php echo '&laquo; ' . _lang('form_anterior'); ?></a>
                        <a href="#form-estilo-3" aria-controls="form-estilo-3" class="btn  btn-primary btn-tab"><?php echo _lang('form_proximo') . ' &raquo;'; ?></a>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="form-estilo-3">
                <div class="panel panel-danger">
                    <div class="panel-body">
                        <?php 
                        for($i=23;$i<34;$i++) {
                            
                            $radio_a = form_radio( array('name' => 'form_estilo_aprendizagem_questao_' . $i,
                                    'value' => $this->config->item('form_estilo_aprendizagem_questao_' . $i . '_alternativa_a'),
                                    'class' => 'icheck',
                                    'data-icheck-color' => 'red'));
                            
                            $radio_b = form_radio( array('name' => 'form_estilo_aprendizagem_questao_' . $i,
                                'value' => $this->config->item('form_estilo_aprendizagem_questao_' . $i . '_alternativa_b'),
                                'class' => 'icheck',
                                'data-icheck-color' => 'red'));
                            
                            echo '<div class="checkbox">';
                            echo '<p>' . $i . '. ' . _lang('form_estilo_aprendizagem_questao_' . $i) . '</p>';
                            echo form_label($radio_a . ' ' . _lang('form_estilo_aprendizagem_questao_' . $i . '_alternativa_a')) . br();
                            echo form_label($radio_b . ' ' . _lang('form_estilo_aprendizagem_questao_' . $i . '_alternativa_b')) . br();
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <div class="panel-footer">
                        <a href="#form-estilo-2" aria-controls="form-estilo-2" class="btn  btn-primary btn-tab"><?php echo '&laquo; ' . _lang('form_anterior'); ?></a>
                        <a href="#form-estilo-4" aria-controls="form-estilo-4" class="btn  btn-primary btn-tab"><?php echo _lang('form_proximo') . ' &raquo;'; ?></a>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="form-estilo-4">
                <div class="panel panel-warning">
                    <div class="panel-body">
                        <?php 
                        for($i=34;$i<45;$i++) {
                            
                            $radio_a = form_radio( array('name' => 'form_estilo_aprendizagem_questao_' . $i,
                                    'value' => $this->config->item('form_estilo_aprendizagem_questao_' . $i . '_alternativa_a'),
                                    'class' => 'icheck',
                                    'data-icheck-color' => 'orange'));
                            
                            $radio_b = form_radio( array('name' => 'form_estilo_aprendizagem_questao_' . $i,
                                'value' => $this->config->item('form_estilo_aprendizagem_questao_' . $i . '_alternativa_b'),
                                'class' => 'icheck',
                                'data-icheck-color' => 'orange'));
                            
                            echo '<div class="checkbox">';
                            echo '<p>' . $i . '. ' . _lang('form_estilo_aprendizagem_questao_' . $i) . '</p>';
                            echo form_label($radio_a . ' ' . _lang('form_estilo_aprendizagem_questao_' . $i . '_alternativa_a')) . br();
                            echo form_label($radio_b . ' ' . _lang('form_estilo_aprendizagem_questao_' . $i . '_alternativa_b')) . br();
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <div class="panel-footer">
                        <a href="#form-estilo-3" aria-controls="form-estilo-3" class="btn  btn-primary btn-tab"><?php echo '&laquo; ' . _lang('form_anterior'); ?></a>
                        <a href="#form-estilo-5" id="btn-concluir" aria-controls="form-estilo-5" class="btn btn-success btn-tab"><?php echo _lang('form_concluir'); ?></a>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane <?php echo (($form_ja_respondido) ? 'active' : ''); ?>" id="form-estilo-5">
                <div class="panel panel-info">
                    <div class="panel-body" id="panel-resultado">
                        <?php 
                        if($form_ja_respondido) {
                            
                            foreach($competidor_estilos as $estilo) {
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bs-callout bs-callout-info">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php 
                                            echo heading(_lang($estilo[0]->nome),'4');
                                            echo '<p>' . _lang($estilo[0]->descricao). '</p>';
                                            ?>
                                        </div>
                                        <div class="col-md-4" style="padding:0px;">
                                            <div class="row grafico-pontuacao" data-pontuacao="<?php echo ($estilo[0]->pontuacao/11);?>"></div>
                                            <div class="row">
                                                <p class="text-primary text-center"><?php echo $estilo[0]->pontuacao . ' ' . _lang('form_pontos');?></p>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bs-callout bs-callout-danger">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php 
                                            echo heading(_lang($estilo[1]->nome),'4');
                                            echo '<p>' . _lang($estilo[1]->descricao). '</p>';
                                            ?>
                                        </div>
                                        <div class="col-md-4" style="padding:0px;">
                                            <div class="row grafico-pontuacao" data-pontuacao="<?php echo ($estilo[1]->pontuacao/11);?>"></div>
                                            <div class="row">
                                                <p class="text-danger text-center"><?php echo $estilo[1]->pontuacao . ' ' . _lang('form_pontos');?></p>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php        
                            } 
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close();?>
