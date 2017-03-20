$(document).ready(function() {
    $("#form_objeto_aprendizagem").validate({
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
            titulo: {
                required: true
            },
            materia: {
                required: true
            },
            identificador: {
                required: true
            },
            estilo_aprendizagem: {
                required: true
            },
            messages: {
            }
        }
    });
});


