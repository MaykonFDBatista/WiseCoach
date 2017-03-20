<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');

echo form_hidden('id', (isset($objeto_aprendizagem->id) ? $objeto_aprendizagem->id : ''));

echo form_hidden('identificador', (isset($objeto_aprendizagem->identificador) ? $objeto_aprendizagem->identificador : ''));
?>
<div class="formSep">
    <div class="span12">
        <label for="arquivo" class="req"><?php echo _lang('form_arquivo'); ?>&nbsp;</label>
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input input-large">
                    <i class="icon-file fileupload-exists"></i>
                    <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                    <span class="fileupload-new"><?php echo _lang('form_selecione');?></span>
                    <span class="fileupload-exists"><?php echo _lang('form_alterar');?></span>
                    <input type="file" name="arquivo" id="arquivo">
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo _lang('form_remover');?></a>
            </div>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="span12">
        <div class="accordion" id="accordion1">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1">
                        <?php echo _lang('form_conteudo')?>
                    </a>
                </div>
                <div id="collapseOne1" class="accordion-body in collapse">
                    <div class="accordion-inner">
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="titulo" class="req"><?php echo _lang('form_titulo'); ?>&nbsp;</label>
                                    <input type="text" name="titulo" id="titulo" placeholder="<?php echo _lang('form_titulo_exemplo'); ?>" value="<?php echo ((isset($objeto_aprendizagem->titulo)) ? $objeto_aprendizagem->titulo : '') ?>" class="span10"  />
                                </div>
                            </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="materia" class="req"><?php echo _lang('form_assunto'); ?>&nbsp;</label>
                                    <?php 
                                    $opcoes = '';
                                    if(isset($objeto_aprendizagem->materias)){
                                        $opcoes = array();
                                        foreach($objeto_aprendizagem->materias as $i => $m) {
                                            $opcoes[$i]['id'] = $m->id;
                                            $opcoes[$i]['text'] = $m->nome;
                                        }
                                        $opcoes = json_encode($opcoes);
                                    }
                                    ?>
                                    <input type="text" name="materia" id="materia" placeholder="<?php echo _lang('form_assunto_exemplo'); ?>" value='<?php echo $opcoes; ?>' class="span10"  />
                                </div>
                            </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="descricao" class=""><?php echo _lang('form_descricao'); ?>&nbsp;</label>
                                    <textarea name="descricao" id="descricao" placeholder="<?php echo _lang('form_descricao_exemplo'); ?>" class="span10"><?php echo ((isset($objeto_aprendizagem->descricao)) ? $objeto_aprendizagem->descricao : '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="fonte" class=""><?php echo _lang('form_fonte'); ?>&nbsp;</label>
                                    <input type="text" name="fonte" id="fonte" placeholder="<?php echo _lang('form_fonte_exemplo'); ?>" value="<?php echo ((isset($objeto_aprendizagem->fonte)) ? $objeto_aprendizagem->fonte : '') ?>" class="span10"  />
                                </div>
                                </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="relacao" class=""><?php echo _lang('form_relacao'); ?>&nbsp;</label>
                                    <input type="text" name="relacao" id="relacao" placeholder="<?php echo _lang('form_relacao_exemplo'); ?>" value="<?php echo ((isset($objeto_aprendizagem->relacao)) ? $objeto_aprendizagem->relacao : '') ?>" class="span10"  />
                                </div>
                                </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="cobertura" class=""><?php echo _lang('form_cobertura'); ?>&nbsp;</label>
                                    <input type="text" name="cobertura" id="cobertura" placeholder="<?php echo _lang('form_cobertura_exemplo'); ?>" value="<?php echo ((isset($objeto_aprendizagem->cobertura)) ? $objeto_aprendizagem->cobertura : '') ?>" class="span10"  />
                                </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1">
                        <?php echo _lang('form_propriedade_intelectual')?>
                    </a>
                </div>
                <div id="collapseTwo1" class="accordion-body collapse">
                    <div class="accordion-inner">             
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="autor" class=""><?php echo _lang('form_autor'); ?>&nbsp;</label>
                                    <input type="text" name="autor" id="autor" placeholder="<?php echo _lang('form_autor_exemplo'); ?>" value="<?php echo ((isset($objeto_aprendizagem->autor)) ? $objeto_aprendizagem->autor : '') ?>" class="span10"  />
                                </div>
                                </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="editor" class=""><?php echo _lang('form_editor'); ?>&nbsp;</label>
                                    <input type="text" name="editor" id="editor" placeholder="<?php echo _lang('form_editor_exemplo'); ?>" value="<?php echo ((isset($objeto_aprendizagem->editor)) ? $objeto_aprendizagem->editor : '') ?>" class="span10"  />
                                </div>
                            </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="colaborador" class=""><?php echo _lang('form_colaborador'); ?>&nbsp;</label>
                                    <input type="text" name="colaborador" id="colaborador" placeholder="<?php echo _lang('form_colaborador_exemplo'); ?>" value="<?php echo ((isset($objeto_aprendizagem->colaborador)) ? $objeto_aprendizagem->colaborador : '') ?>" class="span10"  />
                                </div>
                            </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="direito_autoral" class=""><?php echo _lang('form_direito_autoral'); ?>&nbsp;</label>
                                    <input type="text" name="direito_autoral" id="direito_autoral" placeholder="<?php echo _lang('form_direito_autoral_exemplo'); ?>" value="<?php echo ((isset($objeto_aprendizagem->direito_autoral)) ? $objeto_aprendizagem->direito_autoral : '') ?>" class="span10"  />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree1">
                        <?php echo _lang('form_instanciacao')?>
                    </a>
                </div>
                <div id="collapseThree1" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="data" class=""><?php echo _lang('form_data'); ?>&nbsp;</label>
                                    <div class="input-append date bs_datepicker" data-date-format="<?php echo _lang('formato_data_js');?>" data-date-language="<?php echo _idioma();?>" data-date-autoclose="true">
                                        <input type="text" name="data" id="data" placeholder="<?php echo _lang('form_data'); ?>" value="<?php echo ((isset($objeto_aprendizagem->data) && $objeto_aprendizagem->data != '') ? date(_lang('formato_data'), strtotime($objeto_aprendizagem->data)) : '') ?>" class="span8"  />
                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>            
                                </div>
                            </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="tipo" class=""><?php echo _lang('form_tipo'); ?>&nbsp;</label>
                                    <?php 
                                    $tipos = _dropdown_list($tipos,'id','nome');
                                    echo form_dropdown('tipo',$tipos,((isset($objeto_aprendizagem->tipo_id)) ? $objeto_aprendizagem->tipo_id : ''),'class="formated_select span4" id="tipo"');
                                    ?>
                                </div>
                                </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span12">
                                    <label for="formato" class=""><?php echo _lang('form_formato'); ?>&nbsp;</label>
                                    <?php
                                    $opcoes = array();
                                    if(isset($formatos)) {
                                        foreach($formatos as $f) {
                                            $opcoes[$f->id] = $f->extensao . ($f->mime_type != '') ? ' - ' . $f->mime_type : '';
                                        }
                                    }
                                    echo form_dropdown('formato',$opcoes,((isset($objeto_aprendizagem->formato_id)) ? $objeto_aprendizagem->formato_id : ''),'class="formated_select span10" placeholder="' . _lang('form_formato_exemplo') . '" id="formato"');
                                    ?>
                                </div>
                                </div>
                        </div>
                        <div class="formSep">
                            <div class="row-fluid">
                                <div class="span4">
                                    <label for="linguagem" class=""><?php echo _lang('form_linguagem'); ?>&nbsp;</label>
                                    <?php 
                                    $linguagens = _dropdown_list($linguagens,'iso_639-1','iso_639-1');
                                    $selecionado = (isset($objeto_aprendizagem->idioma) && $objeto_aprendizagem->idioma != '') ? explode('-',$objeto_aprendizagem->idioma)[0] : '';
                                    echo form_dropdown('linguagem',$linguagens,$selecionado,'class="formated_select span10"');
                                    ?>
                                </div>
                                <div class="span8">
                                    <label for="pais" class=""><?php echo _lang('form_pais'); ?>&nbsp;</label>
                                    <?php
                                    $paises = _dropdown_list($paises,'alpha2','alpha2');
                                    $selecionado = (isset($objeto_aprendizagem->idioma) && $objeto_aprendizagem->idioma != '') ? explode('-',$objeto_aprendizagem->idioma)[1] : '';
                                    echo form_dropdown('pais',$paises,$selecionado,'class="formated_select span4"');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="formSep">
    <div class="row-fluid">
        <div class="span12">
            <label for="estilo_aprendizagem" class="req"><?php echo _lang('form_estilos_aprendizagem'); ?>&nbsp;</label>
            <?php 
            $opcoes = '';
            if(isset($objeto_aprendizagem->estilos_aprendizagem)){
                $opcoes = array();
                foreach($objeto_aprendizagem->estilos_aprendizagem as $i => $e) {
                    $opcoes[$i]['id'] = $e->id;
                    $opcoes[$i]['text'] = _lang($e->nome);
                }
                $opcoes = json_encode($opcoes);
            }
            ?>
            <input type="text" name="estilo_aprendizagem" id="estilo_aprendizagem" placeholder="<?php echo _lang('form_estilo_aprendizagem'); ?>" value='<?php echo $opcoes; ?>' class="span10"  />
        </div>
    </div>
</div>