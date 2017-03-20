$(document).ready(function(){
    
    $('.number').mask("#",{reverse: true, maxlength: false,'translation': {0: {pattern: /[0-9*]/},'#': {pattern: /\d/, recursive: true}}});
    
    preencheLinks();
    
    $(document).on('change','select[name="tipo_link"]',function(){
        
        preencheLinks();
    });
    
    
    function preencheLinks() {
        
        var apps = '';
        
        $.each($('input[name="app_id[]"]:checked'), function( index, value ) {

            apps += $(this).val() + ',';
            
        });
        
       $.ajax({
            url: $('#base_url').val() + '/ajax/preenche_links',
            async: true,
            type: 'POST',
            context: '',
            dataType : 'json',
            data: { 
                tipo_link : $('select[name="tipo_link"]').val(),
                empresa : apps
            },
            success: function(data){
                
                $('select[name="link"]').html('');
                $('select[name="link"]').append(data);
                $('select[name="link"]').select2("val", $('select[name="link"]').attr('data-item'));
            }
        });
    }
    
});


