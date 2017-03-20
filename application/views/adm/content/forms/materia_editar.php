<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Conteudo do formulario de edicao de materia
 * 
 * @package   views/content/forms
 * @name      materia_editar
 * @author    Alex Santini <alex.santini@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     18/09/2013
 */

echo form_hidden('mat_id', (isset($materia->id) ? $materia->id : ''));
?>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="mat_nome" class="req"><?php echo _lang('form_nome'); ?>&nbsp;</label>
            <input type="text" name="mat_nome" placeholder="<?php echo _lang('form_nome'); ?>" value="<?php echo ((isset($materia->nome)) ? $materia->nome : '') ?>" class="span8"  />
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="mat_nome" class=""><?php echo _lang('form_submateria_de'); ?>&nbsp;</label>
            <?php 
            $materias = _dropdown_list($materias,'id','nome');
            echo form_dropdown('mat_submateria_de', $materias, ((isset($materia->submateria_de)) ? $materia->submateria_de : ''));
            ?>
        </div>
    </div>
</div>