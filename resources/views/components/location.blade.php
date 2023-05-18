<div class="flex w-full grid grid-cols-3 gap-4 sm:grid-cols-10 p-4">
    <div class="col-span-1 flex">
        <span class="material-symbols-rounded ml-auto fs-48">{{$location->icon}}</span>
    </div>
    <div class="col-span-2">
        <h3 class="text-3xl">{{$location->name}}</h3>
        <p>{{$location->location}}</p>
        <p>{{$location->phone}}</p>
    </div>
</div>
