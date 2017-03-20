$(document).ready(function(){
    
    var url_ajax = $("#url_cidade_ajax").val();
    
    function getCidade(estado, cidade, load) {
        
        $('#s2id_cidade').hide();
	$(load).show();
        
        $.ajax({
            url: url_ajax,
            data: {uf : estado},
            async: false,
            type: 'POST',
            context: '',
            dataType: 'json',
            success: function(cidades) {   
                 $(cidade).html(cidades);
                 $(load).hide();
                 $('#s2id_cidade').show();    
             }
          });
    }
            
    $('#estado_d').change(function() {
        getCidade($(this).val(), '#cidade', '#load');
    });
    
});