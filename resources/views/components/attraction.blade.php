<div class='flex items-center justify-start p-4 border-2 rounded border-black w-full h-36 my-4'>
  <div class='w-32 flex items-center justify-center'>
    <div class='w-28 h-28'>
      <img src="{{ asset($attraction['qr-code']) }}" alt="Local Image" class='w-full h-full'>
    </div>
  </div>
  <div class='w-full'>
    <div class='px-4'>
      <h1 class='text-3xl px-4'>{{$attraction->title}}</h1>
    </div>
  </div>
  <div class='w-full'>
    <div class='overflow-auto'>
      <p class='text-lg px-4 max-h-28'>{{$attraction->description}}</p>
    </div>
  </div>
  <div class='w-full flex flex-row items-center justify-end'>
    <div class='pr-1 text-end'>
      <button onclick="location.href='<?= route('view', ['title_compiled' => $attraction->title_compiled]) ?>'" class='text-xl py-4 px-6 rounded bg-black text-white'>View</button>
    </div>
    <div class='pl-1 text-end'>
      <button onclick="location.href='<?= route('admin.delete', ['id' => $attraction->id]) ?>'" class='text-xl py-4 px-6 rounded bg-red-600'>Delete</button>
    </div>
  </div>
</div>