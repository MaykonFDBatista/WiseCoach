$(document).ready(function() {

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
