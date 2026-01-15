<div class="w-full border border-gray-200 bg-gradient-to-r from-gray-50 to-white">
     <div class="border border-gray-300 rounded-lg">
          <div class="flex justify-between px-6 py-3">
               <h2 class="flex items-center text-xl font-bold text-gray-800 sm:text-2xl">
                    <i class="fa-solid fa-folder-tree"></i>

                    <span class="ml-2">  Projects you can work on </span>
                    
               </h2>
               @admin <a href="{{route('projects.create')}}"><i
                         class="p-3 text-3xl text-green-500 fa-solid fa-folder-plus"></i></a> @endadmin
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

