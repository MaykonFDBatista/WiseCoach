$(document).ready(function() {
    $("#form_edita_modulo").validate({
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
            mod_nome: {
                required: true
            },
            mod_ativo: {
                required: true
            },
            mod_ordem: {
                required: true
            },
            messages: {
            }
        }
    });
});


