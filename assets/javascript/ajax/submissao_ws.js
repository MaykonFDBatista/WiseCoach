$(document).ready(function() {
    
    editor = {
        init: function(extensao){
            
            editAreaLoader.init({
                id : "codigo_fonte"		// textarea id
                ,syntax: extensao		// syntax to be uses for highgliting
                ,start_highlight: true		// to display with highlight mode on start-up
                ,allow_toggle: false
                ,allow_resize: "both"
                ,language: "pt"
                ,is_editable: false
            });
        }   
    };   
    
    var extensao = $('#codigo_fonte').data('extensao');
    editor.init(extensao);
    
});

