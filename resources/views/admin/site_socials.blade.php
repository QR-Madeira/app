@extends('layouts.admin-layout')
@section('body')

<nav class="grid sm:grid-cols-5 gap-3">
<div class="sm:row-start-1"></div>
<h1 class='row-start-1 sm:col-span-3 text-center text-5xl py-8'>@lang('Change Website Socials')</h1>
<a class="a-btn" href="{{route("admin.edit.site")}}">@lang("Edit") @lang("Site Socials")</a>
</nav>

@if(!empty($socials))

<div class="m-4">
<table class="border w-full">

<colgroup><col><col>
<colgroup><col>

<thead>
<tr>
<th>@lang("Icon")
<th>@lang("URI")
<th>@lang("Manage")
</tr>
</thead>

<tbody id="socials-list">

@foreach($socials as $s)
<tr data-social-id="{{$s->id}}">
<td><a target="_blank" href="{{$s->uri}}"><img src="/images/{{$s->ico}}" width="32" class="w-[32px] aspect-square object-cover" alt="{{$s->description}}" /></a></td>
<td><a class="url" href="{{$s->uri}}">{{$s->description}}</a></td>
<td>
<menu class="flex flex-col gap-4 py-4 [&>li>button]:w-full [&>li]:mx-4">
<li><button class="a-btn" data-action="update" type="button">@lang("Update")</button></li>
<li><button class="a-btn" data-action="delete" type="button">@lang("Delete")</button></li>
</menu>
</td>
</tr>
@endforeach

</tbody>

<caption>
<details>
<summary>@lang("What are the Site's Socials?")</summary>
<p>@lang("Are the anchors you would like to appear on the footer of the website").</p>
</details>
</caption>

</table>

</div>

<p>{{$socials->links()}}</p>

@else

<p>No Site Socials created yet</p>

@endif

<form name="socials" class="p-4">
@csrf

<input name="actor" type="hidden" />

<div class="p-4 flex flex-col sm:grid sm:grid-cols-2 gap-4 [&>p>label]:flex [&>p>label]:gap-2 [&>p>label]:sm:items-center [&>p>label]:items-start [&>p>label]:flex-col [&>p>label]:sm:flex-row [&>p>label>input]:w-full">
<p><label>@lang("Description"): <input required type="text" name="description" class="form-in" /></label></p>
<p><label>@lang("Link"): <input required type="url" autocomplete="url" inputmode="url" name="uri" class="form-in" /></label></p>
</div>

<div class="p-4 grid grid-cols-2 gap-4 [&>p>*]:w-full">
<p><button class="form-submit" type="submit">@lang("Save")</button></p>
<p><button class="form-submit" type="reset">@lang("Reset")</button></p>
</div>

</form>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.forms.namedItem("socials");

    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const body = new FormData(e.target);

        const actor = body.get("actor").trim();
        if (actor) {
            body.set("_method", "PUT");
        }
        const resource = `{{route("admin.site_socials")}}/${actor}`;

        fetch(resource, {
            method: "POST",
            body,
        }).then(async (res) => {
            if (!res.ok) {
                throw new Error(await res.text());
            }

            return res;
        }).then((res) => res.text())
        .then((text) => {
            location.reload();
        }).catch((e) => {
            console.error(e);
        });
    });

    form.querySelector("button[type=\"reset\"]")
        .addEventListener("click", () => form.actor.value = "");

    const list = document.getElementById("socials-list");

    const rows = list.querySelectorAll("tbody > tr");
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];

        const id = row.getAttribute("data-social-id");
        const btns = row.querySelectorAll("button[data-action]");
        for (let j = 0; j < btns.length; j++) {
            const btn = btns[j];
            switch (btn.getAttribute("data-action")) {
            case "update":
                btn.addEventListener("click", () => {
                    const uri = row.querySelector(".url");

                    form.actor.value = id;
                    form.uri.value = uri.href;
                    form.description.value = uri.innerText;
                });
                break;
            case "delete":
                btn.addEventListener("click", () => {
                    const body = new FormData(form);
                    body.set("_method", "DELETE");

                    const resource = `{{route("admin.site_socials")}}/${id}`;

                    fetch(resource, { method: "POST", body }).then(async (res) => {
                        if (!res.ok) {
                            throw new Error(await res.text());
                        }

                        return res;
                    }).then((res) => res.text())
                    .then((text) => {
                        location.reload();
                    }).catch((e) => {
                        console.error(e);
                    });
                });
                break;
            }
        }
    }
});
</script>

@endsection
