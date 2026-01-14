{{-- <x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        {{Auth::user()->getRoleLabel() }} , {{ __('Projects') }}

      </h2>


    </div>
  </x-slot>
  <div class="w-full border border-gray-200 bg-gradient-to-r from-gray-50 to-white">
   <div class="border border-gray-300 rounded-lg">
      <div class="flex justify-between px-6 py-3">
        <h2 class="flex items-center text-xl font-bold text-gray-800 sm:text-2xl">
          <i class="fa-solid fa-folder-tree"></i>
          <span class="ml-2">Project Index</span>
        </h2>
        <a href="{{route('projects.create')}}"><i class="p-3 text-3xl text-green-500 fa-solid fa-folder-plus "></i></a>
      </div>
   <div class="px-3 py-3 border-t sm:px-4">
    <!-- Projects List -->
    <div class="p-4 sm:p-6">
      <ul class="space-y-4">
        @foreach ($projects as $project)
        <x-project-snap :project="$project"/>
  

        @endforeach
      </ul>
    </div>
  </div>
   </div>
  </div>




</x-app-layout> --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        {{ Auth::user()->getRoleLabel() }}, {{ __('Projects') }}
      </h2>
    </div>
  </x-slot>

  <div class="w-full border border-gray-200 bg-gradient-to-r from-gray-50 to-white">
    <div class="border border-gray-300 rounded-lg">
      <!-- Header con statistiche e creazione -->
      <div class="flex flex-col px-6 py-4 space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
        <div class="flex items-center">
          <i class="text-2xl text-blue-600 fa-solid fa-folder-tree"></i>
          <div class="ml-3">
            <h2 class="text-xl font-bold text-gray-800 sm:text-2xl">Project Index</h2>
            <p class="text-sm text-gray-600">
              {{ $stats['total'] }} total • {{ $stats['published'] }} published  @admin • {{ $stats['drafts'] }} drafts @endadmin
            </p>
          </div>
        </div>
        @admin
        <div class="flex items-center space-x-3">
          <!-- Pulsante crea progetto -->
          <a href="{{ route('projects.create') }}"
            class="flex items-center px-4 py-2 text-sm font-medium text-green-700 bg-green-100 border border-green-300 rounded-lg hover:bg-green-200">
            <i class="mr-2 fa-solid fa-folder-plus"></i>
            New Project
          </a>
        </div>
        @endadmin
      </div>

      <x-filters-menu :stats="$stats"/>
   

      <!-- Projects List -->
      <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
        @if($projects->count() > 0)
        <div class="space-y-4">
          @foreach($projects as $project)
          
            <x-project-snap 
            :project="$project"/>

           
          
          @endforeach
        </div>

        @else
        <!-- Empty State -->
        <div class="py-12 text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 mb-4 bg-blue-100 rounded-full">
            <i class="text-2xl text-blue-600 fa-solid fa-folder-open"></i>
          </div>

          <h3 class="mb-2 text-xl font-semibold text-gray-800">
            @if(request()->hasAny(['search', 'category', 'technology', 'published']))
            No projects match your filters
            @else
            No projects yet
            @endif
          </h3>

          <p class="mb-6 text-gray-600">
            @if(request()->hasAny(['search', 'category', 'technology', 'published']))
            Try adjusting your search or filters
            @else
            Start by creating your first project
            @endif
          </p>

        </div>
        @endif
      </div>

    
    </div>
  </div>
</x-app-layout>