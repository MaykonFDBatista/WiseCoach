<?php

/**
 * Campos do formulario de login
 * 
 * @package   views/content
 * @name      nenhum_registro
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br> 
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     18/09/2013
 */
?>
<div class="control-group">
    <label for="email"><?php echo _lang('form_email');?>:</label>
    <div class="controls">
        <?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'span12', 'value' => set_value('email')));?>
    </div>
</div>
<div class="control-group">
    <label for="senha"><?php echo _lang('form_senha');?>:</label>
    <div class="controls">
        <?php echo form_password(array('name' => 'senha', 'id' => 'senha', 'class' => 'span12')); ?>
    </div>
</div>
<?php
// Se a controladora enviou o captcha ele e exibido
if (isset($recaptcha_html)) {

    echo $recaptcha_html;
}