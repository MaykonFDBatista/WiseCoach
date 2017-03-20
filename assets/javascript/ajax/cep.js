 $(document).on('change', '.consulta_cep', function(){
        
        var cep = $(this).val();
        
        var url = $("#base_url").val() + '/ajax/busca_endereco';
        
        var elemento = $(this);
        
        var input_cep = $(this);
        
        $.ajax({
            url: url,
            data: {cep : cep},
            async: false,
            type: 'POST',
            context: '',
            dataType: 'json',
            success: function(endereco) { 
                
                var uf =$('.dropdown_estado', $(elemento).closest('.endereco'))[1];
                var logradouro = $('.logradouro', $(elemento).closest('.endereco'))[0];
                var bairro = $('.bairro', $(elemento).closest('.endereco'))[0];
                var cidade = $('.dropdown_cidade', $(elemento).closest('.endereco'))[0];
                
                if(endereco !== null){
                    $(uf).val(endereco.fk_uf);
                    $(uf).attr('selected',endereco.fk_uf);             
                    $(logradouro).val(endereco.logradouro);
                    $(bairro).val(endereco.bairro);
                
                    setaCidade(uf,cidade,endereco.fk_id_cidade);
                    
                }else{
                    
                    $(elemento).closest('div').parent().find('span').remove();
                    $(uf).val('SP');
                    $(uf).trigger('change');
                    $(cidade).val('');
                    $(logradouro).val('');
                    $(bairro).val('');
                }
                
            }
        });
    });

function setaCidade(dropDownUf, dropDownCidade, cidade_id){
        $.when($(dropDownUf).trigger('change')).done(function(){
            $(dropDownCidade).select2("val", cidade_id);
            
        });
    
    }

