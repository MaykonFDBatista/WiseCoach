$(document).ready(function() {
    $("#minha_conta").validate({
        onkeyup: false,
        errorClass: 'error',
        validClass: 'valid',
        highlight: function(element) {
            $(element).closest('div').addClass("f-error");
        },
        unhighlight: function(element) {
            $(element).closest('div').removeClass("f-error");
        },
        errorPlacement: function(error, element) {
            $(element).closest('div').append(error);
        },
        rules: {
            senha_anterior: {
                required: false
            },
            nova_senha: {
                minlength: 5
            },
            nova_senha2: {
                igual_a_nova_senha: true
            },
            usu_nome:{
              required: true  
            },
            usu_email: {
                email: true,
                required: true,
                verifica_email: true
            },
            messages: {
            }
        }
    });
});


