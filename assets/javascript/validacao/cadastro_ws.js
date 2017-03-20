$(document).ready(function() {

    $(function() {
        valicacao.simple();
        valicacao.extended();
    });

    valicacao = {
        simple: function() {
            $("#form_cadastro_competidor").validate({
                onkeyup: false,
                    errorClass: 'error',
                    validClass: 'valid',
                    highlight: function(element) {
                        if(!$(element).hasClass('icheck')) {
                            $(element).closest('div').addClass("f-error");
                        } else {
                            $(element).closest('div.span3').addClass("f-error");
                        }
                    },
                    unhighlight: function(element) {
                        if(!$(element).hasClass('icheck')) {
                            $(element).closest('div').removeClass("f-error");
                        } else {
                            $(element).closest('div.span3').removeClass("f-error");
                        }
                    },
                    errorPlacement: function(error, element) {
                        if(!$(element).hasClass('icheck')) {
                            $(element).closest('div').append(error);
                        } else {
                            $(element).closest('div.span3').append(error);
                        }
                    },
                rules: {
                    com_nome: {
                        required: true
                    },
                    com_ativo: {
                        required: true
                    },
                    com_senha: {
                        novo: true,
                        required: true,
                        minlength: 5
                    },
                    com_senha2: {
                        minlength: 5,
                        required: true,
                        igual_a_nova_senha: true
                    },
                    com_email: {
                        email: true,
                        required: true,
                        verifica_email_competidor_ws: true
                    },
                    com_nivel: {
                        required: true
                    },
                    'com_categorias[]': {
                        required: true
                    },
    
                    'com_materias[]': {
                        required: true
                    },
                    messages: {
                    }
                }
            });
        },
        extended: function() {
             if($('.icheck').length) {
                $('.icheck').iCheck({
                    checkboxClass: 'icheckbox_square',
                    radioClass: 'iradio_square'
                });
                $('.icheck').on('ifChanged', function(event){
                    $('.icheck').valid();
                });
            }

        }
    };
});


