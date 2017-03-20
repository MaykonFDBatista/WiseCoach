<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View Index do modulo Sobre
 * Informações do sistema
 * 
 * @package   Views/adm/sobre
 * @name      Index
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     2013
 */

?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><?php echo $this->config->item('sis_nome'); ?></h6>
                </div>
            </div>
            <?php 
            $desenvolvedor = "http://tellks.com.br/identidade-visual/sobre/index.php";
            echo file_get_contents($desenvolvedor);
            ?>
        </div>
    </div>
</div>