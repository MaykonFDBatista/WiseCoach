//  function logar_facebook() {
//        FB.login(function(response){
//        console.log(response);
//      }), {scope: 'public_profile,email,user_birthday,user_photos'};
//      checarStatusLogin();
//    }
//    
//      function deslogar_facebook() {
//        FB.logout(function(response){
//        console.log(response);
//      });
//      checarStatusLogin();
//    }

    function get_dados_sessao(){
            
        var url = $("#base_url").val();

        url += 'ws/login/get_dados_sessao'; 

        var resultado = {};

        $.ajax({
              //definimos a url
               url: url,
               async: false,
               //definimos o tipo de requisição
               type: 'POST',
               //definimos o tipo de retorno
               dataType: 'json',
               //colocamos os valores a serem enviados
               data: '',
               //antes de enviar ele alerta para esperar
               success: function(dados) {
                   
                   
                   resultado = dados;
                   
               }

        });

        return resultado;

    }
    
    function redirecionar(url){
                   
            var login = checarStatusLogin();
            
            if(login){   
                window.location.assign(url);
                
            }
            else{
                $("#abrir_modal").trigger("click");

            }
                   

        
    }
    
    function login_facebook(){
        var resultado = false;
        FB.api('/me', function(response) {
            
            var url = $("#base_url").val();
        
            url += 'ws/login/login_facebook'; 
        
            
            $.ajax({
                //definimos a url
               url: url,
               async: false,
               //definimos o tipo de requisição
               type: 'POST',
               //definimos o tipo de retorno
               dataType: 'json',
               //colocamos os valores a serem enviados
               data: 'nome=' +response.name +
                 '&email=' +response.email +
                 //'&data_nascimento=' + response.birthday +
                 '&id_facebook=' + response.id,
               //antes de enviar ele alerta para esperar
                beforeSend: function() {
                    //$(load4).show();
                    $('.btn-facebook').hide();
                },
                //colocamos o retorno na tela
                success: function(dados){
                      //alert(data);
                      var mensagem = '<div class="' + dados['class'] + ' div_msg4">' + dados['mp'] + '</div>';
                      $('.msg4').html(mensagem);
                      $('#login_ws').hide('slow');
                      $('#login_ws_entrar').hide();
                      $('#login_ws_sair').show();
                      var imagem = '<img src="http://graph.facebook.com/' + response.id + '/picture?width=100&height=100">';
                      $('#login_facebook_imagem').html(imagem);
                      
                      resultado = true;
//                    if(data == '0') {
//                        resultado = false;
//                    }
//                    else {
//                        resultado = true;
//                    }
                },
               error: function(dados) {
                   //$('#mp4').html('');
                   //var mensagem = '<div class="alert alert-error">Erro ao enviar os dados<button type="button" class="close" data-dismiss="alert">×</button> </div>';
                   var mensagem = '<div class="' + dados['class'] + ' div_msg4">' + dados['mp'] + '</div>';
                   
                   $('.msg4').html(mensagem);
                   
               },
               complete: function(dados) {
                   //habilitar botão
                   $('.btn-facebook').show();

                   //$(load4).hide();
                   
                   $('.div_msg4').delay('3000').hide('slow');
                   
                   //ver erros de banco e php
                   console.log(dados.responseText);
               }

            });
            
            
        });
        return resultado;
    }
    
    function logout_ws(){
            
        var url = $("#base_url").val();

        url += 'ws/login/logout'; 

        var resultado = false;

        $.ajax({
              //definimos a url
               url: url,
               //definimos o tipo de requisição
               type: 'POST',
               //definimos o tipo de retorno
               dataType: 'json',
               //colocamos os valores a serem enviados
               data: '',
               //antes de enviar ele alerta para esperar
            beforeSend: function() {
                $(load3).show();
                $('.btn-sair').hide();
            },
            //colocamos o retorno na tela
            success: function(dados){
                var mensagem = '<div class="' + dados['class'] + ' div_msg2">' + dados['mp'] + '</div>';
                $('.msg2').html(mensagem);
                $('#login_ws_entrar').show('slow');
                $('#login_ws_sair').hide('slow');
                $('#login_facebook').show('slow');
                $('#login_ws_imagem').html('');
                $('#status_ws').html('');
                div = '.div_msg2';

                        
            },
               error: function(dados) {
                   //$('#mp2').html('');
                   //var mensagem = '<div class="alert alert-error">Erro ao enviar os dados<button type="button" class="close" data-dismiss="alert">×</button> </div>';
                   var mensagem = '<div class="' + dados['class'] + ' div_msg3">' + dados['mp'] + '</div>';
                   
                   $('.msg3').html(mensagem);
                   
                   div = '.div_msg3';
                   
               },
               complete: function(dados) {
                   //habilitar botão
                   $('.btn-sair').show();

                   $(load3).hide();
                   
                   $(div).delay('3000').hide('slow');
                   
                   //ver erros de banco e php
                   console.log(dados.responseText);
               }

        });

        return resultado;

    }
    
    function logout_facebook(){
            
        var url = $("#base_url").val();

        url += 'ws/login/logout'; 

        var resultado = false;

        $.ajax({
              //definimos a url
               url: url,
               async: false,
               //definimos o tipo de requisição
               type: 'POST',
               //definimos o tipo de retorno
               dataType: 'json',
               //colocamos os valores a serem enviados
               data: '',
               //antes de enviar ele alerta para esperar
            beforeSend: function() {
               // $(load4).show();
                $('.btn-facebook').hide();
            },
            //colocamos o retorno na tela
            success: function(dados){
                var mensagem = '<div class="' + dados['class'] + ' div_msg4">' + dados['mp'] + '</div>';
                $('.msg4').html(mensagem);
                $('#login_ws').show('slow');
                $('#login_ws_sair').hide();
                $('#login_ws_entrar').show();
                $('#login_facebook').show('slow');
                $('#login_facebook_imagem').html('');
                $('#status').html('');
                resultado = true;
            },
               error: function(dados) {
                   //$('#mp2').html('');
                   //var mensagem = '<div class="alert alert-error">Erro ao enviar os dados<button type="button" class="close" data-dismiss="alert">×</button> </div>';
                   var mensagem = '<div class="' + dados['class'] + ' div_msg4">' + dados['mp'] + '</div>';
                   
                   $('.msg4').html(mensagem);
                   
               },
               complete: function(dados) {
                   //habilitar botão
                   $('.btn-facebook').show();

                   //$(load4).hide();
                   
                   $('.div_msg4').delay('3000').hide('slow');
                   
                   //ver erros de banco e php
                   console.log(dados.responseText);
               }

        });

        return resultado;

    }
    
  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checarStatusLogin() {
    
    var dados = get_dados_sessao();
    
    var resultado2;
      
    var resultado = false;
    
    if(dados["id"]){
        resultado = true;
    }
    
    FB.getLoginStatus(function(response) {
      imprimir(response);
      if (response.status === 'connected') {
          
          if(!dados["id"]){
            resultado2 = login_facebook();
            if(resultado2){
                resultado = true;
            }
          }

      }
      else{
          if(dados["id_facebook"]){
            resultado2 = logout_facebook();
            if(resultado2){
                resultado = false;
            }
          }
          
      }
    });
    
    return resultado;
  }
  
  
  // This is called with the results from from FB.getLoginStatus().
  function imprimir(response) {
      
    //console.log('imprimir');
    //console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      teste();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
//      document.getElementById('status').innerHTML = 'Please log ' +
//        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
//      document.getElementById('status').innerHTML = 'Please log ' +
//        'into Facebook.';
    }
  }

 

