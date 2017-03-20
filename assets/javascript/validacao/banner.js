$(document).ready(function() {
    
    jQuery.validator.addMethod("verifica_upload", function(value, element) {
       
       if($("input[name='id']").size() === 0  && value == '') return false;
       
       else return true; 
       
    },required);
    
    $("#form_edita_banner").validate({
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
            app_id:{
                required: true
            },
            userfile: {
                verifica_upload: true
            },
            ativo: {
                required: true
            },
            ordem:{
                required: true
            },
            messages: {
            }
        }
    });
});

