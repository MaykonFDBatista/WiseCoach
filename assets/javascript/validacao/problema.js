$(document).ready(function() {

    $(function() {
        valicacao.simple();
        valicacao.extended();
    });

    valicacao = {
        simple: function() {
            $("#form_edita_problema").validate({
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
                    pro_nome: {
                        required: true
                    },
                    pro_ativo: {
                        required: true
                    },
                    pro_descricao: {
                        required: true
                    },
                    pro_entrada: {
                        required: true
                    },
                    pro_saida: {
                        required: true
                    },
                    pro_exemplo_entrada: {
                        required: true
                    },
                    pro_exemplo_saida: {
                        required: true
                    },
                    pro_timelimit:  {
                        positiveNumber: true
                    },
                    pro_nivel: {
                        required: true
                    },
                    pro_categoria: {
                        required: true
                    },
                    'pro_materias[]': {
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