// Here we run a very simple test of the Graph API after login is
  // successful.  See imprimir() for when this call is made.
  function teste() {
    console.log('Bem-vindo! Buscando suas informações.... ');
    FB.api('/me', function(response) {
      console.log(JSON.stringify(response));
      console.log('Login bem-sucedido para: ' + response.name);
      document.getElementById('status').innerHTML =
        ''+response.name;
        //'Obrigado por logar, ' + response.name + '!';
    });
  }


 function testar() {
        

        FB.api('/me', function(response) {
          alert('Nome Usuário: ' + response.name);

        });
      }
      
window.onload = function(){
	checarStatusLogin();
}



$(document).ready(function() {
    
    

    mascara_data = {
        init: function() {
            $(".data").inputmask('dd/mm/yyyy', {"placeholder": "__/__/____"});
        }
    };

    mascara_data.init();
    
    mascara_telefone = {
        init: function() {
            $(".telefone").inputmask('(99)9999-9999[9]', {"placeholder": "(__)____-_____"});
        }
    };

    mascara_telefone.init();
    
     esconder = {
        init: function(){
            $( ".hide" ).on( "click", function() {
                $(this).parent().remove();
            });
        }   
    };
    
    //$('#userfile').live('change',function(){
        //$('#visualizar').html('<img src')
            
    //});
    
    $('#botao_redefinicao_senha').on('click', function() {
        var email = $('#email_redefinicao_senha').val();
        var url = $("#base_url").val();
        
        url += 'ws/login/enviar_redefinicao_senha/'+email; 
        
        window.location.assign(url);
        
    });
   
//    
//    $('#nova_senha').on('change', function() {
//
//        
//    });

    $("#import").click(function() {
        $("#browser").trigger("click");
        $('#browser').change(function() {
            var str = $("#browser").val();
            str = str.replace(":\\fakepath\\", "");
            str = str.substring(1,str.length);

            $("#import_text").html(str);
        });
    });

    $('#form_login').submit(function(e) {
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
                   $(load2).show();
                   $('.btn-submit2').hide();
               },
               //colocamos o retorno na tela
               success: function(dados) {

                   //$('#mp').html('');
                   //var mensagem = '<div class="' + dados['class'] + '">' + dados['mp'] + '<button type="button" class="close" data-dismiss="alert">×</button> </div>';
                   if(dados['user']){
                        var mensagem = '<div class="' + dados['class'] + ' div_msg3">' + dados['mp'] + '</div>'
                        $('.msg3').html(mensagem);
                        $('#login_ws_entrar').hide('slow');
                        $('#login_ws_sair').show('slow');
                        $('#login_facebook').hide('slow');
                        if(dados['url']){
                            var url = $("#base_url").val();
                            url += dados['url']; 
                            var imagem = '<img src=' + url + ' alt="" style="max-height: 100px; max-width: 100px;">';
                            $('#login_ws_imagem').html(imagem);
                        }
                        
                        $('#status_ws').html(dados['status']);
                        div = '.div_msg3';
                        
                   }
                   else{
                       
                       var mensagem = '<div class="' + dados['class'] + ' div_msg2">' + dados['mp'] + '</div>'
                        $('.msg2').html(mensagem);
                        div = '.div_msg2';
                   }
               },
               error: function(dados) {

                   //$('#mp2').html('');
                   //var mensagem = '<div class="alert alert-error">Erro ao enviar os dados<button type="button" class="close" data-dismiss="alert">×</button> </div>';
                   var mensagem = '<div class="' + dados['class'] + ' '+ dados['div'] +'">' + dados['mp'] + '</div>';
                   
                   $('.msg2').html(mensagem);
                   div = '.div_msg2';
                   
               },
               complete: function(dados) {
                   //habilitar botão
                   $('.btn-submit2').show();

                   $(load2).hide();

                   $(":text").each(function() {
                       $(this).val("");
                   });
                   
                   $(":password").each(function() {
                       $(this).val("");
                   });

                   $("textarea").each(function() {
                       $(this).val("");
                   });
                   esconder.init();
                   
                   $(div).delay('3000').hide('slow');
                   
                   //ver erros de banco e php
                   console.log(dados.responseText);
               }
           });
       }
   });
    
   $('#form_cadastro').submit(function(e) {
       //setamos para quando submeter não atualizar a pagina   
       e.preventDefault();
       if ($(this).valid()) {
           //o serialize retorna uma string pronta para ser enviada
           var valores = $(this).serialize();
           
           console.log(valores);

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
                   //$('#mp').html('');
                   //var mensagem = '<div class="' + dados['class'] + '">' + dados['mp'] + '<button type="button" class="close" data-dismiss="alert">×</button> </div>';

                   if(dados['id']){
                        var url_imagem = $('#form_imagem').attr('action')+'/'+dados['id'];

                        $('#form_imagem').ajaxForm({
                            //definimos a url
                            url: url_imagem,
                            //definimos o tipo de requisição
                            type: 'POST',
                            //definimos o tipo de retorno
                            dataType: 'json',
                            //antes de enviar ele alerta para esperar
                            beforeSend: function() {

                            },
                            //colocamos o retorno na tela
                            success: function(dados) {
                                var mensagem = '<div class="' + dados['class'] + ' div_msg">' + dados['mp'] + '</div>'
                                $('.msg').html(mensagem);
                            },
                            error: function(dados) {
                                var mensagem = '<div class="' + dados['class'] + ' div_msg">' + dados['mp'] + '</div>'
                                $('.msg').html(mensagem);

                            },
                            complete: function(dados) {
                                //habilitar botão
                                $('.btn-submit').show();

                                $(load).hide();

                                $(":text").each(function() {
                                    $(this).val("");
                                });

                                $(":password").each(function() {
                                    $(this).val("");
                                });

                                $(":file").each(function() {
                                    $(this).val("");
                                });

                                $("textarea").each(function() {
                                    $(this).val("");
                                });
                                
                                $("#import_text").html('');
                                
                                esconder.init();

                                $('.div_msg').delay('3000').hide('slow');
                                console.log(dados.responseText);
                            }

                        }).submit();
                   }
                   else{
                   
                        var mensagem = '<div class="' + dados['class'] + ' div_msg">' + dados['mp'] + '</div>'
                        $('.msg').html(mensagem);
                   }
               },
               error: function(dados) {
                   //$('#mp').html('');
                   //var mensagem = '<div class="alert alert-error">Erro ao enviar os dados<button type="button" class="close" data-dismiss="alert">×</button> </div>';
                   var mensagem = '<div class="' + dados['class'] + ' div_msg">' + dados['mp'] + '</div>'
                   $('.msg').html(mensagem);
                   
               },
               complete: function(dados) {
                   
                   
                   //ver erros de banco e php
                   console.log(dados.responseText);
               }
           });
       }
   });
   
});
