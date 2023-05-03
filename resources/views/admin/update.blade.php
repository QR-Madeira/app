@extends('layouts.admin-layout')
@section('body')
<main>
    <form method="POST" enctype="multipart/form-data" action="<?= route("admin.update", $id) ?>">
        @csrf
        @method("PUT")
        <input type="hidden" value="<?= $id ?>" />
        <p><label>Title: <input type="text" name="title" value="<?= $title ?>" /></label></p>
        <p><label>Description: <input type="text" name="description" value="<?= $description ?>" /></label></p>
        <p><button type="submit">Update</button></p>
    </form>
</main>
@endsection
