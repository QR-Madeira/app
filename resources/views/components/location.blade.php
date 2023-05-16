<div class="flex w-full grid grid-cols-10 p-4">
    <div class="col-span-1">
        <span class="material-symbols-rounded fs-48">{{$location->icon}}</span>
    </div>
    <div>
        <h3 class="col-span-9 text-3xl">{{$location->name}}</h3>
        <p>{{$location->location}}</p>
        <p>{{$location->phone}}</p>
    </div>
</div>
