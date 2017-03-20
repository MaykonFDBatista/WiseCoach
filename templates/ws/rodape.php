<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-footer col-md-3 col-xs-6">
                <h3><?php echo _lang('menu_recomendar_problema');?></h3>
                <div class="portfolio-item">
                    <div class="portfolio-image">
                        
                            <?php
                            $imagem_recomendar = _verifica_extensao($this->config->item('url_arquivos_ws') . 'recomendar2');
                            if($imagem_recomendar){
                            ?>
                                <a href="<?php echo base_url($this->config->item('ws') . 'recomendacao');?>"><img src="<?php echo base_url($imagem_recomendar);?>" alt="<?php echo _lang('form_recomendar');?>"></a>
                            <?php
                            }
                            else{
                            ?>
                                <a href="<?php echo base_url($this->config->item('ws') . 'recomendacao');?>"><img src="http://placehold.it/247x148&amp;text=Recomendar" alt="<?php echo _lang('form_recomendar');?>"></a>
                            <?php
                            }
                            ?>
                        
                    </div>
                </div>
            </div>
            <div class="col-footer col-md-3 col-xs-6">
                <h3><?php echo _lang('menu_navegar'); ?></h3>
                <ul class="no-list-style footer-navigate-section">
                    <li><a href="<?php echo base_url($this->config->item('ws'));?>"><?php echo _lang('menu_home');?></a></li>
                    <li><a href="<?php echo base_url($this->config->item('ws').'problema');?>"><?php echo _lang('menu_problemas');?></a></li>
                    <li><a href="<?php echo base_url($this->config->item('ws').'recomendacao');?>"><?php echo _lang('menu_recomendacoes');?></a></li>
                    <li><a href="<?php echo base_url($this->config->item('ws').'submissao');?>"><?php echo _lang('menu_submissoes');?></a></li>
                    <li><a href="<?php echo base_url($this->config->item('ws').'rank');?>"><?php echo _lang('menu_rank');?></a></li>
                    <li><a href="http://labsoft.muz.ifsuldeminas.edu.br/index.php/contato" target="_blank"><?php echo _lang('menu_contato');?></a></li>
                </ul>
            </div>

            <div class="col-footer col-md-4 col-xs-6">
                <h3><?php echo _lang('menu_contato')?></h3>
                <p class="contact-us-details">
                    <?php 
                    echo (!empty($website->endereco)) ? $website->endereco . br() : '';
                    echo (!empty($website->telefone)) ? $website->telefone . br() : '';
                    echo (!empty($website->email)) ? '<a href="mailto:' . $website->email . '">' . $website->email . '</a>' : ''; 
                    ?>
                </p>
            </div>
            <div class="col-footer col-md-2 col-xs-6">
                <?php 
                echo heading(_lang('menu_redes_sociais'), 3);
                $list = array();
                if(!empty($website->facebook)) {
                    $list[] = anchor('https://www.facebook.com/' . $website->facebook, '', 'target="_black" class="facebook"');
                }
                if(!empty($website->twitter)) {
                    $list[] = anchor('https://www.twitter.com/' . $website->twitter, '', 'target="_black" class="twitter"');
                }
                if(!empty($website->google_plus)) {
                    $list[] = anchor('https://plus.google.com/+' . $website->google_plus, '', 'target="_black" class="googleplus"');
                }
                echo ul($list, 'class="footer-stay-connected no-list-style"');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="footer-copyright">&copy; <?php echo date('Y') . ' ' . $this->config->item('sis_nome') . '. ' . _lang('msg_copyright') . '.';?></div>
            </div>
        </div>
    </div>
</div>
