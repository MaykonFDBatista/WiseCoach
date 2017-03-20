<?php
?>
<ul class="ca-menu list-group">
    <li class="list-group-item">
        <a href="<?php echo base_url($this->config->item('ws')) . '/problema/visualizar/'.$problema->id ;?>">
            <div class="row">
                <div class="col-sm-4">
                    <span class="ca-icon"><i class="glyphicon glyphicon-heart"></i></span>
                </div>
                <div class="col-sm-8">
                    <div class="ca-content">
                        <p class="ca-main"><?php echo _lang('form_problema') . ' ' .  $problema->id; ?></p>
                        <p class="ca-sub text-muted"><?php echo $problema->nome;?></p>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="list-group-item">
        <a href="<?php echo base_url($this->config->item('ws')) . '/problema/submeter/'.$problema->id ;?>">
            <div class="row">
                <div class="col-sm-4">
                    <span class="ca-icon"><i class="glyphicon glyphicon-share-alt"></i></span>
                </div>
                <div class="col-sm-8">
                    <div class="ca-content">
                        <p class="ca-main"><?php echo _lang('form_submeter'); ?></p>
                        <p class="ca-sub text-muted"><?php echo _lang('form_solucao');?></p>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="list-group-item">
        <a href="<?php echo base_url($this->config->item('ws')) . '/problema/visualizar_estatisticas/'.$problema->id ;?>">
            <div class="row">
                <div class="col-sm-4">
                    <span class="ca-icon"><i class="glyphicon glyphicon-signal"></i></span>
                </div>
                <div class="col-sm-8">
                    <div class="ca-content">
                        <p class="ca-main"><?php echo _lang('form_estatisticas'); ?></p>
                        <p class="ca-sub text-muted"><?php echo $problema->qtd_submissoes . ' ' . _lang('form_submissoes');?></p>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="list-group-item">
        <a href="<?php echo base_url($this->config->item('ws')) . '/problema/visualizar_objetos_aprendizagem/'.$problema->id ;?>">
            <div class="row">
                <div class="col-sm-4">
                    <span class="ca-icon"><i class="glyphicon glyphicon-hdd"></i></span>
                </div>
                <div class="col-sm-8">
                    <div class="ca-content">
                        <p class="ca-main"><?php echo _lang('form_objetos_aprendizagem'); ?></p>
                        <p class="ca-sub text-muted"><?php echo _lang('form_repositorio')?></p>
                    </div>
                </div>
            </div>
        </a>
    </li>
    <li class="list-group-item">
        <a href="<?php echo base_url($this->config->item('ws')) . '/recomendacao'; ?>">
            <div class="row">
                <div class="col-sm-4">
                    <span class="ca-icon"><i class="glyphicon glyphicon-thumbs-up"></i></span>
                </div>
                 <div class="col-sm-8">
                    <div class="ca-content">
                        <p class="ca-main"><?php echo _lang('form_recomendar'); ?></p>
                        <p class="ca-sub text-muted"><?php echo _lang('form_problema'); ?></p>
                    </div>
                </div>
            </div>
        </a>
    </li>
</ul>

