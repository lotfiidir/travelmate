/*var marker = new google.maps.Marker({
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

window.onload = function () {


    var map;
    var markers = [];
    var polyArray = [];
//var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
//var labelIndex = 0;
    var uniqueId = 0;
    var poly;

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
    function addPoly(markers) {
        var tracePoly = [];
        var end = markers[markers.length - 1];
        var end2 = markers[markers.length - 2];
        var endPosition = end.getPosition().lat() + ',' + end.getPosition().lng();
        var polyLast = end.getPosition().toJSON();
        var polyLast2 = end2.getPosition().toJSON();

        tracePoly.push(polyLast);
        tracePoly.push(polyLast2);
        poly = new google.maps.Polyline({
            path: tracePoly,
            strokeColor: '#6dabd4',
            strokeOpacity: 0.8,
            strokeWeight: 3
        });
        polyArray.push(poly);
        for (i = 0; i < polyArray.length; i++) {
            polyArray[i].setMap(map); //or line[i].setVisible(false);
            console.log("foooorrr" + polyArray[i]);
        }

        //console.log(polyArray);
    }

    function addMarker(location) {
        //console.log(location.lat());
        var marker = new google.maps.Marker({
            position: location,
            //label: labels[labelIndex++ % labels.length],
            map: map,
            draggable: false
        });
        markers.push(marker);
        var isD = false;
        if (markers.length > 1) {
            calculate(markers, directionsService, directionsDisplay);
            var isD = true;
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
            infowin(map, marker, event);
        });
        var direction = [];
        if (isD) {
            direction.push(directionsService);
            direction.push(directionsDisplay);
        }
        //exportMap(marker, direction, polyArray);
        exportMap(markers);
    }

    function infowin(map, marker, event) {
        var lanLng = "<p>Latitude :" + event.latLng.lat() + "</p><p>Longitude :" + event.latLng.lng() + "</p>";
        lanLng += "<input id='delete-marker' class='btn btn-default' type='button' value='supprimer'>";
        var infowindow = new google.maps.InfoWindow({
            content: lanLng
        });
        infowindow.open(map, marker);
        if (document.getElementById("delete-marker")) {
            var btnSupMarker = document.getElementById("delete-marker");
            btnSupMarker.addEventListener("click", supprimerMarker(marker.id));
        }
    }

    //new google.maps.event.trigger( marker, 'click' );

    /*var elementSpan = document.getElementById("markers");
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
     }*/

    function supprimerMarker(id) {
        for (var i = 0; i < markers.length; i++) {
            if (markers[i].id === id) {
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
        poly.setMap(null);
        polyArray.pop();
        //console.log(poly);
    }

    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
        for (i = 0; i < polyArray.length; i++) {
            polyArray[i].setMap(map); //or line[i].setVisible(false);
            //polyArray[i].getPath().removeAt(i);
        }

        //poly.setMap(null);
        markers = [];
        polyArray = [];
        exportMap(markers);
        //console.log('tableau de polyline :' + polyArray)
    }

    function calculate(markers, directionsService, directionsDisplay) {
        var waypts = [];
        if (markers.length > 2) {
            for (i = 1; i < markers.length - 1; i++) {
                var wyptsPos = markers[i].getPosition().lat() + ',' + markers[i].getPosition().lng()
                waypts.push({
                    location: wyptsPos,
                    stopover: true
                });
            }
        }
        var start = markers[0];
        var startPostion = start.getPosition().lat() + ',' + start.getPosition().lng();
        var end = markers[markers.length - 1];
        var endPosition = end.getPosition().lat() + ',' + end.getPosition().lng();

        directionsService.route({
            origin: startPostion,
            destination: endPosition,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: 'DRIVING'
        }, function (response, status) {
            if (status === 'OK') {
                directionsDisplay.setMap(map);
                directionsDisplay.setDirections(response);
                var route = response.routes[0];
                //console.log(route);
            } else {
                addPoly(markers);
                //alert('Directions request failed due to ' + status);
            }
        });
    }

    document.getElementById("nettoyer").addEventListener("click", function (e) {
        setMapOnAll(null);
        directionsDisplay.setMap(null);
    }, false);

    function exportMap(marker) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/trip/creer");
        xhr.setRequestHeader("Content-Type", "application/json");
        var coor = [];
        var newMarker = [];
        //console.log(marker);

        for(i=0;i<marker.length;i++){
            var lat = marker[i].getPosition().lat();
            var lng = marker[i].getPosition().lng();
            coor.push(lat+','+lng);
        }
        console.log(coor);
        xhr.send(JSON.stringify(coor));
        var value = document.getElementById("form_traces").setAttribute('value', JSON.stringify(coor));
        //console.log({marker: +JSON.stringify(marker)},{direction:+JSON.stringify(marker)},{poly:+JSON.stringify(poly)});

    }

};


