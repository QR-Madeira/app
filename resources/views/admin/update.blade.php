@extends('layouts.admin-layout')
@section('body')
<main>

<form method="POST" enctype="multipart/form-data" action="<?= route("admin.update", $id) ?>">

@csrf
@method("PUT")

<input type="hidden" value="<?= $id ?>" />
<p><label>Title: <input type="text" name="title" value="<?= $title ?>" /></label></p>
<p><label>Description: <input type="text" name="description" value="<?= $description ?>" /></label></p>

<fieldset>
<legend>Image</legend>

<img id="img" src="/storage/attractions/<?= $img ?>" alt="image" />
<p><label>Image: <input id="img_in" type="file" name="image" /></label></p>

</fieldset>

<p><button type="submit">Update</button></p>

</form>

</main>
<style>
#img {
    max-width: 124px;
    max-height: 124px;
}
</style>
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
