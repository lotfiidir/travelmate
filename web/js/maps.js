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
var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var labelIndex = 0;

function initMap() {
    var map = new google.maps.Map(document.getElementById('map_canvas'), {
        zoom: 2,
        center: {lat: 0, lng: 0}
    });

    map.addListener("click", function (event) {
        addMarker(event.latLng);
    });

    function addMarker(location) {
        //console.log(location.lat());
        var marker = new google.maps.Marker({
            position: location,
            label: labels[labelIndex++ % labels.length],
            map: map,
            draggable: false
        });
        markers.push(marker);

        var element = document.getElementById("markers");
        var span = document.createElement('span');
        var countSpan = element.childElementCount + 1;
        span.setAttribute('class', countSpan - 1);
        var content = document.createTextNode(countSpan);
        span.appendChild(content);
        element.appendChild(span);
        google.maps.event.addListener(marker, 'click', function(event) {
            console.log('marker Clicked !');
            infowin(map, marker, event);
        });

    }
function infowin(map, marker, event) {
var lanLng = "<p>Latitude :"+event.latLng.lat()+"</p><p>Longitude :"+event.latLng.lng()+"</p>";
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