@extends('layout')
@section('body')
  <div class='flex flex-col items-start justify-start'>
    <div class='w-full flex items-center justify-center p-4 relative'>
      <h1 class='text-6xl'>Welcome to Qr-Madeira</h1>
      <div class='absolute right-0 p-4'>
        <x-a :url="route('admin.login')" :name="'Login'"/>
      </div>
    </div>
    <div class='w-full flex items-center justify-center'>
      <div class='w-1/2'>
        <p class='p-8 text-2xl'>
          The website, called "QR Scan Hub", is a user-friendly platform that allows people to quickly and easily scan QR codes with their smartphones or tablets. The site features a sleek and modern design, with a simple and intuitive interface that makes it easy for users to navigate.<br><br>
          When a user scans a QR code using their device's camera, the website instantly recognizes the code and automatically redirects the user to the associated online content. This can include anything from a website or blog post to a video or social media profile.
        </p>
      </div>
    </div>
  </div>
@endsection