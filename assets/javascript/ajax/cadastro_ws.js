$(document).ready(function() {
    
    $(".telefone").inputmask({mask: "99 9999-9999", greedy: false});

    $( ".idioma_item" ).on( "click", function() {
        var key = $(this).data("key");
        var item_html = $(this).html() + '<b class="caret"></b>';
        $( "#com_idioma" ).val(key);
        $( "#idioma_selecionado" ).html(item_html);
    });
    
});
