$(document).ready(function(){
    
    $('#acesso').change(function() {

        if($(this).val() == "adm") {
         
            $('#grupos').show();
        }
        else {
            
            $('#grupos').hide();
        }
    });
});


