<div class='grid grid-cols-2 gap-1'>
  <a href="{{route('language', ['locale' => 'en'])}}" class='py-1 px-2 @if($current == 'EN') bg-slate-700 @else bg-slate-500 @endif hover:bg-slate-600 text-white text-xs rounded flex flex-row justify-between'>
    <p class="text-xl">EN</p>
    <div class="w-12">
      <img src="{{asset('images/uk.jpg')}}" alt="Portugal flag">
    </div>
  </a>
  <a href="{{route('language', ['locale' => 'pt'])}}" class='py-1 px-2 @if($current == 'PT') bg-slate-700 @else bg-slate-500 @endif hover:bg-slate-600 text-white text-xs rounded flex flex-row justify-between'>
    <p class="text-xl">PT</p>
    <div class="w-12">
      <img src="{{asset('images/pt.jpg')}}" alt="Portugal flag">
    </div>
  </a>
</div>