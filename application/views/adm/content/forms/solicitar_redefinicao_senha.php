<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

/**
 * Campos do formulario de solicitacao de redefinicao de senha
 * 
 * @package   views/content
 * @name      solicitar_redefinicao_senha
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     03/10/2013
 */
?>
<div class="row-fluid">
    <p>
        <?php echo _lang('msg_solic_redefinicao_senha'); ?>
        <br>&nbsp;
    </p>
</div>
<div class="row-fluid">
    <label for="usu_email"><?php echo _lang('form_email'); ?>:&nbsp;</label>
    <input type="text" name="email" id="usu_email" value="" class="input span12">
</div>
<p id="resultado"></p>
<div class="span12" id="load" style="text-align: center; display: none;"><img src="<?php echo ($loader) ? base_url($loader) : ''; ?>"/></div>