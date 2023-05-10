@extends('layouts.layout')
@section('body')
  <div class="w-full h-36 pt-10">
    <div class="fixed h-10 top-0 grid grid-cols-3 grid-rows-1 justify-items-center w-full">
      <a href="{{route('view', ['title_compiled' => $title_compiled])}}" class="w-full"><h2 class="text-lg flex flex-row items-center justify-center h-full">Attraction</h2></a>
      <a href="{{route('view.gallery', ['title_compiled' => $title_compiled])}}" class="w-full"><h2 class="text-lg flex flex-row items-center justify-center h-full">Gallery</h2></a>
      <a href="{{route('view.map', ['title_compiled' => $title_compiled])}}" class="w-full"><h2 class="text-lg flex flex-row items-center justify-center h-full">Map</h2></a>
    </div>
    <div class="w-full flex items-center justify-center p-8">
      <h1 class="text-5xl">{{$title}}</h1>
    </div>
    <div class="flex items-center justify-center">
      <img src="{{$image}}" alt="Attraction Image">
    </div>
    <div class="w-full flex items-center justify-center p-8">
      <p class="text-lg"><?= $description ?></p>
    </div>
  </div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

<div id="map"></div>
<style>
  #map {
    aspect-ratio: 4/3;
    max-height: 35ch;
  }
</style>

<script>
  const coords = [<?=$lat?>, <?=$lon?>];
  const ZOOM = 13;

  const map = L.map("map").setView(coords, ZOOM);

  document.addEventListener("DOMContentLoaded", () => {
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const marker = L.marker(coords, {alt: "Attraction location"});
    marker.addTo(map);
    marker.setLatLng({ lat: <?=$lat?>, lng: <?=$lon?> });
  });
</script>
@endsection
{{--
  Image src = {{$image}}
  Title = {{$title}}
  Description = {{$description}}
--}}
{{--
  @vite('resources/css/print-qr.css')
  @vite('resources/js/print-qr.js')
  <header>
  <h1 id="attraction-title">{{$title}}</h1>
  </header>
  <main class="main">
  <section>
  <h2>Image:</h2>
  <img src="{{$image}}" alt="image" />
  <h2>Description:</h2>
  <p>{{$description}}</p>
  </section>
  <aside>
  <figure>
  <img id="qr" src="{{$qr}}" alt="image" />
  <figcaption>
  <h1>Scan to Discover</h1>
  <p class="flex" ><button id="share" class="button" type="button">Share it!</button></p>
  <p>{{$title}}</p>
  </figcaption>
  </figure>
  </aside>
  </main>
  @endsection
--}}
