@extends('layouts.basic')
@section('body')
<div class="p-4 w-screen">

<nav class="py-4 grid sm:grid-cols-5 gap-3">
  <div class="sm:row-start-1"></div>
  <h1 class="row-start-1 sm:col-span-3 text-center text-4xl antialiased font-bold py-7">@lang("Welcome to QR-Madeira")</h1>
  <a class="a-btn" href="{{route('login')}}">@lang("Login")</a>
</nav>

  <div class="sm:w-[120ch] my-4 sm:mx-auto">
    <p class="text-2xl text-center">
      @if(app()->getLocale() == 'pt')
        {{$welcome}}
      @else
        {{$bemvindo}}
      @endif
    </p>
  </div>

</div>
@endsection
