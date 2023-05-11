var map = L.map('map');
var popup = L.marker();

navigator.geolocation.getCurrentPosition(function(position) {
  // Get the user's latitude and longitude
  var lat = position.coords.latitude;
  var lng = position.coords.longitude;
  map.setView([lat, lng], 12);
  popup.setLatLng([lat, lng]).addTo(map);
  document.getElementById("loc").value = [lat, lng];
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
          '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
          'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      }).addTo(map);


function onMapClick(e) {
    document.getElementById("loc").value = e.latlng;
    document.getElementById("address").value = e.latlng.lat + ', ' + e.latlng.lng;
    popup
        .setLatLng(e.latlng)
        .addTo(map);
}


document.getElementById("search").addEventListener("click", function() {
  var address = document.getElementById("address").value;
  var url = "https://nominatim.openstreetmap.org/search?q=" + encodeURIComponent(address) + "&format=json";

  // Make AJAX request
  var xhr = new XMLHttpRequest();
  xhr.open("GET", url);
  xhr.onload = function() {
    if (xhr.status === 200) {
      var result = JSON.parse(xhr.responseText);
      if (result.length > 0) {
        var lat = result[0].lat;
        var lng = result[0].lon;
        popup
            .setLatLng([lat, lng])
            .addTo(map);
        map.setView([lat, lng], 14);
        document.getElementById("loc").value = [lat, lng];
      } else {
        document.getElementById("address").placeholder = "Location not found";
        document.getElementById("address").value = null;
      }
    } else {
      document.getElementById("address").placeholder ="Error: " + xhr.status;
      document.getElementById("address").value = null;
    }
  };
  xhr.send();
});
map.on('click', onMapClick);
