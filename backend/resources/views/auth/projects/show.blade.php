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
          
        </div>
    </div>
  </x-slot>

  <div class="w-full py-2 ">
    <div class="w-full bg-white shadow rounded-xl">
      <x-admin.project-snap :project="$project" />
       <!-- content -->
       <div class="p-6">
        <!-- description -->
      @if ($project->description)
        <h3 class="font-extrabold text-center">Quick Description : {{$project->description}}</h3>
        
      @else
          <h3 class="font-extrabold text-center">The Author did not provide any quick description</h3>
      @endif
     
      <!-- Project Sections -->
      @if ($project->editor->contains(Auth::user()))
      <div class="flex justify-center py-6">
        <x-editors.add-project-section :project="$project" />
      </div>
      @endif
                  
        @if (($project->sections && $project->sections->where('published', true)->count()>0) || $project->editor->contains(Auth::user()))
        <h3 class="font-extrabold text-center">Full Description</h3>
        <ul>
          @foreach ($project->sections as $section)
              @if($section->published==true || $project->editor->contains(Auth::user()) )
              <li class="py-1">
                <x-editors.project-section-component :section="$section" />
              </li>
              @endif
          @endforeach
        </ul>
        
        @else
        <h3 class="font-extrabold text-center">There is no more details for this project</h3>
        @endif

      </div>
    </div>

  </div>


</x-app-layout>
