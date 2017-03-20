$(document).ready(function () {

    $(".idioma_item_menu").on("click", function () {
        var key = $(this).data("key");
        var item_html = $(this).html();
        $("#idioma_selecionado_menu").html(item_html);
    });

    var acoes_ws = {
        inicializa: function () {
            acoes_ws.lista_notificacoes();
        },
        lista_notificacoes: function () {
            var url = $('#base_url').val() + 'ws/ajax/get_notificacoes_nao_lidas'; 
            $.ajax({
                'url': url,
                'type': 'POST',
                'dataType': 'json',
                data: {},
                success: function (notificacoes) {

                    $.each(notificacoes, function (i, notificacao) {

                        if (!("Notification" in window)) {
                            alert("This browser does not support desktop notification");
                        }

                        // Let's check whether notification permissions have already been granted
                        else if (Notification.permission === "granted") {
                            // If it's okay let's create a notification
                            acoes_ws.exibir_notificacao(notificacao);
                        }

                        // Otherwise, we need to ask the user for permission
                        else if (Notification.permission !== 'denied') {
                            Notification.requestPermission(function (permission) {
                                // If the user accepts, let's create a notification
                                if (permission === "granted") {
                                    acoes_ws.exibir_notificacao(notificacao);
                                }
                            });
                        }

                    });

                },
                error: function (data) {
                    console.log("error in ajax form submission");
                }
            });
        },
        exibir_notificacao: function (notificacao) {

            var options = {
                body: notificacao.mensagem,
                icon: $('#base_url').val() + 'assets/arquivos/default/logo_notificacao.png',
                data: notificacao.id
            };

            var n = new Notification(notificacao.titulo, options)
                    .onclose = function () {
                        console.log(this);
                        console.log(notificacao.id);
                        acoes_ws.marcar_notificacao_como_lida(notificacao.id);

                    }
                    .onclick = function(){
                        console.log(this);
                        console.log(notificacao.id);
                        acoes_ws.marcar_notificacao_como_lida(notificacao.id);
                    };
        },
        marcar_notificacao_como_lida: function (notificacao_id) {
            $.ajax({
                url: $('#base_url').val() + 'ws/ajax/marcar_como_lida',
                type: 'POST',
                dataType: 'json',
                data: {'notificacao_id': notificacao_id},
                success: function (data) {
                }
            });
        }
    };

    acoes_ws.inicializa();
});
