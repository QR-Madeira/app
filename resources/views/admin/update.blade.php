@extends('layouts.admin-layout')
@section('body')
<main class="flex justify-start items-center flex-col space-y-8 w-full px-24 py-4">
  <h1 class="text-6xl">@lang('Update Attraction')</h1>
  <form method="POST" enctype="multipart/form-data" action="{{route("admin.update", $id)}}" class="w-full space-y-4 grid grid-cols-2 gap-4">
    @csrf
    @method("PUT")
    <input type="hidden" value="{{$id}}"/>

    <div class="grid gap-4">
      <div class="w-full grid">
        <label for="title" class="text-2xl">@lang('Title'):</label>
        <x-input :type="'text'" :name="'title'" :value="$title" :id="'title'"/>
      </div>
      
      <div class="grid">
        <label for="description" class="text-2xl">@lang('Description'):</label>
        <textarea type="text" name="description" placeholder="@lang('Description')" class="p-4 bg-black/[.10] text-black rounded-lg placeholder:text-black">{{$description}}</textarea>
      </div>
      
      <div class="w-full grid max-h-min">
        <label for="image" class="text-2xl">@lang('Image'):</label>
        <x-input :type="'file'" :name="'image'" :id="'image'"/>
      </div>

      <x-submit :value="'Update'"/>
    </div>

    <div>
      <div class="">
        <img src="{{$img}}" alt="@lang('Attraction Image')" class="rounded">
      </div>
    </div>

  </form>
</main>

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
