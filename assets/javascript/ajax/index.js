$(document).ready(function() {

    mascara_data = {
        init: function() {
            $(".date").inputmask('dd/mm/yyyy', {"placeholder": "__/__/____"});
        }
    };

    mascara_data.init();

    $(".btn-with_action").click(function(e) {

        e.preventDefault();

        var selecionados = $('.checkbox').filter(':checked');

        var url = $(this).attr("href");

        if (((selecionados.filter(':checked').length === 0))) {

            bootbox.alert($("#msg_nenhum_registro").val());
        }
        else {

            var id = selecionados[0].value;

            $(window.document.location).attr("href", url + '/' + id);
        }
    });

    $(".btn-mult_action").click(function(e) {

        e.preventDefault();

        var selecionados = $('.checkbox').filter(':checked');

        var url = $(this).attr("href");

        if (((selecionados.filter(':checked').length === 0))) {

            bootbox.alert($("#msg_nenhum_registro").val());
        }
        else {

            var ids = '';
            for (var i = 0; i < selecionados.length; i++) {

                ids += selecionados[i].value;

                if (i + 1 < selecionados.length)
                    ids += '-';
            }

            $(window.document.location).attr("href", url + '/' + ids);
        }
    });

    $("#btn-remover").click(function(e) {

        e.preventDefault();

        var selecionados = $('.checkbox').filter(':checked');

        var url = $(this).attr("href");

        if (((selecionados.filter(':checked').length === 0))) {

            bootbox.alert($("#msg_nenhum_registro").val());
        }
        else {

            bootbox.confirm($("#msg_confirm_remocao").val(), $("#form_cancelar").val(), "OK", function(result) {
                if (result) {

                    var ids = '';
                    for (var i = 0; i < selecionados.length; i++) {

                        ids += selecionados[i].value;

                        if (i + 1 < selecionados.length)
                            ids += '-';
                    }

                    $(window.document.location).attr("href", url + '/' + ids);
                }
            });
        }
    });

    $("#paginacao").change(function(e) {

        e.preventDefault();

        document.getElementById('por_pagina').setAttribute('value', $("#paginacao").val());

        $("#form_filtrar").submit();
    });

    /*
     * Funcao seleciona todos
     */
    if ($('input[name="seleciona_todos"]').length) {
        //Marcar todos registros
        $('input[name="seleciona_todos"]').on('ifChecked', function(event) {
            $('.icheck').iCheck('check');
        });

        //Desmarcar todos registros
        $('input[name="seleciona_todos"]').on('ifUnchecked', function(event) {
            $('.icheck').iCheck('uncheck');
        });

        $('input[name="seleciona_todos"]').parent().parent().width(10);
    }
    if ($('#table').length) {

        $(".sortable").sortable({revert: true,
            stop: function(event, ui) {
                console.log("-");
            }
        });
    }

    $.fn.base_url = function() {
        return $('#base_url').val() + '/';
    };

    $.fn.replaceAll = function replaceAll(find, replace, str) {
        return str.replace(new RegExp(find, 'g'), replace);
    };

    if ($('.bs_datepicker_pt_start').length) {
        $('.bs_datepicker_pt_start').datepicker({})
                .on('changeDate', function(e) {
                    $('.bs_datepicker_pt_end').datepicker('setStartDate', e.date);
                });
    }

    if ($('.bs_datepicker_pt_end').length) {
        $('.bs_datepicker_pt_end').datepicker({})
                .on('changeDate', function(e) {
                    $('.bs_datepicker_pt_start').datepicker('setEndDate', e.date)
                });
    }
    
    if($('.formated_select').length) {
        var placeholder = $(this).attr('placeholder');
        $(".formated_select").select2({
            placeholder: (placeholder != undefined) ? placeholder : '',
            allowClear: true
        });
    }
});
