<?php  if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * View exibida quando usuario tenta acessar algo que nao tem permissao de acesso
 * 
 * @package   views
 * @name      acesso_negado
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     13/07/2013
 */

 if (isset($msg)) {
     
     $msg = _lang($msg);
 }
 else {
     
     $msg = _lang('msg_acesso_negado');
 }

?>
<!-- Error wrapper -->
<div class="box_a">
    <div class="box_a_heading">
       
    </div>
    <div class="box_a_content cnt_a">
        <div>
            <h2><?php echo _lang('msg_acesso_negado_titulo'); ?></h2>
            <div class="media-body">
                <p><?php echo $msg; ?></p>
            </div>
        </div>
    </div>
</div>
<!-- /error wrapper -->