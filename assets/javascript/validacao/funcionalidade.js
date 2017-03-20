$(document).ready(function() {

    $("#form_edita_funcionalidade").validate({
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
            fun_nome: {
                required: true
            },
            fun_modulo: {
                required: true
            },
            fun_acesso: {
                required: true
            },
            fun_url: {
                required: true
            },
            fun_ativo: {
                required: true
            },
            fun_ordem: {
                required: true
            },
            messages: {
            }
        }
    });
});
