<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo _lang('form_voce_esta_no_nivel');?></div>
                    <div class="panel-body">
                        <span class="bar" data-nivel="<?php echo $competidor->nivel_id; ?>">1,2,3,4,5,6,7</span> <?php echo $competidor->nivel_id; ?>
                    </div>
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo _lang('form_acertos_por_linguagem');?></div>
                    <div class="panel-body">
                        <div id="grafico_submissoes_competidor_por_linguagem" style="width: 100%;"></div>
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
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo _lang('form_acertos_por_categoria');?></div>
                    <div class="panel-body">
                        <div id="grafico_submissoes_competidor_por_categoria" style="width: 100%;"></div>
                    </div>
                  </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo _lang('form_qtd_acertos');?></div>
                    <div class="panel-body">
                        <div id="grafico_qtd_submissoes" style="width: 100%;"></div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
