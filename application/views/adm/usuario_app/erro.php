<?php if(!defined('BASEPATH')) exit('Sem permissao de acesso direto ao Script.');
/**
 * View de exibição dos erros de importação
 * 
 * @package   Views/condomino
 * @name      erro
 * @author    Claudia dos Reis Silva <claudia.silva@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     12/08/2013
 */

echo '<div class="alert alert-error">' . _lang('msg_import-error') . "<button type='button' class='close' data-dismiss='alert'>×</button> </div>";

?>
    
<div class="box_a">
    <div class="box_a_heading">
        <h3>&nbsp;</h3>
    </div>


<div class="box_a_content">
    
<?php
    // Itera sobre os usuarios retornados e gera uma tabela HTML
    $this->table->set_heading(_lang('form_nome'), _lang('form_email'));

    foreach ($erros as $usuario) { 
        
        $this->table->add_row (
                
                $usuario['nome'],
                $usuario['email']
        );
    }

    // Seta o template da tabela
    $tmpl = array('table_open' => '<table class="footable table table-striped">');
    $this->table->set_template($tmpl);

    //Gera uma tabela Html com os dados
    echo $this->table->generate();
    
    if (sizeof($erros) < 1) {
        
        $this->load->view('nenhum_registro');
    }
?>
    <table class="footable table">
        <tfoot class="footable-pagination">
            <tr>
                <td colspan="2">
                    <div class="pagination">
                        <a href="<?php echo base_url() . $url_cancelar; ?>" class="btn btn-link"><?php echo _lang('form_voltar'); ?></a>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
</div>

