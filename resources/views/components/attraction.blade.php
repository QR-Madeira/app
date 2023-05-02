<div class='grid grid-cols-6 p-4 w-full h-36'>
  <x-delete-alert :route="route('admin.delete', ['id' => $attraction->id])" :id="$attraction->id"/>
  <div class="h-28 w-28 flex flex-row items-center">
    <a target="_blank" href="<?=route('view', ['title_compiled' => $attraction->title_compiled])?>?print=true"><img src="{{ asset($attraction['qr-code']) }}" alt="Local Image" class='w-full h-full'></a>
  </div>
  <h1 class='flex flex-row items-center text-xl'>{{$attraction->title}}</h1>
  <h1 class='flex flex-row items-center text-xl max-h-28'>{{$attraction->description}}</h1>
  <h1 class='flex flex-row items-center text-xl max-h-28'>{{$attraction->creator_name}}</h1>
  <h1 class='flex flex-row items-center text-xl max-h-28'>{{$attraction->created_at_}}</h1>
  <div class='flex flex-row items-center w-full justify-start space-x-2'>
    <button onclick="location.href='<?= route('view', ['title_compiled' => $attraction->title_compiled]) ?>'" class='text-xl py-4 px-6 rounded bg-black text-white'>@lang('View')</button>
    <button onclick="document.getElementById('{{$attraction->id}}').style.display = 'block';" class='text-xl py-4 px-6 rounded bg-red-600'>@lang('Delete')</button>
  </div>
</div>
