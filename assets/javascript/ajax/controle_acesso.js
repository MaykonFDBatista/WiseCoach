/* 
 * Altera os checkbox da view de controle de acesso
 * 
 * @package   assets/javascript
 * @name      Controle_acesso
 * @author    Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 * @copyright Copyright (c) 2013, Tellks - Solucoes em tecnologia ltda
 * @since     31/07/2013
 */

$(document).ready(function() {

//    $('input[name="modulos[]"]').on('ifChecked', function(event) {
//
//        $('.' + this.id).iCheck('check');
//    });

    $('input[name="modulos[]"]').on('ifUnchecked', function(event) {

        $('.' + this.id).iCheck('uncheck');
    });
});