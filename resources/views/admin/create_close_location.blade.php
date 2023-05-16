@extends('layouts.admin-layout')
@section('body')
<div class='py-4 px-24'>

<nav class="grid grid-cols-5 gap-3">
<a class="a-btn" href="{{route('admin.edit.attraction', [ 'id' => $attraction->id ])}}">{{$attraction->title}}</a>
<h1 class='col-span-3 text-center text-4xl antialiased font-bold py-7'>@lang('Create Close Locations')</h1>
<a class="a-btn" href="{{route('admin.list.attraction')}}">Attractions list</a>
</nav>

<h2 class='text-center text-3xl py-6'>@lang('Attraction'): <b>{{$attraction->title}}</b></h2>

@if(count($attraction_locations) != 0)
<table class="border border-slate-500 w-full">
    <thead class="border border-slate-500">
        <tr>
            <th>Icon</th>
            <th>Name</th>
            <th>Location</th>
            <th>Phone Number</th>
            <th>Manage</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attraction_locations as $attr_loc)
        <x-delete-alert :route="route('admin.delete.location', ['id' => $attraction->id, 'id_2' => $attr_loc->id])" :id="$attr_loc->id" />
        <tr>
            <td><span class="material-symbols-rounded fs-36">{{$attr_loc->icon}}</span></td>
            <td>{{Str::limit($attr_loc->name, 20)}}</td>
            <td>{{Str::limit($attr_loc->location, 60)}}</td>
            <td>{{$attr_loc->phone}}</td>
            <td>
                <x-a :url="route('admin.edit.location', ['id' => $attraction->id, 'id_2' => $attr_loc->id])" :name="__('Edit')" />
                <button onclick="document.getElementById('{{$attr_loc->id}}').style.display = 'block';" class='py-4 px-6 rounded bg-red-600 text-white'>@lang('Delete')</button>
            </td>
        </tr>
        @endforeach
    </tbody>
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

<p><label for="close_icon">Choose an icon for your location: </label></p>
<select name="icon" id="close_icon" class="max-w-min h-auto material-symbols-rounded fs-base">
    @foreach($icons as $ico)
    <option @if(($icon ?? old("icon")) === $ico) selected @endif value="{{$ico}}">{{$ico}}</option>
    @endforeach
</select>

<p><label class="flex">Name: <input required type="text" name="name" value="{{$name ?? old('name')}}" class="form-in" /></label></p>
<p><label class="flex">Location: <input required type="text" name="location" value="{{$location ?? old('location')}}" class="form-in" /></label></p>
<p><label class="flex">Phone: <input type="tel" name="phone" value="{{$phone ?? old('phone')}}" class="form-in" /></label></p>
<button type="submit" class="form-submit">{{!empty($isPUT) ? "Save" : "Add"}} location</button>

</form>

@if(Session::has('status') && Session::has('message'))
<x-success_error_msg :status="Session::get('status')" :msg="Session::get('message')" />
@endif

</div>
@endsection
