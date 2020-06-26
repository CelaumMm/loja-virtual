$(document).ready(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    function tabelaUsuarios(usuarios) {
        var tabela_body = $('#tabela-logados-tbody');

        tabela_body.html('');

        $.each(usuarios, function (index, value) {        
            var localizacao = '';
            if(!empty(value.localizacao)){
                localizacao = value.localizacao.cidade + ', ' + value.localizacao.pais;
            }       

            var tr = $(
                '<tr>' +
                '<td>' +
                value.nome +
                '</td>' +
                '<td>' +
                    localizacao +
                '</td>' +
                '<td>' +
                '<button onClick="deslogarUsuario(' + value.usuarios_id + ')" class="btn radius-50 btn-gray btn-sm mr-1" data-toggle="tooltip" title="Deslogar usuário">' +
                '<i class="fa fa-power-off pr-1"></i> Deslogar' +
                '</button>' +
                '<button onClick="bloquearUsuario(' + value.usuarios_id + ')" class="btn radius-50 btn-warning btn-sm mr-1" data-toggle="tooltip" title="Desativar usuário">' +
                '<i class="fa fa-ban pr-1"></i> Desativar' +
                '</button>' +
                '</td>' +
                '</tr>'
            );

            tabela_body.append(tr);
        });

    }

    function ajaxLoad(series, usuarios) {

        $.ajax({
            url: "./logados/ajax_usuario.php",
            type: "POST",
            dataType: "json",
            data: {"usuarios": usuarios}
        }).done(function (data) {
            if (data.total != usuarios) {
                var x = (new Date()).getTime(); // hora atual
                var y = data.total;

                series.addPoint([x, y], true, true);

                tabelaUsuarios(data.usuarios);
            }

            ajaxLoad(series, data.total);
        });
    }

    $("#deslogar-all-usuarios").on("click", function () {
        var usuarios_id = $(this).val();

        BootstrapDialog.confirm({
            title: "<h4><span class='fa fa-warning'></span> Atenção</h4>",
            message: "Você deseja deslogar todos usuários?",
            closable: true,
            draggable: true,
            type: BootstrapDialog.TYPE_WARNING,
            btnCancelLabel: 'Cancelar',
            btnCancelClass: 'd-inline btn-gray',
            btnOKLabel: 'OK',
            btnOKClass: 'd-inline btn-warning',
            callback: function (result) {
                if (result) {
                    $.ajax({
                       url: "./logados/ajax_deslogar_usuarios.php",
                       type: "POST",
                       dataType: "json",
                       data: {"usuarios_id": usuarios_id}
                   }).done(function (data) {

                   });
                }
            }
        });
    });

    $('#grafico-usuario').highcharts({
        chart: {
            type: 'spline',
            animation: Highcharts.svg, // não animar no IE antigo
            marginRight: 10,
            events: {
                load: function () {
                    // configurar a atualização do gráfico a cada segundo
                    var series = this.series[0];
                    ajaxLoad(series);
                }
            }
        },
        title: {
            text: 'Usuários'
        },
        xAxis: {
            title: {
                text: 'Horário da atualização'
            },
            type: 'datetime',
            tickPixelInterval: 1000
        },
        yAxis: {
            title: {
                text: 'Quantidade'
            },
            tickInterval: 1
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + ': ' + Highcharts.numberFormat(this.y, 0) + '</b><br/>' +
                        Highcharts.dateFormat('%d/%m/%Y %H:%M:%S', this.x) + '<br/>';
            }
        },
        legend: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        series: [{
                name: 'Quantidade',
                data: (function () {
                    // gerar um array de dados aleatórios
                    var data = [];
                    var time = (new Date()).getTime();
                    var i;

                    for (i = -10; i <= 0; i++) {
                        data.push({
                            x: time + i * 1000,
                            y: 0
                        });
                    }

                    return data;
                })()
            }]
    });
});