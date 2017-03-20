<?php

if (!defined('BASEPATH'))
    exit('Sem permissao de acesso direto ao Script.');
/**
 * 
 * @package  templates/tellknologia
 * @name      breadcrumbs
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     03/06/2013
 * 
 */
?>
<ul> 
    <li><a href="<?php echo base_url($this->config->item('admin')) ?>"><?php echo _lang('menu_inicio'); ?></a></li>
    <li class="crumb_sep"><i class="elusive-icon-play"></i></li>
    <?php
    $f_nome = $titulo;
    $f_url = '';
    foreach ($menu['menu'] as $m) {

        foreach ($menu['item_menu'] as $funcionalidade) {

            if (!empty($funcionalidade)) {

                foreach ($funcionalidade as $f) {
                    if (isset($fun_corrente)) {

                        if (($m->id == $f->modulo_id) && ($f->id == $fun_corrente)) {
                            
                            $f_id = $fun_corrente;
                            $modulo_pai = $m->nome;
                            $f_nome = $f->nome;
                            $f_url = $f->url;
                            break;
                        }
                    } else {

                        if (($m->id == $f->modulo_id) && ($f->nome == $titulo)) {

                            $modulo_pai = $m->nome;
                            $f_nome = $f->nome;
                            $f_url = $f->url;
                            break;
                        }
                    }
                }
            }
        }
    }

    if (isset($modulo_pai)) {

        echo '<li>';
        echo '<a href="#">' . _lang($modulo_pai) . '</a>';
        echo '</li>';
        echo '<li class="crumb_sep"><i class="elusive-icon-play"></i></li>' . lnbreak();
    }
    if (isset($f_id) && ($f_id == $fun_corrente) && ($titulo != $f_nome)) {

        echo '<li>';
        echo anchor($this->config->item('admin') . $f_url, _lang($f_nome));
        echo '</li>';
        echo '<li class="crumb_sep"><i class="elusive-icon-play"></i></li>' . lnbreak();

        echo '<li>';
        echo '<span>' . _lang($titulo) . '</span>';
        echo '</li>' . lnbreak();
    } else {

        echo '<li>';
        echo '<span>' . _lang($f_nome) . '</span>';
        echo '</li>' . lnbreak();
    }
    ?>
</ul>                                   