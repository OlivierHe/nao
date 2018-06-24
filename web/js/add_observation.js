
//Initialisation de la carte
var info;
var obsLatitude = $('#obs_latitude');
var obsLongitude = $('#obs_longitude');
var btnGeo = $('#btn-geo');


function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 48.85781748848695, lng: 2.345083906250011},
        zoom: 6
    });

//Modal de demande d'utilisation du gps

    if ($('#success-for-toast').length > 0 ){
        Materialize.toast('Votre observation a bien été posté ! ', 4000, 'toast-success');
        markerWithoutGeo(map);

    }else if ($(".form-group ul").length > 0){
        markerWithoutGeo(map);

    }else {
        $('#modal-gps').modal({
                dismissible: false, // Modal can be dismissed by clicking outside of the modal
                opacity: .7, // Opacity of modal background
                inDuration: 400, // Transition in duration
                outDuration: 400, // Transition out duration
                startingTop: '4%', // Starting top style attribute
                endingTop: '10%' // Ending top style attribute
            }
        ).modal('open');
    }

    //Acceptation de l'utilisation de la géolacalisation
    $('#accept-gps').click(function () {
        geoLocalisation(map);
    });

    //Refus de l'utilisation de la géolocalisation
    $('#refuse-gps').click(function () {
        markerWithoutGeo(map);
        btnGeo.remove();

    });

//Bouton de "re-geolocalisation"
    btnGeo.click( function () {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                var pos = {lat: position.coords.latitude, lng: position.coords.longitude};
                marker.setPosition(pos);
                obsLatitude.val(pos.lat);
                obsLongitude.val(pos.lng);

            })
    });



}

function geoLocalisation(map) {

    var latitude = map.getCenter().lat();
    var longitude = map.getCenter().lng();
// Géolocalisation accepté
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {

//Récupération de la position
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                var pos = {lat:latitude, lng: longitude};


                markerGeo(map,latitude,longitude);
//Information de l'état de la map et recadrage de la map
                info = "Location trouvé ! ";
                map.setCenter(pos);

            },
//Geolocalisation non activé
            function() {
                markerWithoutGeo(map);
                btnGeo.remove();
                Materialize.toast('Echec de géolocalisation, veuillez cliquer sur la carte ', 4000,'toast-error');

            }
        );
//Géolocalisation non supportée
    }else{
        markerWithoutGeo(map);
        btnGeo.remove();
        Materialize.toast('Echec de géolocalisation, veuillez cliquer sur la carte ', 4000, 'toast-error');

    }
}

//Marker avec géolocalisation
function markerGeo(map, latitude,longitude) {
    marker = new google.maps.Marker({
        map: map,
        animation: google.maps.Animation.DROP,
        position: {lat: latitude, lng: longitude}
    });
    obsLatitude.val(latitude);
    obsLongitude.val(longitude);

    map.addListener('click',function (event) {
        marker.setPosition(event.latLng);
        obsLatitude.val(marker.getPosition().lat());
        obsLongitude.val(marker.getPosition().lng());
    });
}

//Marker sans géolocalisation
function markerWithoutGeo(map) {
    marker = new google.maps.Marker({
        map: map
    });
    map.addListener('click',function (event) {
        marker.setPosition(event.latLng);
        obsLatitude.val(marker.getPosition().lat());
        obsLongitude.val(marker.getPosition().lng());
    });
}

//Animation du pointeur
function toggleBounce() {
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

