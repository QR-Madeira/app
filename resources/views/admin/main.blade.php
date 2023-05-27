@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 sm:px-96 px-4'>
    <h1 class='text-center text-5xl py-8'>@lang("Main")</h1>
    <h2 class='text-center text-3xl py-8'>@lang('Welcome') {{ Auth::user()->name}}!</h2>
  </div>
@endsection
