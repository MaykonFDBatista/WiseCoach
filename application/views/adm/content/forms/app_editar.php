<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Conteudo do formulario de edicao de app
 * 
 * @package   views/content/forms
 * @name      app_editar   
 * @author    João Cláudio Dias Araújo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     11/10/2013
 */

echo form_input(array('name' => 'app_id' , 'id'=> 'app_id' , 'value' => (isset($app->id) ? $app->id : '0'), 'type' => 'hidden'));

?>

<div class="endereco">
    <div class="formSep">
        <label for="app_nome" class="req"><?php echo _lang('form_nome'); ?></label>
        <input type="text" name="app_nome" placeholder="<?php echo _lang('form_nome'); ?>" value="<?php echo ((isset($app->nome)) ? $app->nome : '') ?>" class="span8"  />
    </div>

    <div class='formSep  clearfix'>
        <div class="row-fluid">
            <div class="span3">
               <label for="app_cep" class="req"><?php echo _lang('form_cep'); ?></label>
               <input type="text" name="app_cep" placeholder="<?php echo _lang('form_cep'); ?>" data-inputmask="'mask': '99999999'" value="<?php echo ((isset($app->cep)) ? $app->cep : '') ?>" class="span8 consulta_cep"  />
            </div>
            <div class="span2">
                <div class="row-fluid">

                   <?php
                   echo '<input type="hidden" id="url_cidade_ajax" value="' . base_url($this->config->item('admin') . 'ajax/cidade') . '" />';

                   $uf[''] = _lang('form_selecione');

                   echo '<label class="req">&nbsp;' . _lang('form_estado') . ':&nbsp;</label>';

                   echo form_dropdown('estado_d', $uf, (isset($app->uf)) ? $app->uf : '', 'id="estado_d" class="styled-select span10 dropdown_estado"');

                   echo nbs(4);
                   ?>
                </div>
            </div>
           <div class="span6">
               <div class="row-fluid">
                   <label for="app_cidade" class="req"><?php echo _lang('form_cidade');?></label>
                   <?php
                   $cidade[''] = _lang('form_selecione');
                   echo form_dropdown('app_cidade', $cidade, (isset($app->cidade)) ? $app->cidade : '', 'id="cidade"  class="styled-select dropdown_cidade span4"');
                   // Informa a url da imagem load que aparece no modal esqueci minha senha
                   $loaders = $this->config->item('adm_loaders');
                   echo '<span class="load" id="load" style="display: none;">' . img(base_url($loaders[13])) . '</span>';
                   ?>
               </div>
           </div>
        </div>
    </div>
    
    <div class="formSep">
        <div class="row-fluid">
            <div class="span3">
                <label for="app_bairro" class="req"><?php echo _lang('form_bairro'); ?></label>
                <input type="text" name="app_bairro" placeholder="<?php echo _lang('form_bairro'); ?>" value="<?php echo ((isset($app->bairro)) ? $app->bairro : '') ?>" class="span11 bairro"  />
            </div>
            <div class="span6">
                <label for="app_logradouro" class="req"><?php echo _lang('form_logradouro'); ?></label>
                <input type="text" name="app_logradouro" placeholder="<?php echo _lang('form_logradouro'); ?>" value="<?php echo ((isset($app->logradouro)) ? $app->logradouro : '') ?>" class="span12 logradouro"  />
            </div>
            <div class="span2">
                <label for="app_numero" class="req"><?php echo _lang('form_numero'); ?></label>
                <input type="text" name="app_numero" placeholder="<?php echo _lang('form_numero'); ?>" value="<?php echo ((isset($app->numero)) ? $app->numero : '') ?>" class="span5"  />
            </div>
        </div>
    </div>
    
    <div class="formSep">
        <div class="row-fluid">
            <div class="span2">
                <label for="app_telefone" class="req"><?php echo _lang('form_telefone'); ?></label>
                <input type="text" name="app_telefone" placeholder="<?php echo _lang('form_telefone'); ?>" data-inputmask="'mask': '(99)9999-9999[9]'" value="<?php echo ((isset($app->telefone)) ? $app->telefone : '') ?>" class="span12"  />
            </div>
            <div class="span2">
                <label for="app_ativo" class="req"><?php echo _lang('form_status'); ?></label>
                <?php echo form_dropdown('app_ativo', array('' => _lang('form_selecione'), '1' => _lang('form_ativo'), '0' => _lang('form_inativo')), (isset($app->ativo)) ? $app->ativo : '', 'class="styled-select span12"') ?>
            </div>
        </div>
    </div>
 
    <div class="formSep">
        <div class="row-fluid">
            <div class="span3">
                <label><?php echo _lang('form_logotipo');?> </label>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 130px; height: 130px;">
                            <img src="<?php echo _logo(); ?>" alt="">
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-small btn-file">
                                <span class="fileupload-new"><?php echo _lang('form_selecione');?></span>
                                <span class="fileupload-exists"><?php echo _lang('form_alterar');?></span><input type="file" name="userfile">
                            </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo _lang('form_remover');?></a>
                        </div>
                    </div>
                    <?php
                    $config = $this->config->item('imagem');
                    $f_aux = explode('|', $config['allowed_types']);
                    $formatos = '';

                    for ($i = 0; $i < sizeof($f_aux); $i++) {

                        $formatos .= $f_aux[$i];
                        if (($i + 1) < sizeof($f_aux))
                            $formatos .= ', ';
                    }
                    $formatos .= '.';
                    echo '<span class="help-block" id="limit-text">' . _lang('form_formatos_aceitos'). ': ' . $formatos . '<br>' . _lang('form_dimensoes_max'). ': ' . $config['max_width'] . ' X ' . $config['max_height'] . '.</span>'
                    ?>
            </div>
            <div class="span6">
                &nbsp;
            </div>
            <div class="span6">
                <label for="app_contato" class="req"><?php echo _lang('form_contato'); ?></label>
                <input type="text" name="app_contato" placeholder="<?php echo _lang('msg_info_contato'); ?>" value="<?php echo ((isset($app->contato)) ? $app->contato : '') ?>" class="span11"  />
            </div>
            <div class="span6">
                &nbsp;
            </div>
            <div class="span6">
                <label for="app_website" class="req"><?php echo _lang('form_website'); ?></label>
                <input type="text" name="app_website" placeholder="<?php echo _lang('form_website'); ?>" value="<?php echo ((isset($app->website)) ? $app->website : '') ?>" class="span11"  />
            </div>
        </div>
    </div>

    <div class="formSep">

        <div>
        <label>
            <?php echo _lang('form_imagens_galeria'); ?>

            <ul class="gallery_layout inline pull-right">
                <li class="gallery_grid active_layout" title="Grid"><i class="elusive-icon-th-large"></i></li>
                <li class="gallery_list" title="List"><i class="elusive-icon-align-justify"></i></li>
            </ul>
        </label>
        </div>
        <div id="gallery">
            <ul>
                <?php
                if (isset($galeria) && is_array($galeria)) {

                    $count = 0;
                    foreach ($galeria as $imagem) {
                    ?>    
                        <li class="mix cat_all category_b <?php echo 'im_' . $count; ?>">
                            <a class="holder img-polaroid"<?php echo  'data-img-src="' . base_url(_galeria() . $imagem) . '" href="' . base_url(_galeria() . $imagem) . '" title="' . $imagem . '">';?>
                                <img <?php echo  'src="' . base_url(_galeria() . $imagem) . '"alt="' . $imagem . '"';?>>
                            </a>
                            <div class="img_more_details">
                                <label><?php echo $imagem;?></label>
                            </div>
                            <span class="img_actions">
                                <i class="elusive-icon-remove" title="Remover" alt="Remover" onClick="remove_imagem('<?php echo 'im_' . $count . '\',\'' . $imagem; ?>');"></i>
                            </span>
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
                <div id="multi_upload">
                    <p><?php echo _lang('msg_erro_multiupload')?></p>
                </div>
            </div>
        </div>
    </div>
</div>
        