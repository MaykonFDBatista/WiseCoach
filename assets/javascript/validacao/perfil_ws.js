$(document).ready(function() {

    $(function() {
        valicacao.simple();
        valicacao.extended();
        
        valicacao_form_estilo_aprendizagem.simple();
        valicacao_form_estilo_aprendizagem.extended();
    });

    valicacao = {
        simple: function() {
            $("#form_perfil").validate({
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
                    com_nome: {
                        required: true
                    },
                    com_ativo: {
                        required: true
                    },
                    com_senha: {
                        novo: true,
                        minlength: 5
                    },
                    com_senha2: {
                        minlength: 5,
                        igual_a_nova_senha: true
                    },
                    com_email: {
                        email: true,
                        required: true,
                        verifica_email: true
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

        }
    };
    
    valicacao_form_estilo_aprendizagem = {
        extended: function() {
            $("#form_estilo_aprendizagem").validate({
                onkeyup: false,
                errorClass: 'error',
                validClass: 'valid',
                errorElement: "label",
                highlight: function(element) {
                },
                unhighlight: function(element) {
                },
                errorPlacement: function(error, element) {
                    $(element).closest('.checkbox').append(error);
                },
                rules: {
                    'form_estilo_aprendizagem_questao_1': {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_2: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_3: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_4: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_5: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_6: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_7: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_8: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_9: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_10: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_11: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_12: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_13: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_14: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_15: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_16: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_17: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_18: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_19: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_20: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_21: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_22: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_23: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_24: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_25: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_26: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_27: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_28: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_29: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_30: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_31: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_32: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_33: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_34: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_35: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_36: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_37: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_38: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_39: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_40: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_41: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_42: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_43: {
                        required: true
                    },
                    form_estilo_aprendizagem_questao_44: {
                        required: true
                    },
                    ignore: ':hidden',
                    messages: {
                    }
                }
            });
        },
        simple: function() {
        }
    };
});


