$(document).ready(function() {

    $(function() {
        valicacao.simple();
        valicacao.extended();
    });

    valicacao = {
        simple: function() {
            $("#form_edita_usuario").validate({
                onkeyup: false,
                    errorClass: 'error',
                    validClass: 'valid',
                    highlight: function(element) {
                        if(!$(element).hasClass('icheck')) {
                            $(element).closest('div').addClass("f-error");
                        } else {
                            $(element).closest('div.formSep').addClass("f-error");
                        }
                    },
                    unhighlight: function(element) {
                        if(!$(element).hasClass('icheck')) {
                            $(element).closest('div').removeClass("f-error");
                        } else {
                            $(element).closest('div.formSep').removeClass("f-error");
                        }
                    },
                    errorPlacement: function(error, element) {
                        if(!$(element).hasClass('icheck')) {
                            $(element).closest('div').append(error);
                        } else {
                            $(element).closest('div.formSep').append(error);
                        }
                    },
                rules: {
                    usu_nome: {
                        required: true
                    },
                    usu_ativo: {
                        required: true
                    },
                    usu_senha: {
                        novo: true,
                        minlength: 5
                    },
                    usu_senha2: {
                        minlength: 5,
                        igual_a_nova_senha: true
                    },
                    usu_email: {
                        email: true,
                        required: true,
                        verifica_email: true
                    },
                    'usu_grupos[]': {
                        required: true
                    },
                    'dependente[]': {
                        required: true
                    },
                    'veiculo[][placa]': {
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


