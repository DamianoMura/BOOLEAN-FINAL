<div class="w-full border border-gray-200 bg-gradient-to-r from-gray-50 to-white">
     <div class="border border-gray-300 rounded-lg">
          <div class="flex justify-between px-6 py-3">
               <h2 class="flex items-center text-xl font-bold text-gray-800 sm:text-2xl">
                    <i class="fa-solid fa-folder-tree"></i>

                    <span class="ml-2">  Projects you can work on </span>
                    
               </h2>
               @admin <div class="flex items-center space-x-3">
                    <!-- Pulsante crea progetto -->
                    <a href="{{ route('projects.create') }}"
                         class="flex items-center px-4 py-2 text-sm font-medium text-green-700 bg-green-100 border border-green-300 rounded-lg hover:bg-green-200">
                         <i class="mr-2 fa-solid fa-folder-plus"></i>
                         New Project
                    </a>
               </div> @endadmin
          </div>
          
          
          <div class="border-t sm:px-4">
               <!-- filters -->
              
               <x-filters-menu />
               <!-- Projects List -->
               <div>
                    <ul class="space-y-4">
                         @if($projects->count()==0)
                         <li class="text-red-500"> You are @admin either @endadmin not part of any project @admin or you
                              didn't create any @endadmin or the filter didn't find any result</li>
                         @endif

                         @foreach ($projects as $project)
                        <x-project-snap :project="$project" />

                       
                         @endforeach
                    </ul>
               </div>
          </div>
     </div>
</div>

