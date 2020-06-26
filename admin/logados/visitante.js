$(document).ready(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    function ajaxLoad(series, usuarios) {

        $.ajax({
            url: "./logados/ajax_visitante.php",
            type: "POST",
            dataType: "json",
            data: {"usuarios": usuarios}
        }).done(function (data) {
            if (data.usuarios != usuarios) {
                var x = (new Date()).getTime(), // hora atual
                        y = data.usuarios;
                series.addPoint([x, y], true, true);
            }
            ajaxLoad(series, data.usuarios);
        });
    }

    $("#deslogar-all-visitantes").on("click", function () {
        BootstrapDialog.confirm({
            title: "<h4><span class='fa fa-warning'></span> Atenção</h4>",
            message: "Você deseja deslogar todos visitantes?",
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
                        url: "./logados/ajax_deslogar_visitantes.php",
                        type: "POST",
                        dataType: "json"
                    }).done(function (data) {

                    });
                }
            }
        });
    });

    $('#grafico-visitante').highcharts({
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
            text: 'Visitantes'
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