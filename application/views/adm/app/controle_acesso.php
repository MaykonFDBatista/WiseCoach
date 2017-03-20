<?php if (!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * Permite a alteracao das funcionalidades e modulos que um app tem acesso
 * e seta as permissoes de acesso dos grupos de usuario do app
 * 
 * @package   views/adm/app
 * @name      Controle_acesso
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     08/07/2013
 * 
 */
echo form_open($url, array('class' => 'form-horizontal', 'id' => 'form_funcionalidades_app'));

echo form_hidden('app_id', (isset($app->id) ? $app->id : ''));
?>
    
<!-- General form elements -->  
    <?php 
    // Mostra os dados do app sendo gerenciado
    $this->load->view($this->config->item('admin') . 'app/dados_app');
    ?>
<div class="box_a">
    <div class="box_a_heading">
        <h3><?php echo _lang('menu_modulos'); ?></h3>
    </div>

    <div class="box_a_content cnt_a">

        <!-- Accordion -->
        <div class="accordion" id="sidebar-accordion">

            <!-- Camada 1 do accordion. Armazena os checkbox dos modulos -->

            <?php
            // Se carregou os modulos
            if (isset($modulos)) {

                // Itera sobre eles criando a primeira camada do accordion e 
                // mostra os checkbox dos modulos
                foreach ($modulos as $modulo) {
                    ?>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <?php
                            $checked = FALSE;
                            // Se ha permissoes de acesso
                            if (isset($permissoes)) {
                                // Verifica se ha permissao de acesso a alguma funcionalidade
                                // do modulo
                                if (isset($funcionalidades)) {

                                    for ($i = 0; $i < sizeof($permissoes); $i++) {

                                        foreach ($funcionalidades as $funcionalidade) {
                                            // Se ha permissao de acesso a ao menos uma funcionalidade 
                                            // do modulo entao tem acesso ao modulo. 
                                            if ($funcionalidade->modulo_id == $modulo->id) {
                                                if ($permissoes[$i]->funcionalidade_id == $funcionalidade->id) {

                                                    $checked = TRUE;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            
                            // Guarda o id do modulo para relacionar com os checkboxes das funcionalidades
                            // do modulo
                            $modulo_id = 'm_' . $modulo->id;
                            
                            $atributos = array(
                                'name' => 'modulos[]',
                                'id' => $modulo_id,
                                'value' => $modulo->id,
                                'class' => 'icheck',
                                'checked' => $checked
                            );
                            ?>
                            <div style="float:left; padding-top: 7px;">
                                <?php
                                // helper que monta o checkbox
                                echo nbs() . form_checkbox($atributos) . nbs();
                                ?> 
                            </div>
                            <!-- Link para mostrar a camada 2 do accordion--> 
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#sidebar-accordion" href="#<?php echo $modulo->nome; ?>">
                                <?php echo _lang($modulo->nome); ?>
                            </a>

                        </div>
                        <!-- Camada 2 do accordion. Agrupa os checkbox das funcionalidades do modulo da camada acima -->
                        <div id="<?php echo $modulo->nome; ?>" class="accordion-body collapse">

                            <div class="accordion-inners">
                                
                                <div class="span1">&nbsp;</div>
                                <div class="span11">
                                    <label><strong><?php echo _lang('menu_funcionalidades'); ?></strong></label>
                                <?php
                                
                                if (isset($funcionalidades)) {
                                ?>
                                <div class="accordion" id="f_<?php echo $modulo->nome; ?>">

                                    <?php 
                                    // Itera sobre as funcionalidades criando os checkbox da segunda camada
                                    foreach ($funcionalidades as $funcionalidade) {
                                        $checked = FALSE;
                                        // Cria os checkbox apenas das funcionalidades do modulo da camada acima
                                        if ($funcionalidade->modulo_id == $modulo->id) {
                                    ?>
                                            <div class="accordion-group">
                                                <div class="accordion-heading" style="padding: 5px 0px 1px 0px">

                                                <?php
                                                if (isset($permissoes)) {

                                                    for ($i = 0; $i < sizeof($permissoes); $i++) {
                                                        // Verifica se ha permissao de acesso a funcionalidade
                                                        if ($permissoes[$i]->funcionalidade_id == $funcionalidade->id) {

                                                            $checked = TRUE;
                                                            break;
                                                        }
                                                    }
                                                }
                                                // O nome do grupo de checkbox e concatenado com o id do modulo para que seja gerado 
                                                // no $_POST variaveis separadas agrupando as funcionalidades por modulo
                                                $atributos = array(
                                                    'name' => 'funcionalidades' . $modulo->id . '[]',
                                                    'id' => 'f_' . $funcionalidade->id,
                                                    'value' => $funcionalidade->id,
                                                    'class' => 'icheck ' . $modulo_id,
                                                    'checked' => $checked
                                                );
                                                ?>
                                                    <div style="float: left;">
                                                        <?php
                                                        // helper que monta o checkbox
                                                        echo nbs() . form_checkbox($atributos) . nbs();
                                                        ?> 
                                                    </div>
                                                    <label style="padding-top: 2px;">
                                                        <!-- Link para mostrar a camada 3 do accordion --> 
                                                        <a class="accordion-link" data-toggle="collapse" data-parent="#f_<?php echo $modulo->nome; ?>" href="#<?php echo $funcionalidade->id; ?>">
                                                            <?php echo _lang($funcionalidade->nome); ?><i class="icon-chevron-down pull-right">&nbsp;&nbsp;</i>
                                                        </a>
                                                    </label>
                                                </div>
                                             <!-- Camada 3 do accordion. Agrupa os checkbox dos grupos com acesso a funcionalidade da camada -->
                                             
                                             <div id="<?php echo $funcionalidade->id; ?>" class="accordion-body collapse">
                                                 
                                                 <div class="accordion-inner">
                                                     
                                                     <div class="span1">&nbsp;</div>
                                                     <div class="span10">
                                                         <label><strong><?php echo _lang('form_grupos_acesso'); ?></strong></label>
                                                         <?php
                                                            if (isset($grupos)) {

                                                                foreach ($grupos as $grupo) {

                                                                    $checked = FALSE;

                                                                    if (isset($permissoes)) {

                                                                        for ($i = 0; $i < sizeof($permissoes); $i++) {
                                                                            // Verifica se o grupo tem acesso a funcionalidade
                                                                            if (($permissoes[$i]->grupo_id == $grupo->id) && ($permissoes[$i]->funcionalidade_id == $funcionalidade->id)) {

                                                                                $checked = TRUE;
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                    // O nome do grupo de checkbox e concatenado com o id da funcionalidade
                                                                    // para que seja gerado no $_POST uma variavel grupo para cada funcionalidade
                                                                    $atributos = array(
                                                                        'name' => 'grupos' . $funcionalidade->id . '[]',
                                                                        'id' => 'g_' . $funcionalidade->id . $grupo->id,
                                                                        'value' => $grupo->id,
                                                                        'class' => 'icheck ' . $modulo_id,
                                                                        'checked' => $checked
                                                                    );
                                                                    ?>
                                                                    <div style="float:left;">
                                                                        <?php
                                                                        // helper que monta o checkbox
                                                                        echo form_checkbox($atributos) . nbs();
                                                                        ?>
                                                                    </div>
                                                                    <div style="padding-top: 3px;">
                                                                         <label> <?php echo _lang($grupo->nome); ?></label>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                          ?>
                                                     </div>
                                                     
                                                 </div>
                                             </div>
                                            </div>
                                    <?php 
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                                <?php 
                                }
                                ?>
                            </div>
                        </div>
                        <!--Fim da camada 2-->
                    </div>
                    <!--Fim da camada 1-->
                    <?php
                }
            }
            ?>        
        </div>
        <!-- Fim do Accordion -->

        <div>
            <button type="submit" class="btn btn-primary"><?php echo _lang('form_salvar'); ?></button>
            <button type="button" class="btn btn-danger" onClick="window.location='<?php echo base_url() . $url_cancelar; ?>'"><?php echo _lang('form_cancelar'); ?></button>
            <?php
            if ($this->session->flashdata('proximo')) {
            ?>
            <button type="submit" name="proximo" value="1" class="btn btn-info"><?php echo _lang('form_proximo_passo'); ?></button>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
echo form_close();
?>