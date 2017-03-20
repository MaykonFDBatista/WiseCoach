<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <?php echo _lang('menu_objeto_aprendizagem'); ?>
                    &rsaquo;
                    <?php echo $objeto_aprendizagem->titulo; ?>
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-10">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="blog-post blog-single-post">	
                            <div class="row">
                                <?php
                                $url = base_url($this->config->item('objeto_aprendizagem_url_publica') . $objeto_aprendizagem->identificador);
                                $tipo_img = exif_imagetype($url);
                                if(!is_null($tipo_img) && !empty($tipo_img)) {
                                    echo '<img src="' . $url . '" class="img-responsive">';
                                }
                                else if(mime_content_type($url)=='video/mp4'){
                                    echo '<div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="' . $url . '"></iframe>
                                      </div>';
                                }
                                else {
                                    echo '<iframe style="WIDTH: 100%; HEIGHT: 500px;" src="http://docs.google.com/gview?url=' . $url . '&amp;embedded=true" frameBorder=0></iframe>';
                                }
                                ?>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <?php
                                $materias = '';
                                if (isset($objeto_aprendizagem->materias)) {
                                    foreach ($objeto_aprendizagem->materias as $i => $m) {
                                        $materias .= $m->nome . ', ';
                                    }
                                }

                                $estilos = '';
                                if (isset($objeto_aprendizagem->estilos_aprendizagem)) {
                                    foreach ($objeto_aprendizagem->estilos_aprendizagem as $i => $e) {
                                        $estilos .= _lang($e->nome) . ', ';
                                    }
                                }

                                $link_download = anchor(base_url($this->config->item('ws') . 'objeto_aprendizagem/download/' . $objeto_aprendizagem->id), '<i class="glyphicon glyphicon-download-alt"></i> ' . _lang('form_download'), 'class="pull-right"');

                                echo heading(_lang('form_conteudo') . $link_download, 3);

                                echo '<p>' . form_label(_lang('form_titulo')) . nbs() . ((isset($objeto_aprendizagem->titulo)) ? $objeto_aprendizagem->titulo : '') . '</p>';

                                echo '<p>' . form_label(_lang('form_assunto')) . nbs() . $materias . '</p>';

                                echo '<p>' . form_label(_lang('form_descricao')) . nbs() . ((isset($objeto_aprendizagem->descricao)) ? $objeto_aprendizagem->descricao : '') . '</p>';

                                echo '<p>' . form_label(_lang('form_fonte')) . nbs() . ((isset($objeto_aprendizagem->fonte)) ? $objeto_aprendizagem->fonte : '') . '</p>';

                                echo '<p>' . form_label(_lang('form_relacao')) . nbs() . ((isset($objeto_aprendizagem->relacao)) ? $objeto_aprendizagem->relacao : '') . '</p>';

                                echo '<p>' . form_label(_lang('form_cobertura')) . nbs() . ((isset($objeto_aprendizagem->cobertura)) ? $objeto_aprendizagem->cobertura : '') . '</p>';

                                echo heading(_lang('form_propriedade_intelectual'), 3);

                                echo '<p>' . form_label(_lang('form_autor')) . nbs() . ((isset($objeto_aprendizagem->autor)) ? $objeto_aprendizagem->autor : '') . '</p>';

                                echo '<p>' . form_label(_lang('form_editor')) . nbs() . ((isset($objeto_aprendizagem->editor)) ? $objeto_aprendizagem->editor : '') . '</p>';

                                echo '<p>' . form_label(_lang('form_colaborador')) . nbs() . ((isset($objeto_aprendizagem->colaborador)) ? $objeto_aprendizagem->colaborador : '') . '</p>';

                                echo '<p>' . form_label(_lang('form_direito_autoral')) . nbs() . ((isset($objeto_aprendizagem->direito_autoral)) ? $objeto_aprendizagem->direito_autoral : '') . '</p>';

                                echo heading(_lang('form_instanciacao'), 3);

                                echo '<p>' . form_label(_lang('form_data')) . nbs() . ((isset($objeto_aprendizagem->data) && $objeto_aprendizagem->data != '') ? date(_lang('formato_data'), strtotime($objeto_aprendizagem->data)) : '') . '</p>';

                                echo '<p>' . form_label(_lang('form_tipo')) . nbs() . ((isset($objeto_aprendizagem->tipo_id)) ? $objeto_aprendizagem->tipo : '') . '</p>';

                                echo '<p>' . form_label(_lang('form_formato')) . nbs() . ((isset($objeto_aprendizagem->formato_id)) ? $objeto_aprendizagem->mime_type : '') . '</p>';

                                echo '<p>' . form_label(_lang('form_idioma')) . nbs() . ((isset($objeto_aprendizagem->idioma)) ? $objeto_aprendizagem->idioma : '') . '</p>';

                                echo heading(_lang('form_estilos_aprendizagem'), 3);

                                echo '<p>' . $estilos . '</p>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
