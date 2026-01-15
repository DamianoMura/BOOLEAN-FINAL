<x-guest-layout >
<div  class="text-center text-red-800 ">
  <h1 class="text-3xl">ERROR :{{$status}}</h1>
  <p class="mb-10">{{$message}}</p>
  @if($status===500)
  <form method="POST" action="{{ route('logout') }}">
    @csrf
  
    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                  this.closest('form').submit();">
      {{ __('Log Out') }}
    </x-dropdown-link>
  </form>
  @else
  <a href="{{route('dashboard')}}" class="p-3 mb-5 text-center text-gray-800 bg-gray-200 border border-gray-800 rounded-lg shadow-3xl shadow-black"> Go back to dashboard</a>
  @endif
</div>
</x-guest-layout>
