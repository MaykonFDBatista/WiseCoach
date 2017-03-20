$(document).ready(function() {
    $("#form_edita_site").validate({
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
            site_titulo: {
                required: true
            },
            site_descricao: {
                required: true
            },
            site_palavras_chave : {
              required : true  
            },
            site_email : {
              required : true,
              email : true
            },
            messages: {
            }
        }
    });
});

