<div class="w-full border border-gray-300 rounded-lg">
    <div class="flex w-full {{($section->user_id == Auth::id() || Auth::user()->isAdmin()) ? 'justify-between' : ''}}  p-3 mb-2 bg-blue-200 rounded-t-lg ">
        <div>

            <h4 class="text-lg capitalize ">{{$section->title}}</h4>
        </div>
        @if ( $section->user_id == Auth::id() || Auth::user()->isAdmin())
            <div>
                <x-editors.edit-project-section :projectid="$section->project_id" :section="$section" />
            </div>
           
        @endif
    </div>
    <p class="p-4 ">{{$section->content}}</p>
    @if ($project->editor->contains(Auth::user()))
    <div class="flex flex-col w-full px-3 py-1 space-y-2 font-semibold text-white rounded-b-lg bg-slate-500 lg:items-center lg:flex-row">
        
        @admin
        <div class="flex justify-between ">

            <div class="flex flex-col ">
                @if ($section->order>1)
                <form method="POST" action="{{route('project-sections.update',$section)}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_position" value="up">
                    <input type="hidden" name="edit_position" value="up">
                    <button type="submit" class="flex items-center lg:w-36"><i class="fa-solid fa-caret-up"></i> move up</button>
                </form>
                @endif
                
                @if($section->order < $project->sections->count())
                <form method="POST" action="{{route('project-sections.update',$section)}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_position" value="down">
                    <button type="submit" class="flex items-center lg:w-36"><i class="fa-solid fa-caret-down"></i> move down</button>
                </form>
                @endif
                
            </div>
            
            <div class="flex flex-col items-center">
                    <span >{{$section->published? 'published' : 'draft'}}</span>
                
                    <form method="POST" action="{{route('project-sections.update',$section)}}">

                        @csrf
                        @method('PUT')
                        <input type="hidden" name="published" value={{$section->published==true ? 'true' : 'false'}}>
                        <button type="submit" class="flex items-center space-x-1 {{$section->published==false ? 'text-green-500': 'text-red-700'}}">
                            @if ($section->published==false)
                            <i class="fa-solid fa-eye"></i> <span>publish</span>
                            @else
                            <i class="fa-solid fa-eye-slash"></i> <span>draft</span>
                            @endif
                        </button>
                    </form>
            </div>
        </div>
        <div class="w-full border-b border-white lg:border-b-0 "></div> <!-- separator for lg breakpoint -->
        @endadmin
        
        <div class="flex flex-col w-full space-x-0 space-y-2 text-right sm:space-y-0 sm:space-x-2 sm:flex-row sm:justify-end">
            <div>
                created by : {{ $section->user_id == Auth::id() ? 'you' : $section->author->name}} 
            </div>
            <div>
                Last edited by : {{$section->last_edited_by== Auth::id() ? 'you' : $section->lastEditedBy->name }} 
            </div>
            <div>
                {{$section->updated_at ? 'Last Updated At' : 'Created At' }} : {{$section->updated_at ? $section->updated_at : $section->created_at }}
            </div>
        </div>
    </div>
    @endif
    
</div>