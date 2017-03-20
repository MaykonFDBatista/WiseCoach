function remove_arquivo(div_class, arquivo) {
    
    var url = $('#base_url').val() + '/ajax/remove_arquivo';

    $.ajax({
        url: url,
        async: false,
        type: 'POST',
        context: '',
        data: {id : $('input[name="pro_id"]').val(),arquivo : arquivo },
        success: function(data){

            if(data){
                $('.' + div_class).remove();
            }
        }
    });
}

$(document).ready(function() {
    
    $(function() {
        //* multiupload
         hagal_multiupload.init();
    });
    
    //* drag&drop multi-upload
    hagal_multiupload = {
        init: function() {
            if($('#multi_upload_arquivo').length) {

                var base_url = $("#base_url").val();
                
                base_url = base_url.replace("/adm","");
                
                base_url += "/templates/adm/hagal/";
                
                $("#multi_upload_arquivo").pluploadQueue({
                    // General settings
                    runtimes : 'html5,flash,silverlight',
                    url : base_url + 'js/lib/plupload/examples/upload_arquivo.php?id=' + $("input[name='pro_id']").val(),
                    max_file_size : '10mb',
                    chunk_size : '1mb',
                    unique_names : false,
                    browse_button : 'pickfiles',
            
                    resize : {
                        width : 1024, 
                        height : 720, 
                        quality : 100
                    },
                    // Specify what files to browse for
//                    filters : [
//                        {title : "Image files", extensions : "pdf,odt,doc,docx"},
//                        {title : "Zip files", extensions : "zip"}
//                    ],
            
                    // Flash settings
                    flash_swf_url : base_url + 'js/lib/plupload/js/plupload.flash.swf',
            
                    // Silverlight settings
                    silverlight_xap_url : base_url + 'js/lib/plupload/js/plupload.silverlight.xap'
                });
                $('.plupload_header').remove();
            }

        }
        
    };
    
    
    
    $(function() {

        //* WYSIWG Editor
        hagal_wysiwg.init();
    });


    //* WYSIWG Editor
    hagal_wysiwg = {
        init: function() {
            if($('#descricao').length) { 
                CKEDITOR.replace( 'descricao',{
//                    plugins: "dialogui,dialog,a11yhelp,about,basicstyles,bidi,blockquote,clipboard," +
//                             "button,panelbutton,panel,floatpanel,colorbutton,colordialog,menu," +
//                             "contextmenu,dialogadvtab,div,elementspath,enterkey,entities,popup," +
//                             "filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo," +
//                             "font,format,forms,horizontalrule,htmlwriter,iframe,image,indent," +
//                             "justify,link,list,liststyle,magicline," +
//                             "maximize,newpage,pagebreak,pastefromword,pastetext,preview,print," +
//                             "removeformat,resize,save,menubutton,scayt,selectall,showblocks," +
//                             "showborders,smiley,sourcearea,specialchar,stylescombo,tab,table," +
//                             "tabletools,templates,toolbar,undo,wsc,wysiwygarea",
                    language: 'pt-br',
                    plugins: "dialogui,dialog,a11yhelp,basicstyles,blockquote," +
                             "button,panelbutton,panel,floatpanel,colorbutton,colordialog,menu," +
                             "contextmenu,dialogadvtab,div,elementspath,enterkey,entities,popup," +
                             "filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo," +
                             "font,format,horizontalrule,htmlwriter,iframe,image,indent," +
                             "justify,link,list,liststyle,magicline," +
                             "maximize,newpage,pagebreak,preview," +
                             "removeformat,resize,menubutton,scayt,selectall,showblocks," +
                             "showborders,smiley,sourcearea,specialchar,stylescombo,tab,table," +
                             "tabletools,toolbar,undo,wsc,wysiwygarea",
                    extraAllowedContent: 'b i',
                    extraPlugins: 'autogrow'
                });
            }
            
            if($('#entrada').length) { 
                CKEDITOR.replace( 'entrada',{
                    language: 'pt-br',
                    plugins: "dialogui,dialog,a11yhelp,basicstyles,blockquote," +
                             "button,panelbutton,panel,floatpanel,colorbutton,colordialog,menu," +
                             "contextmenu,dialogadvtab,div,elementspath,enterkey,entities,popup," +
                             "filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo," +
                             "font,format,horizontalrule,htmlwriter,iframe,image,indent," +
                             "justify,link,list,liststyle,magicline," +
                             "maximize,newpage,pagebreak,preview," +
                             "removeformat,resize,menubutton,scayt,selectall,showblocks," +
                             "showborders,smiley,sourcearea,specialchar,stylescombo,tab,table," +
                             "tabletools,toolbar,undo,wsc,wysiwygarea",
                    extraAllowedContent: 'b i',
                    extraPlugins: 'autogrow'
                });
            }
            
            if($('#saida').length) { 
                CKEDITOR.replace( 'saida',{
                    language: 'pt-br',
                    plugins: "dialogui,dialog,a11yhelp,basicstyles,blockquote," +
                             "button,panelbutton,panel,floatpanel,colorbutton,colordialog,menu," +
                             "contextmenu,dialogadvtab,div,elementspath,enterkey,entities,popup," +
                             "filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo," +
                             "font,format,horizontalrule,htmlwriter,iframe,image,indent," +
                             "justify,link,list,liststyle,magicline," +
                             "maximize,newpage,pagebreak,preview," +
                             "removeformat,resize,menubutton,scayt,selectall,showblocks," +
                             "showborders,smiley,sourcearea,specialchar,stylescombo,tab,table," +
                             "tabletools,toolbar,undo,wsc,wysiwygarea",
                    extraAllowedContent: 'b i',
                    extraPlugins: 'autogrow'
                });
            }
            
            if($('#restricoes').length) { 
                CKEDITOR.replace( 'restricoes',{
                    language: 'pt-br',
                    plugins: "dialogui,dialog,a11yhelp,basicstyles,blockquote," +
                             "button,panelbutton,panel,floatpanel,colorbutton,colordialog,menu," +
                             "contextmenu,dialogadvtab,div,elementspath,enterkey,entities,popup," +
                             "filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo," +
                             "font,format,horizontalrule,htmlwriter,iframe,image,indent," +
                             "justify,link,list,liststyle,magicline," +
                             "maximize,newpage,pagebreak,preview," +
                             "removeformat,resize,menubutton,scayt,selectall,showblocks," +
                             "showborders,smiley,sourcearea,specialchar,stylescombo,tab,table," +
                             "tabletools,toolbar,undo,wsc,wysiwygarea",
                    extraAllowedContent: 'b i',
                    extraPlugins: 'autogrow'
                });
            }
            
            if($('#exemplo_entrada').length) { 
                CKEDITOR.replace( 'exemplo_entrada',{
                    language: 'pt-br',
                    plugins: "find,newpage,preview,resize,selectall,toolbar,undo,wsc,wysiwygarea",
                    extraAllowedContent: 'b i',
                    extraPlugins: 'autogrow'
                });
            }
            
            if($('#exemplo_saida').length) { 
                CKEDITOR.replace( 'exemplo_saida',{
                    language: 'pt-br',
                    plugins:  "find,newpage,preview,resize,selectall,toolbar,undo,wsc,wysiwygarea",
                    extraAllowedContent: 'b i',
                    extraPlugins: 'autogrow'
                });
            }
            
            if($('#pro_dicas').length) { 
                CKEDITOR.replace( 'pro_dicas',{
                    language: 'pt-br',
                    plugins:  "dialogui,dialog,basicstyles,blockquote," +
                             "button,panelbutton,panel,floatpanel,menu," +
                             "contextmenu,dialogadvtab,div,elementspath,enterkey,entities,popup," +
                             "removeformat,resize,menubutton," +
                             "toolbar,wysiwygarea",
                    extraAllowedContent: 'b i',
                    extraPlugins: 'autogrow'
                });
            }
        }
    }; 

    if($('#nivel').length) {
                //* slider with select
                var max = $( "input[name='qtd_niveis']" ).val();
                var select = $( "#nivel" );
                var slider = $( "<div id='ui_slider3'></div>" ).insertAfter( select ).slider({
                    min: 1,
                    max: max,
                    range: "min",
                    value: select[ 0 ].selectedIndex + 1,
                    slide: function( event, ui ) {
                        select[ 0 ].selectedIndex = ui.value - 1;
                    }
                });
                $( "#nivel" ).change(function() {
                    slider.slider( "value", this.selectedIndex + 1 );
                });
            }
});
