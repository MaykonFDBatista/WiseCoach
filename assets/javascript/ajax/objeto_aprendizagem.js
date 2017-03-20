$(document).ready(function() {

var acoes_objeto_aprendizagem = {
    init : function(){
        acoes_objeto_aprendizagem.busca_materia();
        acoes_objeto_aprendizagem.busca_formato();
        acoes_objeto_aprendizagem.salva_arquivo();
        acoes_objeto_aprendizagem.busca_estilo_aprendizagem();
    },
    busca_materia : function(){
        $("#materia").select2({
            initSelection: function(element, callback) {
              var selecionados = jQuery.parseJSON($("#materia").val());
              $("#materia").val('');
              callback(selecionados);
            },
            multiple : true,
            ajax: {
              url: $('#base_url').val() + "/ajax/materia",
              dataType: 'json',
              method : 'POST',
              delay: 250,
              data: function (params) {
                return {
                  materia: params.term, // search term
                  page: params.page
                };
              },
              results: function (data, page) {

                var r = {
                  results: data
                };

                return r;
              },
              cache: true
            }
          });
    },
    busca_formato: function(){
        $(document).on('change','#tipo', function(){
    
            var tipo =  $('#tipo').val();

            $('#formato').hide();

            $.ajax({
                url: $('#base_url').val() + "/ajax/formato",
                dataType: 'json',
                method : 'POST',
                data: {
                  tipo: tipo
                },
                success: function (dados) {

                    var formato = $("#formato").data('val');
                    
                    $('#formato').find('option').remove();
                    
                    $.each(dados, function (i, item) {
                        var texto = item.extensao + ((item.mime_type != '') ? ' - ' + item.mime_type : '');
                        $('#formato').append('<option value="' + item.id + '">' + texto + '</option>');
                    });
                    $("#formato").select2("val", formato);
                    $('#formato').show();
                }
            });

        });
    },
    salva_arquivo : function(){

        $("#arquivo").on('change', function () {

            var formData = new FormData($('#form_objeto_aprendizagem')[0]);

            var url = $('#base_url').val() + '/objeto_aprendizagem/do_upload';

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (returndata) {

                    if(returndata.error != undefined){
                        $('#msg').append($(returndata.error).text());
                        $('#msg').addClass('alert alert-error');
                        $('#msg').show();
                    }
                    else {
                        $('input[name="identificador"]').val(returndata.file_name);
                        $('#titulo').val(returndata.orig_name.replace(returndata.file_ext,''));
                        $('#formato').data('val', returndata.formato_objeto_aprendizagem);
                        $('#tipo').val(returndata.tipo_objeto_aprendizagem).trigger("change");
                        var estilos = JSON.stringify(returndata.estilos_aprendizagem);
                        $("#estilo_aprendizagem").select2("destroy");
                        $("#estilo_aprendizagem").val(estilos);
                        acoes_objeto_aprendizagem.busca_estilo_aprendizagem();
                    }

                },
                error: function(){
                    console.log("error in ajax form submission");
                }
            });

            return false;
        });
    },
    busca_estilo_aprendizagem : function(){
        $("#estilo_aprendizagem").select2({
            initSelection: function(element, callback) {
              var selecionados = jQuery.parseJSON($("#estilo_aprendizagem").val());
              $("#estilo_aprendizagem").val('');
              callback(selecionados);
            },
            multiple : true,
            ajax: {
              url: $('#base_url').val() + "/ajax/estilo_aprendizagem",
              dataType: 'json',
              method : 'POST',
              delay: 250,
              data: function (params) {
                return {
                  estilo: params.term, // search term
                  page: params.page
                };
              },
              results: function (data, page) {

                var r = {
                  results: data
                };

                return r;
              },
              cache: true
            }
          });
    }
};

acoes_objeto_aprendizagem.init();

});
