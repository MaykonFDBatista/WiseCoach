<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Conteudo do formulario de edicao de problema
 * 
 * @package   views/content/forms
 * @name      problema_editar
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     18/09/2013
 */


$qtd_niveis = $this->config->item('qtd_niveis');

echo form_hidden('qtd_niveis', (!empty($qtd_niveis) ? $qtd_niveis : '1'));

echo form_hidden('pro_id', (isset($problema->id) ? $problema->id : 0));

?>

<div class="formSep">
    <div class="row-fluid">
        <div class="span5">
            <label for="pro_nome" class="req"><?php echo _lang('form_nome'); ?>&nbsp;</label>
            <input type="text" name="pro_nome" placeholder="<?php echo _lang('form_nome'); ?>" value="<?php echo ((isset($problema->nome)) ? $problema->nome : '') ?>" class="span11"  />
        </div>
    </div>
</div>

<div class="formSep">
    <div>
        <label class="">
            <?php echo _lang('form_arquivos'); ?>
        </label>
    </div>
    <div class="">
        <ul class="unstyled">
            <?php
            if (isset($arquivos) && is_array($arquivos)) {
                $url = base_url($this->config->item('url_arquivos_admin') . 'problemas/' . $problema->id . '/arquivos');
                $count = 0;
                foreach ($arquivos as $arquivo) {
                    ?>    
                    <li class="<?php echo 'arq_' . $count; ?>">
                        <a href="<?php echo $url . '/' . $arquivo; ?>" target="_blank">
                            <i class="elusive-icon-edit"></i>
                            <?php echo $arquivo; ?>
                        </a>
                        <i class="elusive-icon-remove" style="cursor:pointer;" title="Remover" alt="Remover" onClick="remove_arquivo('<?php echo 'arq_' . $count . '\',\'' . $arquivo; ?>');"></i>
                    </li>
                    <?php
                    $count++;
                }
            }
            ?>
        </ul>
    </div>
    <div class="box_a">

        <div class="box_a_content">
            <div id="multi_upload_arquivo">
                <p><?php echo _lang('msg_erro_multiupload') ?></p>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <?php
        if(isset($problema->id)){
            $url = base_url($this->config->item('url_arquivos_admin') . 'problemas/' . $problema->id . '/arquivos');
        }
        else{
            $url = base_url($this->config->item('url_arquivos_admin') . 'problemas/0/arquivos');
        }
        $url .= '<i>/[' . _lang('form_nome_do_arquivo_acima') .']</i>';
        $substituir = '(' . _lang('form_substituir_espacos') . ')';
        ?>
        <span><strong><?php echo _lang('form_obs');?>.:</strong> <?php echo _lang('msg_arquivos_utilizados_editores');?></span><br>
        <span><strong><?php echo _lang('form_url');?>:</strong> <?php echo $url . ' ' . $substituir;?></span>
    </div>
</div>

<div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="pro_descricao" class="req"><?php echo _lang('form_descricao'); ?>&nbsp;</label>
            <div class="box_a_content cnt_no_pad">
                <textarea class="wysiwg_editor" id="descricao" name="pro_descricao" cols="70" row="2"><?php  echo ((isset($problema->descricao)) ? $problema->descricao : ''); ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="pro_entrada" class="req"><?php echo _lang('form_entrada'); ?>&nbsp;</label>
            <div class="box_a_content cnt_no_pad">
                <textarea class="wysiwg_editor" id="entrada" name="pro_entrada" cols="70" row="2"><?php  echo ((isset($problema->entrada)) ? $problema->entrada : ''); ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="pro_saida" class="req"><?php echo _lang('form_saida'); ?>&nbsp;</label>
            <div class="box_a_content cnt_no_pad">
                <textarea class="wysiwg_editor" id="saida" name="pro_saida" cols="70" row="2"><?php  echo ((isset($problema->saida)) ? $problema->saida : ''); ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="pro_restricoes"><?php echo _lang('form_restricoes'); ?>&nbsp;</label>
            <div class="box_a_content cnt_no_pad">
                <textarea class="wysiwg_editor" id="restricoes" name="pro_restricoes" cols="70" row="2"><?php  echo ((isset($problema->restricoes)) ? $problema->restricoes : ''); ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span6">
            <label for="pro_exemplo_entrada" class="req"><?php echo _lang('form_exemplo_entrada'); ?>&nbsp;</label>
            <div class="box_a_content cnt_no_pad">
                <textarea class="wysiwg_editor" id="exemplo_entrada" name="pro_exemplo_entrada" cols="70" row="2"><?php  echo ((isset($problema->exemplo_entrada)) ? $problema->exemplo_entrada : ''); ?></textarea>
            </div>
        </div>
        <div class="span6">
            <label for="pro_exemplo_saida" class="req"><?php echo _lang('form_exemplo_saida'); ?>&nbsp;</label>
            <div class="box_a_content cnt_no_pad">
                <textarea class="wysiwg_editor" id="exemplo_saida" name="pro_exemplo_saida" cols="70" row="2"><?php  echo ((isset($problema->exemplo_saida)) ? $problema->exemplo_saida : ''); ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        
    </div>
</div>

