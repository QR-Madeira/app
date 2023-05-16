<input 
  type="{{$type}}" 
  name="{{$name}}" 
  placeholder="@lang($placeholder)"
  @if($step) step="{{$step}}" @endif 
  @if($min) min="{{$min}}" @endif 
  @if($value) value="{{$value}}" @endif 
  @if($multiple) multiple @endif
  class="p-4 bg-black/[.10] text-black rounded-lg placeholder:text-black">
