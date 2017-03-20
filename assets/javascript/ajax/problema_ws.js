$(document).ready(function() {

    if($("#editor").length){
        var editor = ace.edit("editor");

        editor_init = {
            init: function(highlighter){

                editor.setTheme("ace/theme/katzenmilch");
                editor.session.setMode("ace/mode/"+highlighter);
                editor.setAutoScrollEditorIntoView(true);
                editor.setOption("maxLines", 40);
                editor.setOption("minLines", 20);
            }   
        };   
    }
    
    if($("#linguagem").length){
        
        var highlighter = $('#linguagem option:selected').data('highlighter');
        
        editor_init.init(highlighter);
    
        $("#linguagem").on("change", function(){

            var highlighter = $('option:selected', this).data('highlighter');
            editor_init.init(highlighter);

        });
    }
    
    if($("#form_submeter").length){
        $("#form_submeter").submit(function(){
            var codigo_fonte = editor.getValue();
            $("#codigo_fonte").val(codigo_fonte);
        });
    }
    
    if($(".bar").length){
        $(".bar").peity("bar", { fill: function(value,i,all) { return ((value > this.$el.attr('data-nivel')) ? "#F8F8FF" : "magenta")},"delimiter" : "," });
    }
    
});

