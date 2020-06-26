function map_initialize() {
    var myLatlng = {lat: -23.556468, lng: -46.654244};

    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: 17,
        center: myLatlng
        //scrollwheel: false
    });

    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title: 'GETH - Grupo de Estudos de Tumores Hereditários'
    });

    var infowindow = new google.maps.InfoWindow({
        content: '<h6>GETH - Grupo de Estudos de Tumores Hereditários</h6> Rua Barata Ribeiro, 398 T\u00e9rreo,<br> Bela Vista - S\u00e3o Paulo\/SP -1308-000 Brasil'
    });

    marker.addListener('click', function () {
        infowindow.open(map, marker);
    });
}

google.maps.event.addDomListener(window, "load", map_initialize);