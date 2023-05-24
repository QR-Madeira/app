@extends('layouts.admin-layout')
@section('body')
<div class='py-4 px-4 lg:px-24'>

<nav class="grid sm:grid-cols-5 gap-3">
<a class="a-btn sm:row-start-1" href="{{route('admin.edit.attraction', [ 'id' => $attraction->id ])}}">{{$attraction->title}}</a>
<h1 class='row-start-1 sm:col-span-3 text-center text-4xl antialiased font-bold py-7'>@lang("Create Close Locations")</h1>
<a class="a-btn" href="{{route('admin.list.attraction')}}">@lang("Attractions List")</a>
</nav>

<h2 class='text-center text-3xl py-6'>@lang('Attraction'): {{$attraction->title}}</h2>

@if(is_iterable($attraction_locations) && (count($attraction_locations) > 0))
<table class="my-4 border border-slate-500 w-full">

<colgroup><col><col><col><col>
<colgroup><col>

<thead class="border border-slate-500">
  <tr>
    <th class="sm:table-cell hidden">@lang("Icon")
    <th>@lang("Name")
    <th class="sm:table-cell hidden">@lang("Location")
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
    <td class="sm:table-cell hidden">{{Str::limit($a->location, 60)}}</td>
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

<caption>
<details>
<summary>@lang("What are the Close Locations?")</summary>
<p>@lang("The \"close locations\" like the name says, are the closest places around the attraction selected, for example: Pharmacies, hospitals, shoppings, museums, hotels.")</p>
</details>
</caption>
<br />

<x-show-required :errors="$errors" />

<form class="grid grid-cols-1 gap-4" action="{{route('admin.' . (!empty($isPUT) ? 'update' : 'create') . '.location', $segs)}}" method="POST" enctype="multipart/form-data">
@csrf
@if(isset($isPUT) && $isPUT)
@method("PUT")
@endif

<p><label for="close_icon">@lang("Choose an icon for your location"): </label></p>
<select name="icon" id="close_icon" class="max-w-min h-auto material-symbols-rounded fs-36">
    @foreach($icons as $ico)
    <option @if(($icon ?? old("icon")) === $ico) selected @endif value="{{$ico}}">{{$ico}}</option>
    @endforeach
</select>

<p><label class="flex flex-col sm:flex-row">@lang("Name"): <input required type="text" name="name" value="{{$name ?? old('name')}}" class="form-in" /></label></p>
<p><label class="flex flex-col sm:flex-row">@lang("Location"): <input required type="text" name="location" value="{{$location ?? old('location')}}" class="form-in" /></label></p>

<fieldset>

<legend>@lang("Phone")</legend>

<div class="flex flex-row justify-center gap-4">
<div class="flex flex-col">

<p><label for="phone-country">@lang("Country"): </label></p>

<!-- Modified from https://gist.github.com/bkmgit/7bab7348aca1a7eb44d05e8f641275fd -->
<select class="max-w-min h-auto fs-base input-block-level" id="phone-country" name="phone_country">
<option value="">...</option>
@foreach($phone_codes as $code => $emoji)
<option @if(($phone_country ?? old("phone_country")) === $code) selected @endif value="263">{!! $emoji !!} (+{{$code}})</option>
@endforeach
</select>

</div>

<p><label class="flex flex-col sm:flex-row">@lang("Phone"): <input type="tel" name="phone" value="{{$phone ?? old('phone')}}" class="form-in" /></label></p>

</div>

</fieldset>
<button type="submit" class="form-submit">@lang(!empty($isPUT) ? "Save" : "Add") @lang("Location")</button>

</form>

@if(Session::has('status') && Session::has('message'))
<x-success_error_msg :status="Session::get('status')" :msg="Session::get('message')" />
@endif

</div>
@endsection
