@extends('layouts.admin-layout')
@section('body')
<div class="xl:px-24 px-4 py-4 grid grid-rows-auto grid-cols-1 justify-items-center">
  <div class='flex xl:flex-row flex-col items-center justify-center w-full relative'>
    <h1 class='text-5xl text-center py-8'>@lang('Update Attraction')</h1>
    <div class='xl:absolute xl:right-0'>
      <x-a :url="route('admin.list.attraction')" :name="__('Attractions list')"/>
    </div>
  </div>
</div>
<div class="flex justify-start items-center flex-col space-y-8 w-full px-6 xl:px-24 py-4">
  <form method="POST" enctype="multipart/form-data" action="{{route("admin.update.attraction", $id)}}" class="w-full space-y-4 grid  grid-cols-1 gap-4">
    @csrf
    @method("PUT")
    <input type="hidden" value="{{$id}}"/>

    <div class="grid gap-4">
      <div class="w-full grid">
        <label for="title" class="text-4xl">@lang('Title'):</label>
        <x-input :type="'text'" :name="'title'" :value="$title" :id="'title'"/>
      </div>

      <div class="grid">
        <label for="description" class="text-4xl">@lang('Description'):</label>
        <textarea type="text" name="description" placeholder="@lang('Description')" class="p-4 bg-black/[.10] text-black rounded-lg placeholder:text-black">{{$description}}</textarea>
      </div>

      <div class="w-full grid max-h-min">
        <label for="image" class="text-4xl">@lang('Image'):</label>
        <x-input :type="'file'" :name="'image'" :id="'image'"/>
      </div>

      <div class="col-end-2">
        <img src="{{$img}}" alt="@lang('Attraction Image')" class="rounded">
      </div>

      <div>
    </div>

      <fieldset>
      <legend class="text-xl">@lang('Coordinates')</legend>

      <input required id="lat" type="hidden" name="lat" value="{{$lat}}"/>
      <input required id="lon" type="hidden" name="lon" value="{{$lon}}"/>

      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

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
          const lat_in = document.getElementById("lat");
          const lon_in = document.getElementById("lon");

          if (lat_in === null || lon_in === null) {
            throw new Error(/* TODO */);
          }

          L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
          }).addTo(map);

          const marker = L.marker(coords, {alt: "Attraction location"});

          marker.addTo(map);
          marker.setLatLng({ lat: {{$lat}}, lng: {{$lon}} });
          map.on("click", (e) => {
            lat_in.value = e.latlng.lat;
            lon_in.value = e.latlng.lng;

            marker.setLatLng(e.latlng);

            if (!marker_added) {
            marker.addTo(map);
            }
          });
        });
      </script>
    </fieldset>
      <x-submit :value="'Update'"/>
    </div>
  </form>
  <div class="w-full xl:w-auto grid grid-row-2 gap-4 xl:grid-cols-2">
    <x-a :url="route('admin.edit.attraction.gallery', ['id' => $id])" :name="__('Update Gallery')"/>
    <x-a :url="route('admin.creator.location', ['id' => $id])" :name="__('Update Close Locations')"/>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", async function() {
    const img = document.getElementById("img");
    const img_in = document.getElementById("img_in");

    if (img == null || img_in == null) {
      return;
    }

    img_in.addEventListener("change", async function() {
      img.src = URL.createObjectURL(img_in.files[0]);
    });
  });
</script>

@endsection
