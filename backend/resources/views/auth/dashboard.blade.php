<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
              {{Auth::user()->getRoleLabel() }} , {{ __('Dashboard') }}
                
            </h2>
           
       
        </div>
    </x-slot>

 
                       
            <div x-data="{ activeTab: '{{$first}}' }" class="overflow-hidden border rounded-lg">
            
              <!-- Tabs Header -->
              <div class="flex border-b bg-gray-50">
            
            
                @foreach($components as $component)
                <button @click="activeTab = '{{ $component }}'" :class="{ 
                              'bg-white border-b-2 border-blue-500 text-blue-600': activeTab === '{{ $component }}',
                              'text-gray-600 hover:text-gray-900 hover:bg-gray-100': activeTab !== '{{ $component }}'
                            }" class="flex-1 px-6 py-4 text-sm font-medium transition-colors">
                  <div class="flex items-center justify-center space-x-2 capitalize">
                  
                    {{str_replace('-',' ',$component)}}
                   
                  </div>
                </button>
                @endforeach
              </div>
            
              <!-- Tabs Content -->
             

              <div class="p-6">
                @foreach($components as $component)
                <div x-show="activeTab === '{{ $component }}'" class="space-y-4">
                  <x-dynamic-component :component="$component"/>
                </div>
                @endforeach
              </div>
            </div>
        
   
</x-app-layout>
