@extends('layouts.basic')
@section('body')
<div class="m-2">

  <nav class="py-4 grid sm:grid-cols-5 gap-3">
    <div class="sm:row-start-1"></div>
    <h1 class="row-start-1 sm:col-span-3 text-center text-4xl antialiased font-bold py-7">{{$siteInfo['title']}}</h1>
    <a class="a-btn" href="{{route('login')}}">@lang("Login")</a>
  </nav>

  <h2 class="text-xl m-12">{{$siteInfo['desc']}}</h2>

</div>
@endsection
