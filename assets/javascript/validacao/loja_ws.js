$(document).ready(function() {

    $(function() {
        valicacao.simple();
        valicacao.extended();
    });

    valicacao = {
        simple: function() {
            $("#form_loja").validate({
                onkeyup: false,
                    errorClass: 'error',
                    validClass: 'valid',
                    highlight: function(element) {
                        $(element).closest('.form-group').addClass("f-error");
                    },
                    unhighlight: function(element) {
                        $(element).closest('.form-group').removeClass("f-error");
                    },
                    errorPlacement: function(error, element) {
                        $(element).closest('.form-group').append(error);
                    },
                rules: {
                    'regras[]': {
                        required: true
                    },
                    'problema_id': {
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
});


