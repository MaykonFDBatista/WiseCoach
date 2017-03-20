$(document).ready(function() {
    

    
    
    esconder = {
        init: function(){
            $( ".hide" ).on( "click", function() {
                $(this).parent().remove();
            });
        }   
    };
    
   $('#form_contato').submit(function(e) {
       //setamos para quando submeter não atualizar a pagina   
       e.preventDefault();
       if ($(this).valid()) {
           //o serialize retorna uma string pronta para ser enviada
           var valores = $(this).serialize();

           //iniciamos o ajax
           $.ajax({
               //definimos a url
               url: $(this).attr('action'),
               //definimos o tipo de requisição
               type: 'POST',
               //definimos o tipo de retorno
               dataType: 'json',
               //colocamos os valores a serem enviados
               data: valores,
               //antes de enviar ele alerta para esperar
               beforeSend: function() {
                   $(load).show();
                   $('.btn-submit').hide();
               },
               //colocamos o retorno na tela
               success: function(dados) {
                   $('#mp').html('');
                   //var mensagem = '<div class="' + dados['class'] + '">' + dados['mp'] + '<button type="button" class="close" data-dismiss="alert">×</button> </div>';
                   var mensagem = '<div class="' + dados['class'] + '">' + dados['mp'] + '</div>'
                   $('#mp').html(mensagem);
               },
               error: function(dados) {
                   $('#mp').html('');
                   //var mensagem = '<div class="alert alert-error">Erro ao enviar os dados<button type="button" class="close" data-dismiss="alert">×</button> </div>';
                   var mensagem = '<div class="' + dados['class'] + '">' + dados['mp'] + '</div>'
                   $('#mp').html(mensagem);
                   
               },
               complete: function(dados) {
                   //habilitar botão
                   $('.btn-submit').show();

                   $(load).hide();

                   $(":text").each(function() {
                       $(this).val("");
                   });

                   $("textarea").each(function() {
                       $(this).val("");
                   });
                   esconder.init();
                   //ver erros de banco e php
                   console.log(dados.responseText);
               }
           });
       }
   });
});