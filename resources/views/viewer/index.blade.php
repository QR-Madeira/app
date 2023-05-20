@extends('layouts.basic')
@section('body')
<div class="p-4 w-screen">

<nav class="py-4 grid sm:grid-cols-5 gap-3">
<a class="a-btn" href="{{route('login')}}">@lang("Login")</a>
<h1 class="row-start-1 sm:col-span-3 text-center text-4xl antialiased font-bold py-7">@lang("Welcome to QR-Madeira")</h1>
<div class="sm:row-start-1"></div>
</nav>

<div class="sm:w-[120ch] my-4 sm:mx-auto">
<p class="text-2xl text-center">The website, called "QR Scan Hub", is a user-friendly platform that allows people to quickly and easily scan QR codes with their smartphones or tablets. The site features a sleek and modern design, with a simple and intuitive interface that makes it easy for users to navigate.<br />When a user scans a QR code using their device's camera, the website instantly recognizes the code and automatically redirects the user to the associated online content. This can include anything from a website or blog post to a video or social media profile.</p>
</div>

</div>
@endsection
