function initMap() {
    const myLatLng = {
        lat: 24.774265,
        lng: 46.738586
    };

    // Styles a map in night mode.
    const map = new google.maps.Map(document.getElementById("map"), {
        center: myLatLng,
        zoom: 12,
        styles: [{
            "elementType": "geometry",
            "stylers": [{
                "color": "#f5f5f5"
            }]
        }, {
            "elementType": "labels.icon",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#616161"
            }]
        }, {
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#f5f5f5"
            }]
        }, {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#bdbdbd"
            }]
        }, {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{
                "color": "#eeeeee"
            }]
        }, {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#757575"
            }]
        }, {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{
                "color": "#e5e5e5"
            }]
        }, {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9e9e9e"
            }]
        }, {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{
                "color": "#ffffff"
            }]
        }, {
            "featureType": "road.arterial",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#757575"
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [{
                "color": "#dadada"
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#616161"
            }]
        }, {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9e9e9e"
            }]
        }, {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [{
                "color": "#e5e5e5"
            }]
        }, {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [{
                "color": "#eeeeee"
            }]
        }, {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{
                "color": "#c9c9c9"
            }]
        }, {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9e9e9e"
            }]
        }]
    });

    var beaches = [

        ['Riyadh', 21.543333, 39.172779, 4, '', 'images/mark.svg'],
        ['Riyadh', 18.329384, 42.759365, 4, '', 'images/mark.svg'],
        ['Riyadh', 25.994478, 45.318161, 4, '', 'images/mark.svg'],
        ['Riyadh', 26.094088, 43.973454, 4, '', 'images/mark.svg'],
        ['Riyadh', 26.396790, 50.140400, 4, '', 'images/mark.svg'],
        ['Riyadh', 21.437273, 40.512714, 4, '', 'images/mark.svg'],
        ['Riyadh', 29.953894, 40.197044, 4, '', 'images/mark.svg'],
        ['Riyadh', 30.983334, 41.016666, 4, '', 'images/mark.svg'],
        ['Riyadh', 24.186848, 38.026428, 4, '', 'images/mark.svg'],
        ['Riyadh', 27.523647, 41.696632, 4, '', 'images/mark.svg'],



    ];
    let markers = []
    let infoWindows = []

    for (var i = 0; i < beaches.length; i++) {
        var beach = beaches[i];

        var marker = new google.maps.Marker({
            position: {
                lat: beach[1],
                lng: beach[2]
            },
            map: map,
            icon: beach[5],
            title: beach[0],
            // zIndex: beach[3],

        });
        markers.push(marker);
    }



}