@extends('layouts.admin-layout')
@section('body')
<div class='py-4 px-4 lg:px-24'>

<nav class="grid sm:grid-cols-5 gap-3">
<a class="a-btn sm:row-start-1" href="{{route('admin.edit.attraction', [ 'id' => $attraction->id ])}}">{{$attraction->title}}</a>
<h1 class='row-start-1 sm:col-span-3 text-center text-4xl antialiased font-bold py-7'>@lang("Create Close Locations")</h1>
<a class="a-btn" href="{{route('admin.list.attraction')}}">@lang("Attractions List")</a>
</nav>

<h2 class='text-center text-3xl py-6'>@lang('Attraction'): {{$attraction->title}}</h2>

<caption>
    <details>
    <summary>@lang("What are the Close Locations?")</summary>
    <p>@lang("The \"close locations\" like the name says, are the closest places around the attraction selected, for example: Pharmacies, hospitals, shoppings, museums, hotels, etc.")</p>
    </details>
</caption>

@if(is_iterable($attraction_locations) && (count($attraction_locations) > 0))
<table class="my-4 border border-slate-500 w-full">

<colgroup><col><col><col><col>
<colgroup><col>

<thead class="border border-slate-500">
  <tr>
    <th class="sm:table-cell hidden">@lang("Icon")
    <th>@lang("Name")
    <th class="sm:table-cell hidden">@lang("Phone Number")
    <th>@lang("Manage")
  </tr>
</thead>

<tbody>
  @foreach($attraction_locations as $a)
  <x-delete-alert :route="route('admin.delete.location', ['id' => $attraction->id, 'id_2' => $a->id])" :id="$a->id" />
  <tr>
    <td class="sm:table-cell hidden"><span class="material-symbols-rounded fs-36">{{$a->icon}}</span></td>
    <td>{{Str::limit($a->name, 20)}}</td>
    <td class="sm:table-cell hidden">{{$a->createPhoneNumber()}}</td>
    <td>
    <div class="py-4 flex flex-col gap-4 h-full">
      <a class="a-btn" href="{{route('admin.edit.location', ['id' => $attraction->id, "id_2" => $a->id ])}}">@lang("Edit")</a>
      <button onclick="document.getElementById('{{$a->id}}').style.display = 'block';" class='a-btn bg-red-600 text-white'>@lang('Delete')</button>
    </div>
    </td>
  </tr>
  @endforeach

</table>

<p>{{$attraction_locations->links()}}</p>

@else
<p class='text-black/50 p-4 text-2xl'>@lang("Currently this attraction doesn't have close locations.")</p>
@endif

<hr class="p-4" />

<x-show-required :errors="$errors" />

<form class="grid grid-cols-1 gap-4" action="{{route('admin.' . (!empty($isPUT) ? 'update' : 'create') . '.location', $segs)}}" method="POST" enctype="multipart/form-data">
@csrf
@if(isset($isPUT) && $isPUT)
@method("PUT")
@endif

<div class="grid grid-cols-2 gap-4">

<div class="flex flex-col gap-4">

<p><label for="close_icon">@lang("Choose an icon for your location"): </label></p>
<select name="icon" id="close_icon" class="max-w-min h-auto material-symbols-rounded fs-36">
    @foreach($icons as $ico)
    <option @if(($icon ?? old("icon")) === $ico) selected @endif value="{{$ico}}">{{$ico}}</option>
    @endforeach
</select>

<p><label class="flex flex-col sm:flex-row">@lang("Name"): <input required type="text" name="name" value="{{$name ?? old('name')}}" class="form-in" /></label></p>

<fieldset>

<legend>@lang("Phone")</legend>

<div class="flex flex-row justify-center gap-4">
<div class="flex flex-col">

<p><label for="phone-country">@lang("Country"): </label></p>

<!-- Modified from https://gist.github.com/bkmgit/7bab7348aca1a7eb44d05e8f641275fd -->
<select class="max-w-min h-auto fs-base input-block-level" id="phone-country" name="phone_country">
<option value="">...</option>
@foreach($phone_codes as $code => $emoji)
<option @if(($phone_country ?? old("phone_country")) === $code) selected @endif value="{{$code}}">{!! $emoji !!} (+{{$code}})</option>
@endforeach
</select>

</div>

<p><label class="flex flex-col sm:flex-row">@lang("Phone"): <input type="tel" name="phone" value="{{$phone ?? old('phone')}}" class="form-in" /></label></p>

</div>

</fieldset>

</div>

<div>

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
        let lat = {{$lat ?? old("lat") ?? $attraction->lat ?? 0}};
        let lon = {{$lon ?? old("lon") ?? $attraction->lon ?? 0}};
        const ZOOM = 13;

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

            L.circle([{{$attraction->lat}}, {{$attraction->lon}}], {
                color: "red",
                radius: 50,
                alt: "attraction location"
            }).addTo(map)
            .bindPopup("The attraction location: {{$attraction->title}}")
            .openPopup();

            @if(isset($isPUT) && $isPUT)
            @foreach($attraction_locations->where("id", "!=", $segs["id"]) as $l)
            L.circle([{{$l->lat}}, {{$l->lon}}], {
                color: "green",
                radius: 50,
                alt: "attraction close location"
            }).addTo(map)
            .bindPopup("The attraction location: {{$l->name}}")
            @endforeach
            @foreach($attraction_locations as $l)
            L.circle([{{$l->lat}}, {{$l->lon}}], {
                color: "green",
                radius: 50,
                alt: "attraction close location"
            }).addTo(map)
            .bindPopup("The attraction location: {{$l->name}}")
            @endforeach
            @else
            @endif

            const marker = L.marker([lat, lon], {
                alt: "Current attraction close location"
            });
            let marker_added = false;

            map.setView([lat, lon], ZOOM);
            marker.addTo(map);

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

</div>

</div>

<button type="submit" class="form-submit">@lang(!empty($isPUT) ? "Save" : "Add") @lang("Location")</button>

</form>

@if(Session::has('status') && Session::has('message'))
<x-success_error_msg :status="Session::get('status')" :msg="Session::get('message')" />
@endif

</div>
@endsection
