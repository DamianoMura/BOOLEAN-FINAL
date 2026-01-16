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
      <x-project-snap :project="$project" />
      

      
      

      <!-- content -->
      <div class="p-6">
        <h3 class="font-extrabold text-center">Quick Description</h3>
       
      </div>
    </div>

  </div>


</x-app-layout>
