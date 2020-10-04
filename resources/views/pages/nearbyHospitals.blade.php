<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Add an animated icon to the map</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/navbarstyle.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        
        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }
        
        #instructions {
            position: absolute;
            margin: 2%;
            width: 20%;
            height: 15%;
            top: 10%;
            bottom: 5%;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            overflow-y: scroll;
            font-family: sans-serif;
            font-size: 0.8em;
            line-height: 2em;
            visibility: hidden;
            /* display: none; */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/doctors">{{ __('Doctors') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/nearby-hospitals">{{ __('Nearby Hospitals') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">{{ __('About Us') }}</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div id="loginlogout" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/hospital/create">{{ __('Add New Hospital') }}</a>
                          
                            <a class="dropdown-item" href="/doctor/create">{{ __('Add New Doctor') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
    <div id="app">
    </div>
    <div id="map"></div>
    <div id="instructions"></div>

    <script type="text/javascript">

        mapboxgl.accessToken = 'pk.eyJ1IjoibmFoaWQ1OTciLCJhIjoiY2syMzQwZThqMHNnODNnbnIwZTYxbXptciJ9.pCJVXu5d-k1CDRZ9qJsFJQ';

        var lat = 24.98;
        var lng = 88.90;

        var start = [lng, lat];

        var map;
        var marker;
        var popup;
        var confirmcheck = 0;


        navigator.geolocation.getCurrentPosition(response => {
            lat = response.coords.latitude;
            lng = response.coords.longitude;

            map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v9',
                center: [lng, lat],
                zoom: 13,
            });

            start[lng, lat];

            getRoute(start);

            var size = 120;

            // implementation of CustomLayerInterface to draw a pulsing dot icon on the map
            // see https://docs.mapbox.com/mapbox-gl-js/api/#customlayerinterface for more info
            var pulsingDot = {
                width: size,
                height: size,
                data: new Uint8Array(size * size * 4),

                // get rendering context for the map canvas when layer is added to the map
                onAdd: function() {
                    var canvas = document.createElement('canvas');
                    canvas.width = this.width;
                    canvas.height = this.height;
                    this.context = canvas.getContext('2d');
                },

                // called once before every frame where the icon will be used
                render: function() {
                    var duration = 1000;
                    var t = (performance.now() % duration) / duration;

                    var radius = (size / 2) * 0.3;
                    var outerRadius = (size / 2) * 0.7 * t + radius;
                    var context = this.context;

                    // draw outer circle
                    context.clearRect(0, 0, this.width, this.height);
                    context.beginPath();
                    context.arc(
                        this.width / 2,
                        this.height / 2,
                        outerRadius,
                        0,
                        Math.PI * 2
                    );
                    context.fillStyle = 'rgba(255, 200, 200,' + (1 - t) + ')';
                    context.fill();

                    // draw inner circle
                    context.beginPath();
                    context.arc(
                        this.width / 2,
                        this.height / 2,
                        radius,
                        0,
                        Math.PI * 2
                    );
                    context.fillStyle = 'blue';
                    context.strokeStyle = 'white';
                    context.lineWidth = 2 + 4 * (1 - t);
                    context.fill();
                    context.stroke();

                    // update this image's data with data from the canvas
                    this.data = context.getImageData(
                        0,
                        0,
                        this.width,
                        this.height
                    ).data;

                    // continuously repaint the map, resulting in the smooth animation of the dot
                    map.triggerRepaint();

                    // return `true` to let the map know that the image was updated
                    return true;
                }
            };

            map.on('load', function() {
                map.addImage('pulsing-dot', pulsingDot, {
                    pixelRatio: 2
                });

                map.addSource('points', {
                    'type': 'geojson',
                    'data': {
                        'type': 'FeatureCollection',
                        'features': [{
                            'type': 'Feature',
                            'geometry': {
                                'type': 'Point',
                                'coordinates': [lng, lat]
                            }
                        }]
                    }
                });
                map.addLayer({
                    'id': 'points',
                    'type': 'symbol',
                    'source': 'points',
                    'layout': {
                        'icon-image': 'pulsing-dot'
                    }
                });
            });
             <?php
                for ($x = 0; $x < sizeof($result); $x++) {
                    echo "\r\n";
                    echo 'hospitalMarker(';
                    echo '"';
                    echo $result[$x]->name;
                    echo '"';
                    echo ',';
                    echo  $result[$x]->lng;
                    echo ',';
                    echo  $result[$x]->lat;
                    echo '); ';
                }
                    
            ?>
            //hospitalMarker(88.5864, 24.3720);
            //hospitalMarker(88.653884,24.368414);
        });


        function hospitalMarker(name, lng, lat) {

            console.log("host " + lat);
            var el = document.createElement('div');
            var hospital = document.createElement('i');
            hospital.className = 'fa fa-hospital-o';
            hospital.style = "font-size:45px; color:red";
            el.appendChild(hospital);

            popup = new mapboxgl.Popup({
                    offset: 38,
                    closeOnClick: false,

                })
                .setHTML(gotoRoute(name, lng, lat));

            this.marker = new mapboxgl.Marker(el)
                .setLngLat([lng, lat])
                .setPopup(popup)
                //.getLngLat()
                .addTo(map)
        }

        function confirmRoute(lat, lng) {
            // console.log("button is clicked" + lat, lng);
            var coords = [lng, lat];

            confirmcheck = 1;

            getRoute(coords);

            popup.remove();

        }


        function getRoute(end) {
            // make a directions request using cycling profile
            // an arbitrary start will always be the same
            // only the end or destination will change
            //console.log("end data" + end);

            // here we need data from user database

            var start = [lng, lat];


            console.log("start data" + start);
            var url = 'https://api.mapbox.com/directions/v5/mapbox/cycling/' + start[0] + ',' + start[1] + ';' + end[0] + ',' + end[1] + '?steps=true&geometries=geojson&access_token=' + mapboxgl.accessToken;

            // make an XHR request https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest
            var req = new XMLHttpRequest();
            req.responseType = 'json';
            req.open('GET', url, true);
            req.onload = function() {
                var data = req.response.routes[0];
                console.log(req.response);
                var route = data.geometry.coordinates;
                //console.log(route);
                var geojson = {
                    type: 'Feature',
                    properties: {},
                    geometry: {
                        type: 'LineString',
                        coordinates: route
                    }
                };
                // if the route already exists on the map, reset it using setData



                if (map.getSource('route')) {
                    map.getSource('route').setData(geojson);
                } else { // otherwise, make a new request
                    map.addLayer({
                        id: 'route',
                        type: 'line',
                        source: {
                            type: 'geojson',
                            data: {
                                type: 'Feature',
                                properties: {},
                                geometry: {
                                    type: 'LineString',
                                    coordinates: geojson
                                }
                            }
                        },
                        layout: {
                            'line-join': 'round',
                            'line-cap': 'round'
                        },
                        paint: {
                            'line-color': '#0000FF',
                            'line-width': 10,
                            'line-opacity': 0.85
                        }
                    });
                }
                // add turn instructions here at the end
                // get the sidebar and add the instructions

                var instructions = document.getElementById('instructions');
                //var finishedWork = document.getElementById('finishedWork');
                // var ratingPopup = document.getElementById("ratingPopup");
                var steps = data.legs[0].steps;
                //$("#instructions").hide();
                //$("#ratingPopup").hide();
                //$('#finishedWork').hide();
                var tripInstructions = [];
                for (var i = 0; i < steps.length; i++) {
                    tripInstructions.push('<br><li>' + steps[i].maneuver.instruction) + '</li>';
                    instructions.innerHTML = '<span class="duration">Arrival Time: ' + Math.floor((data.duration / 60) / 60) + ' hour ' + Math.floor((data.duration / 60) % 60) + ' min 🚴 </span>';

                }

                if (confirmcheck == 1) {
                    document.getElementById("instructions").style.visibility = 'visible';
                }



                // success = 0;

                // ratingPopup.innerHTML = '<h4 style = "color : #000099; font-weight: bold"> please give rating to worker: </h4>' +
                //     '<span class="fa fa-star checked1" id= "1" onClick = "starmark(' + 1 + ')" style = "font-size:30px; cursor: pointer "></span>' +
                //     '<span class="fa fa-star checked1" id= "2" onClick = "starmark(' + 2 + ')" style = "font-size:30px; cursor: pointer "></span>' +
                //     '<span class="fa fa-star checked1" id= "3" onClick = "starmark(' + 3 + ')" style = "font-size:30px; cursor: pointer "></span>' +
                //     '<span class="fa fa-star checked1" id= "4" onClick = "starmark(' + 4 + ')" style = "font-size:30px; cursor: pointer "></span>' +
                //     '<span class="fa fa-star checked1" id= "5" onClick = "starmark(' + 5 + ')" style = "font-size:30px; cursor: pointer "></span>';

                // ratingPopup.innerHTML += '<div>' + '<button style = "margin:5px" class = "btn btn-primary" onClick = "submitStars()"> submit </button>' + '</div>';

            };

            req.send();

        }

        function gotoRoute(name, lng, lat) {
            var html = "";

            html += "<b>" + name +"</b>";
            html += "<br>";
            html += "<br>";
            html += "<div>" + '<button type = "button" class = "btn btn-primary" onClick = "confirmRoute(' + lat + ', ' + lng + ')"> Go to Route </button>' + "</div>"

            return html;
        }
    </script>

</body>

</html>