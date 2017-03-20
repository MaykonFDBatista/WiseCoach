<?php
if (!defined('BASEPATH'))
    exit('Sem permissao de acesso direto ao Script.');

/**
 * View Cabecalho
 * 
 * @package   templates/tellknologia
 * @name      Cabecalho
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     19/06/2013
 * 
 */
?>

<div id="mobileNav" class="pull-left"></div>
<span id="menu-mobile"><?php echo _lang('menu_mobile'); ?></span>
<input type="hidden" id="base_url" value="<?php echo base_url($this->config->item('admin')) ?>">
<ul class="nav nav_right pull-right">
    <li class="dropdown dropdown-right">

        <?php
        
        if ($this->session->userdata('login_admin')) {
            $foto = _verifica_extensao($this->config->item('url_arquivos_admin_usuarios') . $this->session->userdata('usuario_id'));
            $foto_default = _verifica_extensao($this->config->item('url_arquivos_default') . 'user_default');
            if($foto){
                $url_foto = base_url($foto);
            }
            else if($foto_default){
                $url_foto = base_url($foto_default);
            }
            else{
                $url_foto = 'http://placehold.it/22x22&amp;text=Foto';
            }
            echo '<a data-toggle="dropdown" href="#">
                <img src="' . $url_foto . '" alt="" style="height: 22px; width: 22px;"/>
                &nbsp;<span>' . $this->session->userdata('usuario') . '&nbsp;<b class="caret"></b></span>
              </a>
              <ul class="dropdown-menu">
                 <li><a href="' . base_url($this->config->item('admin') . 'sistema/minha_conta') . '" title=""><i class="icon-user"></i>' . _lang('menu_minha_conta') . '</a></li>
                 <li><a href="' . base_url($this->config->item('admin') . 'logout') . '" title=""><i class="icon-remove"></i>' . _lang('menu_sair') . '</a></li>
              </ul>';
        } else if (isset($sis_desativado)) {
            ?>
            <!--<ul class="dropdown-menu">-->
            <?php
            if (!$this->session->userdata('login_admin'))
                echo '<a href="' . base_url($this->config->item('admin') . 'login/login_offline') . '" title="">' . _lang('form_entrar') . '</a>';
            ?>
            <!--</ul>-->
            <?php
        }
        ?>
    </li>
    <!--<li class="divider-vertical"></li>-->
</ul>
<!--<ul class="nav nav_right pull-right" style="margin-right: 8px">
    <li class="dropdown dropdown-right">

        <?php 
//        if ($this->session->userdata('login_admin')) {
//
//            echo '<a data-toggle="dropdown" href="#">
//                &nbsp;<span>' . _lang('menu_suporte') . '&nbsp;<b class="caret"></b></span>
//              </a>
//              <ul class="dropdown-menu">
//              <li><a href="http://tellks.zendesk.com" title="" target="_blank"><i class="elusive-icon-adult"></i>' . nbs(3) . _lang('menu_central_suporte') . '</a></li>
//              <li><a href="http://tellks.zendesk.com/hc/pt-br/requests/new" title="" target="_blank"><i class="elusive-icon-cloud"></i>' . nbs(3) . _lang('menu_abrir_chamado') . '</a></li>';
            ?>
        <li><a href="http://tellks.com.br/chat" onclick="window.open(this.href, 'targetWindow', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,');
                return false;"><i class="elusive-icon-comment"></i><?php // echo nbs(3) . _lang('menu_chat') ?></a></li>
               <?php
//               echo '
//              <li><a href="#" title=""><i class="elusive-icon-phone"></i>' . nbs(3) . _lang('menu_telefone_tellks') . '</a></li>
//              </ul>';
//           }
           ?>
</li>
<li class="divider-vertical"></li>
</ul>-->


<ul class="nav nav_right pull-right" style="margin-right: 10px;">
    <li class="dropdown dropdown-right">
        <a href="<?php echo base_url('ws'); ?>" target="_blank">
            <span><?php echo _lang('msg_acessar_website'); ?></span>&nbsp;&nbsp;<i class="elusive-icon-share-alt"></i>
        </a>
    </li>
    <li class="divider-vertical"></li>
</ul>

