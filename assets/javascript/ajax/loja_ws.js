$(document).ready(function() {
    var acoes_loja = {
        inicio: function(){
           acoes_loja.radio_regras();
        
            $("input[name='regras[]']").on('ifChecked', function () {
                acoes_loja.busca_problemas($(this).val());
            });
        },
        radio_regras: function(){
            if($('.icheck').length){
               $(document).find('.icheck').each(function() {
                   var cor = $(this).data('icheck-color');

                   $(this).iCheck({
                        checkboxClass: 'icheckbox_square-' + cor,
                        radioClass: 'iradio_square-' + cor,
                        increaseArea: '20%' // optional
                    }); 
                });
            }
        },
        busca_problemas : function(regra){

           var url = $('#base_url').val() + 'ws/loja/busca_problemas/' + regra;
           
           $.ajax({
               url: url,
               type: 'POST',
               dataType: 'json',
               data: {},
               cache: false,
               contentType: false,
               processData: false,
               success: function (dados) {
                    
                   $("select[name='problema_id']").children().remove();

                    $.each(dados, function (i, item) {
                        
                        $("select[name='problema_id']").append('<option value="' + item.id + '">' + item.nome + '</option>');
                    });

               },
               error: function(){
                   console.log("error in ajax form submission");
               }
           });

           return false;  
       }
    };
    
    acoes_loja.inicio();
});


