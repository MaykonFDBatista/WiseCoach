$(document).ready(function() {

    $("#form_cadastro").validate({
        rules: {
            nome: {
                required: true
            },
            senha: {
               // novo: true,
               required: true,
                minlength: 5
            },
            senha2: {
                required: true,
                minlength: 5,
                igual_a_nova_senha: true
            },
            email: {
                //required: true,
                email: true,
                verifica_email_doador_ws: true
            },
            
            messages: {
            }
        }
    });
    
    $("#form_redefinir_senha").validate({
        rules: {

            nova_senha: {
               // novo: true,
               required: true,
                minlength: 5
            },
            conf_senha: {
                required: true,
                minlength: 5,
                igual_a_nova_senha: true
            },
            email: {
                //required: true,
                email: true,
            },
            
            messages: {
            }
        }
    });
});
