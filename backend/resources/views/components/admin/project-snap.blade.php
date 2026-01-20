<div class="flex flex-col p-4 space-y-3 transition-colors duration-200 border border-gray-100 rounded-lg bg-gradient-to-r from-gray-50/50 to-white hover:border-blue-200 ">

    <!-- Project  -->
    
    
    <div class="flex flex-col">
        <div class="flex flex-col space-y-3">
            <!-- Project ID and Title -->
            <div class="flex items-center space-x-4">
                <div
                    class="flex items-center justify-center px-2 py-3 border border-blue-200 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50">
                    <span>
                        {{ $project->category->label }}
                    </span>
                </div>
                <div class="flex">
                    <span class="text-lg font-semibold text-gray-800 capitalize sm:text-3xl">{{
                        $project->title }}</span>
                </div>
            </div>
            <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-3 sm:justify-between ">
                <div class="flex items-center justify-between space-x-3">
                    <p class="mt-1 capitalize text-bold ">
                        Author :@if($project->author_id==Auth::id()) you @else {{ $project->user->name }} @endif
                    </p>
                    @if($project->editor->contains(Auth::id()))
                    <p class="mt-1 text-xs capitalize {{ $project->published ? 'text-green-500' : 'text-red-500' }}">
                        {{ $project->published ? 'published' : 'not published' }}
                    </p>
                </div>
                @endif
                <!-- info and route buttons -->
                <div class="flex items-center mt-3 space-x-3 sm:mt-0">
                    @if(!Route::is('projects.show'))
                    
                        <a href="{{route('projects.show', $project)}}" class="items-center">
                            <i class="fa-solid fa-eye"></i>
                            view
                        </a>
                    @endif
                    @if( $project->author_id===Auth::id())
                    <div>
                        <a href="{{route('projects.edit',$project)}}">
                            <div
                                class="items-center px-4 py-2 text-green-800 bg-green-200 border border-green-800 rounded-lg hover:text-green-200 hover:bg-green-800">
                                <span>Edit</span>
                                <i class="fa-solid fa-pen-ruler"></i>
                            </div>
                        </a>
                    </div>
                    <div>
                        <x-admin.delete-project :project="$project" />
                    </div>
                    @endif
                </div>
            </div>
            <!-- Technologies Tags per ogni progetto -->
            @if($project->technology->count() > 0)
            <div class="flex flex-wrap gap-1 -top-2">
                @foreach($project->technology as $tech)
                <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                    {{ $tech->label }} <i class="{{$tech->fontawesome_class}}"></i>
                </span>
                @endforeach
            
            </div>
            @endif
            <!-- editors -->
            <x-admin.editor-section :project="$project"/>
                 
        </div>
   </div>
   
    
    
</div>

