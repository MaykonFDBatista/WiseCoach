<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!-- Page Title -->
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <?php echo _lang('menu_problemas'); 
                        echo nbs() . '&rsaquo;' . nbs();
                        echo anchor(base_url($this->config->item('ws'). 'problema/visualizar/'.$problema->id) , $problema->nome, '');
                        echo nbs() . '&rsaquo;' . nbs();
                        echo _lang('form_submeter');
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
                
                <?php
                if ($this->session->flashdata('msg') != "") {
    
                    switch ($this->session->flashdata('msg')) {

                        case 'msg_submissao-ok': {
                                $tp = 'alert alert-success';
                            } break;
                        case 'msg_vazio': {
                                $tp = 'alert alert-danger';
                            } break;
                        case 'msg_error': {
                                $tp = 'alert alert-danger';
                            } break;
                        default: {
                                $tp = 'alert alert-warning';
                            } break;
                    }
                    echo '<div class="' . $tp . '">' . _lang($this->session->flashdata('msg')) . "<button type='button' class='close' data-dismiss='alert'>×</button> </div>";
                }
                ?>

                <div class="blog-post blog-single-post">
                    
                    <?php
                    if($problema->nome != ''){
                    ?>
                    <div class="problema-cabecalho">
                        <h1><?php echo $problema->nome; ?></h1>
                        <?php
                        if($problema->timelimit != ''){
                        ?>
                        <strong><?php echo _lang('form_timelimit'). ':&nbsp;' . $problema->timelimit; ?></strong>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    }
                    ?>
                    
                    <div class="problema">
                        <form role="form" role="form" id="form_submeter" method="post" action="<?php echo base_url($url);?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="linguagem"><i class="icon-user"></i> <b><?php echo _lang('form_linguagem');?>&nbsp;*</b></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php
                                                $linguagens = $this->config->item('linguagens');
                                                $linguagens = _lang($linguagens);
                                                $extensoes = $this->config->item('extensoes');
                                                $highlighters = $this->config->item('highlighters');
                                                
                                                echo '<select name="linguagem" id="linguagem" class="form-control">';
                                                
                                                foreach($linguagens as $key => $value){
                                                    echo '<option value="'. $key .'" data-extensao="'. $extensoes[$key] .'" data-highlighter="'. $highlighters[$key] .'">' . $value .'</option>';
                                                }
                                                
                                                echo '</select>';
                                                
                                                ?>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="codigo_fonte"><i class="icon-user"></i> <b><?php echo _lang('form_digite_codigo_fonte'); ?></b></label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <textarea id="codigo_fonte" name="codigo_fonte" class="hidden"></textarea>
                                        <pre id="editor"></pre>
                                        <div class="scrollmargin"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <label for="userfile"><i class="icon-user"></i> <b><?php echo _lang('form_ou_selecione_arquivo');?></b></label>
                                        <input type="file" name="userfile" id="codigo_fonte_arquivo" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="text-align: center">
                                <button type="submit" id="botao" class="btn"><?php echo _lang('form_submeter'); ?></button>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>

                </div>
                </div>
                </div>
        </div>
    </div>
</div>