<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Exibe o id, nome e cidade do condominio
 * 
 * @package   adm/condominio
 * @name      dados do condominio
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     19/07/2013
 * 
 */
?>
<div class="box_a">
    <div class="box_a_heading">
        <h3><?php echo _lang('msg_info_gerenciando'); ?>:</h3>
    </div>

    <div class="well-large">
        <div class="well-white">
            <p><strong><?php echo _lang('menu_app'); ?>:</strong>&nbsp;<?php echo ((isset($app->nome)) ? $app->nome : '') ?><b>&nbsp;&nbsp;&nbsp;<?php echo _lang('form_id'); ?>:</b>&nbsp;<?php echo ((isset($app->id)) ? $app->id : '') ?></p>
            <p><strong><?php echo _lang('form_cidade'); ?>:</strong>&nbsp;<?php echo ((isset($app->cidade)) ? $app->cidade . ' - ' . $app->uf : '') ?></p>
        </div>
    </div>
</div>
<br>