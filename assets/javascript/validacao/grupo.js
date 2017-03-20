$(document).ready(function() {
    $("#form_edita_grupo").validate({
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
            gru_nome: {
                required: true
            },
            gru_ativo: {
                required: true
            },
            gru_acesso: {
                required: true
            },
            messages: {
            }
        }
    });
});

