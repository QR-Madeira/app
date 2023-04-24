@extends('layouts.layout')
@section('body')
<!--
<div class='w-full max-h-screen grid grid-cols-2 justify-items-center p-4'>
  <div class='p-4 flex flex-row justify-start w-full'>
    <div class='w-fit'>
      <img src="{{ $image }}" alt="Local Image" class='w-full rounded-lg'>
    </div>
  </div>
  <div class='p-4 w-full'>
    <div class='text-center'>
      <h1 class='text-6xl'>{{$title}}</h1>
    </div>
    <div class='text-center p-8'>
      <p class='text-lg'><?= $description ?></p>
    </div>
  </div>
</div>
-->
<!-- <link href="../../css/print-qr.css" media="print" rel="stylesheet" /> -->
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
