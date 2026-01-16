<div class="px-4 py-3 border-t border-gray-200 sm:px-6">
     <x-filters-menu />
     @if($projects->count() > 0)
     <div class="space-y-4">
          @foreach($projects as $project)

          <admin-x-project-snap :project="$project" />



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
               No projects have been created yet
               @endif
          </p>

     </div>
     @endif
</div>

