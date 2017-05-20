/*var markers = [];
 function getTrace(e, objMap) {
 var lat = e.latLng.lat();
 var lng = e.latLng.lng();
 //console.log(objMap);

 console.log("Latitude:" + lat);
 console.log("Longitude:" + lng);
 var xhr = new XMLHttpRequest();
 xhr.open("POST", "/trip/creer");
 xhr.setRequestHeader("Content-Type", "application/json");
 xhr.send(JSON.stringify({trace: {lat: lat, lng: lng}}));


 var marker = new google.maps.Marker({
 position: e.latLng,
 map: objMap,
 draggable: true
 });
 console.log(objMap);
 console.log(marker);
 markers.push(marker);
 var element = document.getElementById("markers");
 var span = document.createElement('span');
 var countSpan = element.childElementCount + 1;
 span.setAttribute('class', countSpan-1);
 var content = document.createTextNode(countSpan);
 span.appendChild(content);
 element.appendChild(span);
 getMarkers(markers);
 }
 function getMarkers(markers) {
 return markers;
 }

 document.getElementById("markers").addEventListener("mouseover", function (e) {
 var classMarker = e.target.getAttribute('class');
 var thisMarker = getMarkers(markers);

 });*/

var map;
var markers = [];
//var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
//var labelIndex = 0;
var uniqueId = 0;

function initMap() {
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;

    var map = new google.maps.Map(document.getElementById('map_canvas'), {
        zoom: 2,
        center: {lat: 0, lng: 0}
    });
    directionsDisplay.setMap(map);

    map.addListener("click", function (event) {
        addMarker(event.latLng);
    });

    function addMarker(location) {
        //console.log(location.lat());
        var marker = new google.maps.Marker({
            position: location,
            //label: labels[labelIndex++ % labels.length],
            map: map,
            draggable: false
        });
        markers.push(marker);
        if (markers.length > 1) {
            window.calculate(markers, directionsService, directionsDisplay);
        }
        marker.id = uniqueId;
        uniqueId++;

        /*var element = document.getElementById("markers");
         var span = document.createElement('span');
         var countSpan = element.childElementCount + 1;
         span.setAttribute('class', countSpan - 1);
         var content = document.createTextNode(countSpan);
         span.appendChild(content);
         element.appendChild(span);*/
        google.maps.event.addListener(marker, 'click', function (event) {
            console.log('marker Clicked !');
            infowin(map, marker, event);
        });
        console.log(marker.getPosition());

    }



    function infowin(map, marker, event) {
        var lanLng = "<p>Latitude :" + event.latLng.lat() + "</p><p>Longitude :" + event.latLng.lng() + "</p>";
        lanLng += "<input class='btn btn-default' type='button' value='supprimer' onclick='supprimerMarker(" + marker.id + ");'>";
        var infowindow = new google.maps.InfoWindow({
            content: lanLng
        });
        infowindow.open(map, marker);

    }


    //new google.maps.event.trigger( marker, 'click' );

    var elementSpan = document.getElementById("markers");
    elementSpan.addEventListener('click', function (e) {
        var classMarker = e.target.getAttribute('class');
        toggleBounce(markers[classMarker]);
    });

    function toggleBounce(marker) {
        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }
}
function supprimerMarker(id) {
    for (var i = 0; i < markers.length; i++) {
        if (markers[i].id == id) {
            //Remove the marker from Map
            markers[i].setMap(null);
            //Remove the marker from array.
            markers.splice(i, 1);
            /*var element = document.getElementById("markers");
             var span = document.querySelector('#markers span');
             element.removeChild(span);*/
            //labelIndex--;
            //calculate(markers);
            return;
        }
    }
}

function calculate(markers, directionsService, directionsDisplay) {
    var waypts = [];
    if (markers.length > 2) {
        for (i = 1; i < markers.length - 1; i++) {
            var wyptsPos = markers[i].getPosition().lat()+','+markers[i].getPosition().lng()
            waypts.push({
                location: wyptsPos,
                stopover: true
            });
        }
    }
    var start = markers[0];
    var startPostion = start.getPosition().lat()+','+start.getPosition().lng();
    var end = markers[markers.length - 1];
    var endPosition = end.getPosition().lat()+','+end.getPosition().lng();
    directionsService.route({
        origin: startPostion,
        destination: endPosition,
        waypoints: waypts,
        optimizeWaypoints: false,
        travelMode: 'DRIVING'
    }, function(response, status) {
        if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
        } else {

            window.alert('Directions request failed due to ' + status);
        }
    });
}
