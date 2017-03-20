<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Exibe o filtro na aba lateral destinada ao filtro
 * 
 * @package   templates/tellknologia
 * @name      filtro
 * @author    Joao Claudio Dias Araujo joao.araujo@tellks.com.br
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     19/06/2013
 * 
 */
?>
<aside id="jpanel_side" class="jpanel_sidebar hidden-print">
    <div class="jpanel_inner">
        <span class="close jpanel_close">×</span>
        <div id="conteudo_jpanel">
            <?php echo (isset($filtro['formulario']))? $filtro['formulario']: '';?>
        </div>
    </div>
</aside>