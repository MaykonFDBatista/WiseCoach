<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Template do email de requisicao de redefinicao de senha
 * 
 * @package   views
 * @name      email_redefinir_senha
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     22/09/2013
 */

?>
<p><b><?php echo $this->config->item('sis_nome');?></b></p>
<p>
    <?php echo _lang('msg_presado') . '&nbsp;' . ((isset($usuario))? $usuario['usuario']:'')?>.
</p>
<p>
    <?php echo _lang('msg_texto_email'); ?>
</p>
<p>
    <?php echo (isset($msg))?$msg:''?>
</p>