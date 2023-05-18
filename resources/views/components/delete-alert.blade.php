<div id="{{$id}}" class='absolute w-screen h-screen bg-black/[.60] top-0 left-0' style="display: none;">
  <div class="absolute top-12 left-1/2 py-4 px-8 bg-black/[.80] text-white rounded" style="transform: translate(-50%);">
    <div class="flex flex-col items-center justify-start">
      <h1 class="text-2xl">@lang('Are you sure you want to delete this?')</h1>
      <div class='flex justify-end w-full pt-4'>
        <a href="{{$route}}" class='py-4 px-6 bg-red-500 rounded mr-4'>@lang('Yes')</a>
        <a onclick="document.getElementById('{{$id}}').style.display = 'none';" class='py-4 px-6 bg-green-500 rounded cursor-pointer'>@lang('No')</a>
      </div>
    </div>
  </div>
</div>