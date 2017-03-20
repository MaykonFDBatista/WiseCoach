<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Conteudo do formulario de edicao de competidor
 * 
 * @package   views/content/forms
 * @name      competidor_editar
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     18/09/2013
 */


$qtd_niveis = $this->config->item('qtd_niveis');

echo form_hidden('qtd_niveis', (!empty($qtd_niveis) ? $qtd_niveis : '1'));

echo form_hidden('com_id', (isset($competidor->id) ? $competidor->id : ''));

echo form_input(array('name' => 'url_email_ajax' , 'id'=> 'url_email_ajax' , 'value' => base_url('ajax/email'), 'type' => 'hidden'));
?>
<div class="formSep">
    <div class="row-fluid">
        <div class="span5">
            <label for="com_nome" class="req"><?php echo _lang('form_nome'); ?>&nbsp;</label>
            <input type="text" name="com_nome" placeholder="<?php echo _lang('form_nome'); ?>" value="<?php echo ((isset($competidor->nome)) ? $competidor->nome : '') ?>" class="span11"  />
        </div>
        <div class="span5">
            <label for="com_email" class="req"><?php echo _lang('form_email'); ?>&nbsp;</label>
            <input type="text" name="com_email" id="com_email" placeholder="<?php echo _lang('form_email'); ?>" value="<?php echo ((isset($competidor->email)) ? $competidor->email : '') ?>" class="span10"  />
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="com_telefone"><?php echo _lang('form_telefone'); ?>&nbsp;</label>
            <input type="text" name="com_telefone" placeholder="<?php echo _lang('form_telefone'); ?>" data-inputmask="'mask': '(99)9999-9999[9]'" value="<?php echo ((isset($competidor->telefone)) ? $competidor->telefone : '') ?>" class="span11"  />
        </div>
        <div class="span4">
            <label for="com_celular"><?php echo _lang('form_celular'); ?>&nbsp;</label>
            <input type="text" name="com_celular" placeholder="<?php echo _lang('form_celular'); ?>" data-inputmask="'mask': '(99)9999-9999[9]'" value="<?php echo ((isset($competidor->celular)) ? $competidor->celular : '') ?>" class="span11"  />
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <label for="com_senha"><?php echo _lang('form_senha'); ?>&nbsp;</label>
            <input type="password" name="com_senha" placeholder="<?php echo _lang('form_senha'); ?>" value="" class="span11" id="nova_senha"  />
            <div id="pass_progressbar" class="progress progress-danger progress-small" style="max-width:48.7%;">
                <div id="pass_progress" class="bar"></div>
            </div>
            <div class="span4">
                <span id="complexityLabel"><?php echo _lang('form_complexidade');?>: </span>
                <span id="complexity">0%</span>
            </div>
        </div>
        <div class="span4">
            <label for="com_senha2"><?php echo _lang('form_confirmar_senha'); ?>&nbsp;</label>
            <input type="password" name="com_senha2" placeholder="<?php echo _lang('form_confirmar_senha'); ?>" value="" class="span11"  />
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span2">
            <label for="com_ativo" class="req"><?php echo _lang('form_status'); ?>&nbsp;</label>
            <div class="switch switch-small" data-on="success" data-on-label="<?php echo _lang('form_ativo');?>" data-off="danger" data-off-label="<?php echo _lang('form_inativo');?>">
                <?php echo form_checkbox('com_ativo', '1', ((isset($competidor->ativo) && ($competidor->ativo > 0)) ? true : false));?>
            </div>
        </div>
        <div class="span2">
            <label for="com_idioma"><?php echo _lang('form_idioma'); ?>&nbsp;</label>
            <?php
            $idiomas = $this->config->item('sis_idiomas');
            $idiomas[''] = _lang('form_selecione');

            echo form_dropdown('com_idioma', $idiomas, (isset($competidor->idioma)) ? $competidor->idioma : '', 'class="styled-select"');
            ?>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span3">
            <label for="com_materias" class="req"><?php echo _lang('form_materias_conhecimento'); ?>&nbsp;</label>

            <?php
            if (isset($materias)) {

                foreach ($materias as $materia) {

                    $checked = FALSE;
                    if (isset($possui_materias)) {

                        for ($i = 0; $i < sizeof($possui_materias); $i++) {

                            if ($possui_materias[$i] == $materia->id) {

                                $checked = TRUE;
                                break;
                            }
                        }
                    }

                    echo '<p>' . form_checkbox('com_materias[]', $materia->id, $checked, 'class="checkbox icheck"') . nbs() . _lang($materia->nome) . '</p>';
                }
//                echo '<span id="verifica_checkbox" class="text-error" style="display: none;">' . _lang('competidor_materia_nao_selecionada') . '</span>';
            }
            ?>
        </div>
        <div class="span3">
            <label for="com_categorias" class="req"><?php echo _lang('form_categorias_conhecimento'); ?>&nbsp;</label>

            <?php
            if (isset($categorias)) {

                foreach ($categorias as $categoria) {

                    $checked = FALSE;
                    if (isset($possui_categorias)) {

                        for ($i = 0; $i < sizeof($possui_categorias); $i++) {

                            if ($possui_categorias[$i] == $categoria->id) {

                                $checked = TRUE;
                                break;
                            }
                        }
                    }

                    echo '<p>' . form_checkbox('com_categorias[]', $categoria->id, $checked, 'class="checkbox icheck"') . nbs() . _lang($categoria->nome) . '</p>';
                }
//                echo '<span id="verifica_checkbox" class="text-error" style="display: none;">' . _lang('competidor_categoria_nao_selecionada') . '</span>';
            }
            ?>
        </div>
        <div class="span4">
            
            <label for="com_nivel" class="req"><?php echo _lang('form_nivel_programacao'); ?>&nbsp;</label>
            
            <?php
            
            $opcoes_niveis = array();
            
            for($i=1; $i<=$qtd_niveis; $i++){
                $opcoes_niveis[$i] = $i;
            }

            echo form_dropdown('com_nivel', $opcoes_niveis, (isset($competidor->nivel_id)) ? $competidor->nivel_id : '', 'id="nivel" class="input-mini" style="margin-bottom: 15px;"');
            ?>
            
            
        </div>
    </div>
</div>