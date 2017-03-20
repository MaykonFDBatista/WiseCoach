<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Monta o Menu
 * 
 * @package   templates/tellknologia
 * @name      menu
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     19/06/2013
 * 
 */
?>
<aside id="menu">
    <div class="accordion" id="side_menu">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle"href="<?php echo base_url($this->config->item('admin'));?>">
                    <i class="elusive-icon-home"></i>
                    <?php echo _lang('menu_inicio');?>
                </a>
            </div>
        </div>
    <?php 
    foreach ($menu['menu'] as $m) {
    ?>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#side_menu" href="#m_<?php echo $m->nome;?>">
                    <i class="elusive-icon-tasks"></i>
                    <?php echo _lang($m->nome);?>
                </a>
            </div>
            <div id="m_<?php echo $m->nome;?>" class="accordion-body collapse">
                <div class="accordion-inner">
                    <ul>
                        <?php
                        foreach ($menu['item_menu'] as $funcionalidade) {

                            if (!empty($funcionalidade)) {

                                foreach ($funcionalidade as $f) {
                                    
                                    if ($m->id == $f->modulo_id) {
                                        
                                        
                                        if ((isset($fun_corrente) && $fun_corrente == $f->id) || ($titulo == $f->nome)) {
                                            
                                            echo '<li class="current">';
                                        } else {
                                            
                                            echo '<li>';
                                        }
                                        echo anchor($this->config->item('admin') . $f->url, _lang($f->nome));
                                        echo '</li>' . lnbreak();
                                    }
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        
    <?php
    }
    ?>
    </div>
</aside>
