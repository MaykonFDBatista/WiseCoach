<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Conteudo do formulario de edicao de categoria
 * 
 * @package   views/content/forms
 * @name      categoria_editar
 * @author    Alex Santini <alex.santini@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     18/09/2013
 */

echo form_hidden('cat_id', (isset($categorias->id) ? $categorias->id : ''));
?>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="cat_nome" class="req"><?php echo _lang('form_nome'); ?>&nbsp;</label>
            <input type="text" name="cat_nome" placeholder="<?php echo _lang('form_nome'); ?>" value="<?php echo ((isset($categorias->nome)) ? $categorias->nome : '') ?>" class="span8"  />
        </div>
    </div>
</div>