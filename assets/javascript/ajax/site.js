$(document).ready(function(){
    
    mascara_telefone = {
        init: function() {
            $(".telefone").inputmask('(99)9999-9999[9]', {"placeholder": "(__)____-_____"});
        }
    };

    mascara_telefone.init();
    
    $(function() {

        //* WYSIWG Editor
        hagal_wysiwg.init();
    });


//* WYSIWG Editor
    hagal_wysiwg = {
        init: function() {
            if($('#texto_apresentacao').length) { 
                CKEDITOR.replace( 'texto_apresentacao',{
                    plugins: 'wysiwygarea,toolbar,format,basicstyles,liststyle,stylescombo,font,justify,resize,colorbutton,image,pagebreak,horizontalrule,link,list,removeformat,floatingspace,blockquote',
                    extraAllowedContent: 'b i',
                });
            }
        }
    };    
});