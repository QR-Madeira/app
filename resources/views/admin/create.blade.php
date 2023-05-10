@extends('layouts.admin-layout')

@section('body')
<div class='py-4 px-24'>
  <div class='flex items-center justify-center w-full relative'>
    <h1 class='text-center text-5xl py-8'>@lang('Create Attraction')</h1>
    <div class='absolute right-0'>
      <x-a :url="route('admin.list.attraction')" :name="'Attractions List'"/>
    </div>
  </div>
  <x-show-required :errors="$errors"/>
  <form class="grid grid-cols-2 gap-4" action="{{route('admin.create.attraction')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid gap-4">
      <div class="grid">
        <h1 class="text-xl">@lang('Title')</h1>
        <x-input :type="'text'" :name="'title'" :placeholder="'Title'"/>
      </div>
      <div class="grid">
        <h1 class="text-xl">@lang('Description')</h1>
        <textarea type="text" name="description" placeholder="@lang('Description')" class="p-4 bg-black/[.10] text-black rounded-lg placeholder:text-black"></textarea>
      </div>
      <div class="grid">
        <h1 class="text-xl">@lang('Attraction Image')</h1>
        <x-input :type="'file'" :name="'image'" :placeholder="'Image'"/>
      </div>
      <div class="grid">
        <h1 class="text-xl">@lang('Attraction Gallery')</h1>
        <x-input :type="'file'" :name="'gallery[]'" :placeholder="'Gallery'" :multiple="TRUE"/>
      </div>
    </div>

    <fieldset>
      <legend class="text-xl">@lang('Coordinates')</legend>

      <input id="lat" type="hidden" name="lat" />
      <input id="lon" type="hidden" name="lon" />

      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

      <div id="map"></div>
      <style>
        #map {
          aspect-ratio: 4/3;
        }
      </style>

      <script>
        let lat = lon = 0;
        const ZOOM = 13;
        if ("geolocation" in navigator) {
          navigator.geolocation.getCurrentPosition((pos) => {
          const {latitude, longitude} = pos.coords;
          lat = latitude;
          lon = longitude;
          }, (err) => {}, { maximumAge: Infinity });
        }

        const map = L.map("map").fitWorld();

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

          const marker = L.marker([lat, lon], {alt: "Attraction location"});
          let marker_added = false;

          map.locate({setView: true, maxZoom: ZOOM});
          map.on('locationfound', (e) => {
            marker.setLatLng(e.latlng);

            if (!marker_added) {
              marker.addTo(map);
            }
          });

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
    <div class="col-span-2 grid">
      <x-submit :value="__('Create')"/>
    </div>
  </form>
  @if($created)
    <x-attraction-created :route="$route"/>
  @endif
</div>
@endsection
