$(document).ready(function() {
    $("#form_badge").validate({
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
            descricao: {
                required: true
            },
            nome: {
                required: true
            },
            regra_concessao: {
                required: true
            },
            parametro_concessao: {
                required: true
            },
            messages: {
            }
        }
    });
});


