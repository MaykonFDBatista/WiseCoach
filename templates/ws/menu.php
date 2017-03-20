<?php
    $idiomas = $this->config->item('sis_idiomas');

    $idioma_selecionado = $this->session->userdata('idioma');
    if($idioma_selecionado == ''){
        $idioma_selecionado = $this->config->item('idioma_default');
    }
    $idioma_selecionado_label = $idiomas[$idioma_selecionado];
    $bandeira_selecionado = strtolower(substr($idioma_selecionado, -2));
?>
<div class="mainmenu-wrapper">
    <div class="container">
        <div class="menuextras">
            <div class="extras">
                <ul>
                    <li>
                        <div class="dropdown choose-country">
                            <a id="idioma_selecionado_menu" class="#" data-toggle="dropdown" href="#">                
                                <img src="<?php echo base_url() . $this->config->item('tpl_pasta') . 'img/flags/'. $bandeira_selecionado .'.png'; ?>" alt="<?php echo $idioma_selecionado; ?>"> <?php echo $idioma_selecionado_label; ?>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <?php
                                foreach($idiomas as $idioma => $idioma_label){
                                    
                                    $bandeira = strtolower(substr($idioma, -2));
                                    
                                    $img_propriedades = array('src' => base_url() . $this->config->item('tpl_pasta') . 'img/flags/'. $bandeira .'.png',
                                                              'alt' => $idioma);
                                    
                                    echo '<li role="menuitem">';
                                    echo anchor(base_url($this->config->item('ws')) . '/idioma/alterar/' . $idioma, img($img_propriedades) . ' ' . $idioma_label,array('class' => 'idioma_item_menu apontador', 'data-key' => $idioma));
                                    echo '</li>';

                                }
                                ?>
                            </ul>
                        </div>
                    </li>
                        <?php
                        if($this->session->userdata('id') == ''){
                         echo '<li>' . anchor(base_url($this->config->item('ws') . 'login'), _lang('menu_login')) . '</li>';
                        }
                        else {
                        ?>    
                            <li>
                                <div class="dropdown choose-country">
                                    <a id="idioma_selecionado_menu" class="#" data-toggle="dropdown" href="#">                
                                        <i class="glyphicon glyphicon-tags"></i>&nbsp;&nbsp;<?php echo  _pontos_competidor($this->session->userdata('id')) . 'pts'; ?>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li role="menuitem"><?php echo anchor(base_url($this->config->item('ws') . 'loja'), _lang('form_loja'))?></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown choose-country">
                                    <a id="idioma_selecionado_menu" class="#" data-toggle="dropdown" href="#">                
                                    <?php echo  img(array('src' => _foto_competidor(),'style' => 'max-width:16px;')) . ' ' . $this->session->userdata('nome'); ?>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li role="menuitem"><?php echo anchor(base_url($this->config->item('ws') . 'perfil'), _lang('form_perfil'))?></li>
                                        <li role="menuitem"><?php echo anchor(base_url($this->config->item('ws') . 'logout'), _lang('menu_sair'));?></li>
                                    </ul>
                                </div>
                            </li>
                        <?php
                        }
                        ?>  
                </ul>
            </div>
        </div>
        <nav id="mainmenu" class="mainmenu">
            <ul>
                <li class="logo-wrapper">
                <?php
                
                    $logo = _verifica_extensao($this->config->item('url_arquivos_default') . 'logo_ws');
                    
                    $logo = ($logo != '') ? $logo : 'http://placehold.it/200x40&amp;text=Logotipo';
                        
                    $logo_propriedades = array('src' => base_url($logo), 'alt' => $this->config->item('sis_nome'));

                    echo anchor(base_url($this->config->item('ws')),img($logo_propriedades),array());
                    
                ?>
                </li>
                <li <?php  if(isset($pagina)) { if($pagina == 'home') { echo 'class="active"'; } }?>>
                        <a href="<?php echo base_url($this->config->item('ws'));?>"><?php echo _lang('menu_home');?></a>
                </li>
                <li <?php if(isset($pagina)) { if($pagina == 'problema') { echo 'class="active"'; } }?>>
                        <a href="<?php echo base_url($this->config->item('ws').'problema');?>"><?php echo _lang('menu_problemas');?></a>
                </li>
                <li <?php if(isset($pagina)) { if($pagina == 'recomendacao') { echo 'class="active"'; } }?>>
                        <a href="<?php echo base_url($this->config->item('ws').'recomendacao');?>"><?php echo _lang('menu_recomendacoes');?></a>
                </li>
                <li <?php if(isset($pagina)) { if($pagina == 'submissao') { echo 'class="active"'; } }?>>
                        <a href="<?php echo base_url($this->config->item('ws').'submissao');?>"><?php echo _lang('menu_submissoes');?></a>
                </li>
                <li <?php if(isset($pagina)) { if($pagina == 'rank') { echo 'class="active"'; } }?>>
                        <a href="<?php echo base_url($this->config->item('ws').'rank');?>"><?php echo _lang('menu_rank');?></a>
                </li>
            </ul>
        </nav>
    </div>
</div>