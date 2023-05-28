@extends('layouts.admin-layout')

@section('body')
<div class="py-4 px-4 lg:px-24">

<nav class="py-4 grid sm:grid-cols-5 gap-3">
<div class="sm:row-start-1"></div>
<h1 class="row-start-1 sm:col-span-3 text-center text-4xl antialiased font-bold py-7">@lang("Create Attraction")</h1>
<a class="a-btn" href="{{route('admin.list.attraction')}}">@lang("Attractions List")</a>
</nav>

@if(isset($isPUT) && $isPUT)
<a class="my-4 a-btn" href="{{route('admin.creator.location', ['id' => $id])}}">@lang("Update Close Locations")</a>
@endif

<x-show-required :errors="$errors" />

<form class="sm:grid sm:grid-cols-2 gap-4" action="{{route('admin.' . ((isset($isPUT) && $isPUT) ? 'update' : 'create') . '.attraction', (isset($isPUT) && $isPUT) ? [ 'id' => $id ] : [])}}" method="POST" enctype="multipart/form-data">
@csrf
@if(isset($isPUT) && $isPUT)
@method("PUT")
@endif

<div class="grid gap-4 [&>p>label]:flex [&>p>label]:justify-between [&>p>label]:flex-col [&>p>label]:sm:flex-row">

<p><label>@lang("Title"): <input required type="text" name="title" value="{{$title ?? old('title')}}" class="form-in" /></label></p>

<fieldset>
<legend>@lang("Description")</legend>
<div class="flex">
<select name="description_lang" id="lang-select">
@foreach($langs as $l)
<option value="{{$l}}" @if($l === $cur_lang) selected @endif>{{Str::upper($l)}}</option>
@endforeach
</select>
<textarea id="desc" required name="description" class="form-in w-full" rows="10">{{$description ?? old('description')}}</textarea>
</div>

@if(isset($isPUT) && $isPUT)
<script>
document.getElementById("lang-select").onchange = e => {
    e.target.value = e.target.value === "pt" ? "en" : "pt";
    e.target.form.submit();
}
</script>
@endif

</fieldset>

<fieldset class="flex flex-col py-4 [&>p]:py-4">

<legend class="text-xl">@lang("Images")</legend>

<p><label>@lang("Attraction Image"): <input @if(!isset($isPUT) || !$isPUT) required @endif type="file" name="image" class="form-in" /></label></p>

@if(isset($img))
<img src="{{$img}}" alt="@lang('Attraction Image')" class="rounded p-4 mx-auto">
@endif

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

@if(isset($isPUT) && $isPUT)
<a class="a-btn" href="{{route('admin.edit.attraction.gallery', ['id' => $id])}}">@lang("Update Gallery")</a>
@else
<p><label>@lang("Attraction Gallery"): <input type="file" multiple name="gallery[]" class="form-in" /></label></p>
@endif

</fieldset>

</div>

<fieldset class="py-4">
    <legend class="text-xl">@lang('Coordinates')</legend>

    <input required id="lat" type="hidden" name="lat" value="{{$lat ?? old('lat') ?? ''}}" />
    <input required id="lon" type="hidden" name="lon" value="{{$lon ?? old('lon') ?? ''}}" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    <div id="map"></div>
    <style>
        #map {
            aspect-ratio: 4/3;
        }
    </style>

    <script>
        let lat = {{$lat ?? old("lat") ?? 0}};
        let lon = {{$lon ?? old("lon") ?? 0}};
        const ZOOM = 13;

        @if(!isset($isPUT) || !$isPUT)
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition((pos) => {
                const {
                    latitude,
                    longitude
                } = pos.coords;
                lat = latitude;
                lon = longitude;
            }, (err) => {}, {
                maximumAge: Infinity
            });
        }
        @endif

        const map = L.map("map").fitWorld();

        document.addEventListener("DOMContentLoaded", () => {
            const lat_in = document.getElementById("lat");
            const lon_in = document.getElementById("lon");

            if (lat_in === null || lon_in === null) {
                throw new Error( /* TODO */ );
            }

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            const marker = L.marker([lat, lon], {
                alt: "Attraction location"
            });
            let marker_added = false;

            @if(!isset($isPUT) || !$isPUT)
            map.locate({
                setView: true,
                maxZoom: ZOOM
            });
            map.on('locationfound', (e) => {
                marker.setLatLng(e.latlng);

                if (!marker_added) {
                    marker.addTo(map);
                }
            });
            @else
            map.setView([lat, lon], ZOOM);
            marker.addTo(map);
            @endif

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

<button type="submit" name="submited" value="true" class="w-full col-span-2 form-submit">@lang(!empty($isPUT) ? "Save" : "Create")</button>

</form>

@if(Session::has("status") && Session::has("message"))
<x-success_error_msg :status="Session::get('status')" :msg="Session::get('message')" />
@endif

</div>
@endsection
