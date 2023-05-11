@if($lat == null || $lon == null)
  <div class="w-full flex justify-center items-center fixed">
    <h1 class="text-4xl">There is no map</h1>
  </div>
@else
  <div id="map" class="w-full h-full"></div>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

  <style>
    #map {
      aspect-ratio: 4/3;
      max-height: 35ch;
    }
  </style>

  <script>
    const coords = [{{$lat}}, {{$lon}}];
    const ZOOM = 13;

    const map = L.map("map").setView(coords, ZOOM);

    document.addEventListener("DOMContentLoaded", () => {
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      }).addTo(map);

      const marker = L.marker(coords, {alt: "Attraction location"});
      
      marker.addTo(map);
      marker.setLatLng({ lat: {{$lat}}, lng: {{$lon}} });
    });
  </script>
@endif
