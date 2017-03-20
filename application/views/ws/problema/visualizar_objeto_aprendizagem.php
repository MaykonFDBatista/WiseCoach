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
                    <?php echo _lang('menu_problemas'); 
                        echo nbs() . '&rsaquo;' . nbs();
                        echo anchor(base_url($this->config->item('ws'). 'problema/visualizar/'.$problema->id) , $problema->nome, '');
                        echo nbs() . '&rsaquo;' . nbs();
                        echo _lang('form_objetos_aprendizagem');
                    ?>
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
                    <div class="col-sm-3">
                        <?php echo $this->load->view($this->config->item('ws') . 'problema/submenu');?>
                    </div>
                    <div class="col-sm-9">

                        <div class="blog-post blog-single-post">
                            <?php 
                            if(isset($materias) && (sizeof($materias) > 0)) {
                                echo heading(_lang('form_materias'), 3);
                                foreach($materias as $m) {
                                    echo '<p>' . $m->nome . '</p>';
                                }
                            }
                            
                            echo heading(_lang('form_objetos_aprendizagem'),3);     
                            
                            if(isset($objetos) && (sizeof($objetos) > 0)) {
                                
                                $tmpl = array ( 'table_open'  => '<table class="table table-striped table-bordered">' );

                                $this->table->set_template($tmpl);

                                foreach ($objetos as $obj) {
                                    
                                    $url = $this->config->item('objeto_aprendizagem_url') . $obj->identificador;
                                    
                                    $this->table->add_row(
                                            array(
                                                '<p>' . $obj->titulo . '</p><p class="text-muted">' . $obj->descricao . '</p>', 
                                                '<p><i class="' . $obj->icone . '"></i> ' . $obj->tipo . '</p><p class="text-muted">' . $obj->formato . '</p>',
                                                anchor(base_url($this->config->item('ws') . 'objeto_aprendizagem/visualizar/' . $obj->id), '<i class="glyphicon glyphicon-search"></i> ' . _lang('form_visualizar'), 'target="_blank"'), 
                                                anchor(base_url($this->config->item('ws') . 'objeto_aprendizagem/download/' . $obj->id), '<i class="glyphicon glyphicon-download-alt"></i> ' . _lang('form_download'))
                                                )
                                    );
                                }
                                
                                echo $this->table->generate();
                            }
                            else{
                                echo _lang('msg_nenhum_objeto_aprendizagem_encontrado');
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>