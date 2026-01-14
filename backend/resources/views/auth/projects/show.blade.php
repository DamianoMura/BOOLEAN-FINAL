<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col justify-between w-full sm:flex-row sm:items-center">
      
        <div class="flex items-center justify-between w-full px-3">
          <div class="flex items-center space-x-3 ">
           
            <div>
              <ul class="inline-flex items-center space-x-1 md:space-x-3">
              
                <li>
                  <div class="flex items-center">
                    <i class="text-gray-400 fa-solid fa-chevron-right"></i>
                    <a href="{{ route('projects.index') }}"
                      class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                      Projects
                    </a>
                  </div>
                </li>
                <li aria-current="page">
                  <div class="flex items-center">
                    <i class="text-gray-400 fa-solid fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                      {{ $project->title}}
                    </span>
                  </div>
                </li>
              </ul>
            </div>

          </div>
          <div class="flex-self-right">

            @if($project->author_id == Auth::id())
            <div class="flex flex-col">
              <a
                class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                <i class="mr-2 translate-x-1 sm:translate-x-0 fa-solid fa-trash"></i>
                <span class="hidden sm:flex">Edit</span>
              </a>
              <form action="{{ route('projects.destroy', $project) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this project?')" class="self-right">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                  <i class="mr-2 translate-x-1 sm:translate-x-0 fa-solid fa-trash"></i>
                  <span class="hidden sm:flex">Delete</span> 
                </button>
              </form>
            </div>
            @endif
          </div>
        </div>
    </div>
  </x-slot>

  <div class="w-full py-2 ">
    <div class="mx-auto ">
           <!-- Main Content -->
      <div class="flex flex-col py-3 space-y-3 bg-white rounded-lg">
        <div class="flex justify-between px-3 space-x-3">
          <div class="flex flex-col justify-center px-2 py-3 border border-blue-200 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50">
            <span>
              {{ $project->category->label }}
            </span>
          </div>
          <div class="flex flex-col">
            <span class="text-lg font-semibold text-gray-800 capitalize sm:text-3xl">{{
              $project->title }}</span>
            <div class="flex items-center space-x-3">
              <p class="mt-1 capitalize text-bold ">
                Author :@if($project->author_id==Auth::id()) you @else {{ $project->user->name }} @endif
              </p>
              @admin
              <p class="mt-1 text-xs capitalize {{ $project->published ? 'text-green-500' : 'text-red-500' }}">
                {{ $project->published ? 'published' : 'not published' }}
              </p>
              @endadmin
            </div>
          </div>
          
        </div>
        @if($project->technology->count() > 0)
        <div class="flex flex-wrap gap-1 px-3 -top-2">
          @foreach ($project->technology as $tech)
          <div class="p-1 text-sm text-center bg-blue-100 border border-blue-300 rounded-md">
            <span class=>{{$tech->label}}</span>
            <i class=" {{$tech->fontawesome_class}}"></i>
          </div>
          @endforeach
        </div>
        @endif
        <div class="flex flex-col p-3">
          <h3 class="text-xl font-bold text-center">Description</h3>
          <p class="px-1 py-4">
            {{$project->description}}
          </p>
         <div class="flex flex-col px-2 py-1 text-white bg-gray-500 rounded-lg">
          @if ($project->created_at)<span class="self-end capitalize">created : {{$project->created_at}}</span>@endif
          @if ($project->updated_at)<span class="self-end capitalize">updated : {{$project->updated_at}}</span>@endif
         </div>
        </div>
      </div>
    </div>
  </div>

  
</x-app-layout>
