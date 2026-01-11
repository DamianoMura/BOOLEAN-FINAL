<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        {{Auth::user()->getRoleLabel() }} , {{ __('Projects') }}

      </h2>


    </div>
  </x-slot>
  <div class="w-full border border-gray-200 bg-gradient-to-r from-gray-50 to-white">
   <div class="border-t">
   <div class="px-3 py-3 border-t sm:px-4">
    <!-- Projects List -->
    <div class="p-4 sm:p-6">
      <ul class="space-y-4">
        @foreach ($projects as $project)
        <li class="flex flex-col p-4 transition-colors duration-200 border border-gray-100 rounded-lg bg-gradient-to-r from-gray-50/50 to-white hover:border-blue-200 sm:flex-row sm:items-center sm:justify-between">
          
          <!-- Project Info -->
          
            <!-- Project ID and Title -->
            <div class="flex items-center space-x-3">
              <div
                class="flex items-center justify-center w-10 h-10 border border-blue-200 rounded-full bg-gradient-to-br from-blue-100 to-blue-50">
                <span class="font-semibold text-blue-700 capitalize">{{ $project->id
                  }}</span>
              </div>
              <div class="flex flex-col">
                <span class="text-lg font-semibold text-gray-800 capitalize sm:text-3xl">{{
                  $project->title }}</span>
                <p class="mt-1 text-xs capitalize {{ $project->published ? 'text-green-500' : 'text-red-500' }}">
                  {{ $project->published ? 'published' : 'not published' }}
                </p>
              </div>
             
            </div>
          <div class="flex items-center mt-3 space-x-3 sm:mt-0">
            <a href="{{route('projects.show', $project->id)}}" class="items-center">
              <i class="fa-solid fa-eye"></i>
              view
            </a>
            @if($project->hasUserAssigned(Auth::id()))
            
            <div class="items-center self-end px-4 py-2 text-green-500 bg-green-200 border border-green-500 rounded-lg">
              <span>Edit</span>
              <a href="{{route('projects.edit',$project->id)}}"><i class="fa-solid fa-pen-ruler"></i></a>
            </div>
            @endif
          </div>
        </li>
  

        @endforeach
      </ul>
    </div>
  </div>
   </div>
  </div>




</x-app-layout>