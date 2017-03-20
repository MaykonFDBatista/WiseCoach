$(document).ready(function() {

var acoes_badge = {
    init : function(){
        acoes_badge.salva_arquivo();
        acoes_badge.busca_parametros($("#regra_concessao").val());
        
        $("#regra_concessao").on('change', function () {
            acoes_badge.busca_parametros($(this).val());
        });
    },
    salva_arquivo : function(){

        $("#arquivo").on('change', function () {

            var formData = new FormData($('#form_badge')[0]);

            var url = $('#base_url').val() + '/badge/do_upload';

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (returndata) {
                    console.log(returndata);
                    if(returndata.error != undefined){
                        $('#msg').append($(returndata.error).text());
                        $('#msg').addClass('alert alert-error');
                        $('#msg').show();
                    }
                    else{
                        $('input[name="nome"]').val(returndata.file_name);
                    }
                },
                error: function(){
                    console.log("error in ajax form submission");
                }
            });

            return false;
        });
    },
    busca_parametros : function(regra){

        var url = $('#base_url').val() + '/badge/get_parametros_concessao/' + regra;

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {},
            cache: false,
            contentType: false,
            processData: false,
            success: function (parametros) {

                var div = $("#parametro_concessao").parent();
                var parametro = $("#parametro_concessao").val();
                $("#parametro_concessao").select2("destroy");
                $('#parametro_concessao').remove();

                if(parametros){

                    div.append($('<select name="parametro_concessao" id="parametro_concessao" class="spaan8"></select>'));

                    $.each(parametros, function (i, item) {
                        $('#parametro_concessao').append('<option value="' + i + '">' + item + '</option>');
                    });

                    $("#parametro_concessao").val(parametro);

                    $("#parametro_concessao").select2();
                }
                else {

                    div.append($('<input name="parametro_concessao" id="parametro_concessao"/>'));

                    $("#parametro_concessao").val(parametro);
                }
            },
            error: function(){
                console.log("error in ajax form submission");
            }
        });

        return false;
        
    }
};

acoes_badge.init();

});
