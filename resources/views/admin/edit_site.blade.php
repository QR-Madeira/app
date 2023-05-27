@extends('layouts.admin-layout')
@section('body')
<div class='py-4 px-4 lg:px-24'>
    <div class='grid sm:grid-cols-5 gap-3 flex items-center justify-center w-full relative'>
        <div class="sm:row-start-1"></div>
        <h1 class='row-start-1 sm:col-span-3 text-center text-5xl py-8'>@lang('Change Website Information')</h1>
        <div></div>
    </div>
    <x-show-required :errors="$errors" />
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.update.site')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <fieldset class="grid grid-cols-1 gap-4">
            <legend>@lang("Index Page")</legend>
            <p><label>@lang("Title"): <input required type="text" name="title" value="{{$title ?? old('title')}}" class="form-in" /></label></p>
            <fieldset>
                <legend>@lang("Description")</legend>
                <div class="flex">
                    <select name="description_lang" id="lang-select">
                        @foreach($langs as $l)
                        <option label="{{Str::upper($l)}}" value="{{$l}}" @if($l===$cur_lang) selected @endif />
                        @endforeach
                    </select>
                    <textarea id="desc" required name="desc" class="form-in w-full" rows="10">{{$desc ?? old('desc')}}</textarea>
                </div>
                <script>
                    document.getElementById("lang-select").onchange = e => {
                        e.target.value = e.target.value === "pt" ? "en" : "pt";
                        e.target.form.submit();
                    }
                </script>
            </fieldset>
        </fieldset>
        <fieldset class="grid grid-cols-1 gap-4">
            <legend>@lang("Footer")</legend>
            <p><label>@lang("Sede"): <input required type="text" name="footerSede" value="{{$footerSede ?? old('footerSede')}}" class="form-in" /></label></p>
            <p><label>@lang("Phone"): <input required type="text" name="footerPhone" value="{{$footerPhone ?? old('footerPhone')}}" class="form-in" /></label></p>
            <p><label>@lang("E-mail"): <input required type="text" name="footerMail" value="{{$footerMail ?? old('footerMail')}}" class="form-in" /></label></p>
            <p><label>@lang("Copyright"): <input required type="text" name="footerCopyright" value="{{$footerCopyright ?? old('footerCopyright')}}" class="form-in" /></label></p>
        </fieldset>
        <button type="submit" name="submited" value="true" class="form-submit">@lang("Save")</button>
    </form>

    @if(Session::has('status') && Session::has('message'))
    <x-success_error_msg :status="session('status')" :msg="session('message')" />
    @endif

    <!--
    <hr />

    <div class='grid sm:grid-cols-5 gap-3 flex items-center justify-center w-full relative'>
        <div class="sm:row-start-1"></div>
        <h1 class='row-start-1 sm:col-span-3 text-center text-5xl py-8'>@lang('Change Website Socials')</h1>
        <div></div>
    </div>
    <x-show-required :errors="$errors" />

    <ul>
        @foreach($socials as $s)
        <li>{{$s}}</li>
        @endforeach
    </ul>

    <form>

    <p><label>@lang("Description"): <input required type="text" name="description" value="{{$description ?? old('description')}}" class="form-in" /></label></p>
    <p><label>@lang("Link"): <input required type="url" name="uri" value="{{$uri ?? old('uri')}}" class="form-in" /></label></p>

    </form>

    @if(Session::has('status') && Session::has('message'))
    <x-success_error_msg :status="session('status')" :msg="session('message')" />
    @endif

    -->
</div>
@endsection
