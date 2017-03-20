$(document).ready(function() {

    if($(".bar").length){
        $(".bar").peity("bar", { fill: function(value,i,all) { return ((value > this.$el.attr('data-nivel')) ? "#F8F8FF" : "magenta")},"delimiter" : "," });
    }
    
});