<div class="formSep">
    <div class="row-fluid">
        <div class="span3">
            <label for="pro_timelimit"><?php echo _lang('form_timelimit'); ?>&nbsp;</label>
            <span class="ui-widget ui-spinner ui-widget-content ui-corner-all ui-spinner-inside ui-spinner-adjacent span5">
                <input name="pro_timelimit" type="text" id="def_spinner" value="<?php echo ((isset($problema->timelimit)) ? $problema->timelimit : '') ?>" aria-valuenow="0" class="ui-spinner-input" autocomplete="off" role="spinbutton" aria-valuemin="" aria-valuemax="">
            </span>
        </div>
        <div class="span2">
            <label for="pro_ativo" class="req"><?php echo _lang('form_status'); ?>&nbsp;</label>
            <div class="switch switch-small" data-on="success" data-on-label="<?php echo _lang('form_ativo');?>" data-off="danger" data-off-label="<?php echo _lang('form_inativo');?>">
                <?php echo form_checkbox('pro_ativo', '1', ((isset($problema->ativo) && ($problema->ativo > 0)) ? true : false));?>
            </div>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span3">
            <label for="pro_materias" class="req"><?php echo _lang('form_materias_envolvidas'); ?>&nbsp;</label>

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

                    echo '<p>' . form_checkbox('pro_materias[]', $materia->id, $checked, 'class="checkbox icheck"') . nbs() . _lang($materia->nome) . '</p>';
                }
//                echo '<span id="verifica_checkbox" class="text-error" style="display: none;">' . _lang('problema_materia_nao_selecionada') . '</span>';
            }
            ?>
        </div>
        <div class="span3">
            <label for="pro_categoria" class="req"><?php echo _lang('form_categoria'); ?>&nbsp;</label>

            <?php
            if (isset($categorias)) {
                
                $categorias[''] = _lang('form_selecione');

                echo form_dropdown('pro_categoria', $categorias, (isset($problema->categoria_id)) ? $problema->categoria_id : '', 'class="styled-select span10"');
//                echo '<span id="verifica_checkbox" class="text-error" style="display: none;">' . _lang('problema_categoria_nao_selecionada') . '</span>';
            }
            ?>
        </div>
        <div class="span4">
            
            <label for="pro_nivel" class="req"><?php echo _lang('form_nivel_dificuldade'); ?>&nbsp;</label>
            
            <?php
            
            $opcoes_niveis = array();
            
            for($i=1; $i<=$qtd_niveis; $i++){
                $opcoes_niveis[$i] = $i;
            }

            echo form_dropdown('pro_nivel', $opcoes_niveis, (isset($problema->nivel_id)) ? $problema->nivel_id : '', 'id="nivel" class="input-mini" style="margin-bottom: 15px;"');
            ?>
            
            
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span4">
            <?php
            if(isset($problema->id)){
   
                if(file_exists($this->config->item('url_problemas').$problema->id.'/input.in')){
                    $arquivo_entrada = 'input.in';
                }
                else{
                    $arquivo_entrada = '';
                }
            }
            else{
                $arquivo_entrada = '';
            }
            ?>
            <label for="userfile"><?php echo _lang('form_arquivo_entrada'); ?>&nbsp;</label>
            <div class="fileupload <?php echo (!empty($arquivo_entrada)) ? 'fileupload-exists' : 'fileupload-new'?>" data-provides="fileupload"><input type="hidden">
                <div class="input-append">
                    <div class="uneditable-input input-small">
                        <i class="icon-file fileupload-exists"></i>
                        <span class="fileupload-preview"><?php echo $arquivo_entrada;?></span>
                    </div>
                    <span class="btn btn-file">
                        <span class="fileupload-new">Selecionar</span>
                        <span class="fileupload-exists">Alterar</span>
                        <input type="file" name="userfile">
                    </span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                </div>
            </div>
        </div>
        <div class="span4">
            <?php
            if(isset($problema->id)){
   
                if(file_exists($this->config->item('url_problemas').$problema->id.'/output.out')){
                    $arquivo_saida = 'output.out';
                }
                else{
                    $arquivo_saida = '';
                }
            }
            else{
                $arquivo_saida = '';
            }
            ?>
            <label for="userfile2"><?php echo _lang('form_arquivo_saida'); ?>&nbsp;</label>
            <div class="fileupload <?php echo (!empty($arquivo_saida)) ? 'fileupload-exists' : 'fileupload-new'?>" data-provides="fileupload"><input type="hidden">
                <div class="input-append">
                    <div class="uneditable-input input-small">
                        <i class="icon-file fileupload-exists"></i>
                        <span class="fileupload-preview"><?php echo $arquivo_saida;?></span>
                    </div>
                    <span class="btn btn-file">
                        <span class="fileupload-new">Selecionar</span>
                        <span class="fileupload-exists">Alterar</span>
                        <input type="file" name="userfile2" value="<?php echo ((isset($problema->nome)) ? $problema->nome : '') ?>">
                    </span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="pro_dicas"><?php echo _lang('form_dicas'); ?>&nbsp;</label>
            <div class="box_a_content cnt_no_pad">
                <textarea class="wysiwg_editor" id="pro_dicas" name="pro_dicas" cols="70" row="2"><?php  echo ((isset($problema->dicas)) ? $problema->dicas : ''); ?></textarea>
            </div>
        </div>
    </div>
</div>