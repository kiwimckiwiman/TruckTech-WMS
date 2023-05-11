<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Leaflet Map with Search Bar using Nominatim</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
	   integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
	   crossorigin=""/>

	 <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
	    integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
	    crossorigin=""></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet/1.3.1/leaflet.css" />
	<script src="https://cdn.jsdelivr.net/leaflet/1.3.1/leaflet.js"></script>
	<style>
		#mapid { height: 500px; }
	</style>
</head>
<body>
	<div id="mapid"></div>
	<input type="text" id="search-box" placeholder="Enter a location">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		var mymap = L.map('mapid').setView([51.505, -0.09], 13);

		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
							maxZoom: 19
					}).addTo(map);

		var searchControl = L.esri.Geocoding.geosearch().addTo(mymap);

		var results = L.layerGroup().addTo(mymap);

		searchControl.on('results', function (data) {
			results.clearLayers();
			for (var i = data.results.length - 1; i >= 0; i--) {
				results.addLayer(L.marker(data.results[i].latlng));
			}
			var bbox = results.getBounds();
			mymap.fitBounds(bbox);
		});

		$("#search-box").on('keydown', function (event) {
			if (event.keyCode == 13) {
				event.preventDefault();
				searchControl.search($(this).val());
				$(this).blur();
			}
		});
	</script>
</body>
</html>
