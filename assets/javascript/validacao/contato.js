$(document).ready(function() {

    $("#form_contato").validate({
        rules: {
            nome: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            mensagem: {
                required: true,
            },
            messages: {
            }
        }
    });
});
