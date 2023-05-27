@extends('layouts.basic')
@section('body')
<div class="p-4">
    <div class="flex items-center justify-center w-full">
        <h1 class="text-center text-5xl py-8">@lang("Recover Password")</h1>
    </div>
    <form class="grid grid-cols-1 gap-4" action="{{route('forgor')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <p><label>Email: <input required type="email" name="email" value="{{old('email')}}" class="form-in" /></label></p>
        <p><button type="submit" class="form-submit">@lang("Recover Password")</button></p>
    </form>
</div>
@endsection
