$(document).ready(function () {
    var download = [], upload = [];
    
    // Funcao que se auto-invoca a cada 1 seg. e que e a responsavel
    // pela atualizacao dos valores e do posicionamento dos graficos
    (function getValores() {
        $.ajax({
            url: "stats.php",
            method: "GET",
            async: true,
            cache: false,
            dataType: "json",
            success: function (data) {
                download.push(data.download);
                upload.push(data.upload);

                // Garante que somente valores do ultimo minuto
                // sejam mostrados
                if (download.length > 60 && upload.length > 60) {
                    download.shift();
                    upload.shift();
                }

                // Valores que serao mostrados
                var valores = [
                    {label: "Download (" + data.iface + ")", data: download, yaxis: 1, color: "#FF0000"},
                    {label: "Upload (" + data.iface + ")", data: upload, color: "#0062FF"}
                ];

                // Montando os graficos
                $.plot($("#placeholder"), valores, opcoes);
            }
        });
        setTimeout(getValores, 1000);
    });
});