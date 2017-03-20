
$(document).ready(function(){
    
    $('#redefinir_senha').click(function(){
                
        $('#load').show();

        var url = $("#base_url").val() + 'adm/ajax/requisitar_nova_senha';

        $("#resultado").load(url, {
            email: $("#usu_email").val()
        }, function() {
            $('#load').hide();
        });
    });
    
    $(function() {

        var form_wrapper = $('.login_box');
        form_wrapper.css({
            marginTop: (-(form_wrapper.height() / 2)),
            top: '50%'
        });

        $('.form_toggle').on('click', function(e) {
            var target = $(this).attr('href'),
                    target_height = $(target).actual('height');
            $(form_wrapper).css({
                'height': form_wrapper.height()
            });
            $(form_wrapper.find('form:visible')).fadeOut(400, function() {
                form_wrapper.stop().animate({
                    height: target_height,
                    marginTop: (-(target_height / 2))
                }, 500, function() {
                    $(target).fadeIn(400);
                    $(form_wrapper).css({
                        'height': ''
                    });
                });
            });
            e.preventDefault();
        });

        $('#login_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                email: {required: true, email: true},
                senha: {required: true, minlength: 5}
            },
            errorPlacement: function(error, element) {
                $(element).closest('div').append(error);
            }
        })
    });
    
    if($('#recaptcha_image').length){
     
        $('#recaptcha_image').width(235);
    }
    if($('#recaptcha_response_field').length){
     
    }
    
});
