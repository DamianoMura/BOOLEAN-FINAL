<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between text-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
              {{Auth::user()->getRoleLabel() }} , {{ __('Dashboard') }}
                
            </h2>
            @if (session('status'))
            <dev class="self-center p-2 text-center text-green-500 border border-green-500 rounded-lg">
                {{ session('status')}}
            </dev>
            @endif
       
        </div>
    </x-slot>

            <div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg ">
              {{-- {{dd($components)}} --}}
              @foreach ($components as $component)
                <x-dynamic-component :component="$component" />
              @endforeach
            </div>
        
   
</x-app-layout>
