$(document).ready(function() {
    $("#form_loja").validate({
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
            pontos: {
                required: true
            },
            messages: {
            }
        }
    });
});


