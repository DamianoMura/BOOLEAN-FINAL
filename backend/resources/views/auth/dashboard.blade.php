<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
              {{Auth::user()->getRoleLabel() }} , {{ __('Dashboard') }}
                
            </h2>
           
       
        </div>
    </x-slot>

            
              {{-- {{dd($components)}} --}}
              @foreach ($components as $component)
                <x-dynamic-component 
                :component="$component" />
              @endforeach
            
        
   
</x-app-layout>
