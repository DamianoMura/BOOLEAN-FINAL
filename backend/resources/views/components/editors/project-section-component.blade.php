<div class="w-full border border-gray-300 rounded-lg">
    <div
        class="flex w-full {{($section->user_id == Auth::id() || Auth::user()->isAdmin()) ? 'justify-between' : ''}} p-3 mb-2 bg-blue-200 rounded-t-lg">
        <div>
            <h4 class="text-lg capitalize">{{$section->title}}</h4>
        </div>
        @if ($section->user_id == Auth::id() || Auth::user()->isAdmin())
        <div class="text-right">
            <x-editors.edit-project-section :projectid="$section->project_id" :section="$section" />
            <x-editors.delete-project-section :projectid="$section->project_id" :section="$section" />
        </div>
        @endif
    </div>

    <div class="p-4">{!!$section->content!!}</div>

    @if ($project->editor->contains(Auth::user()))
    <div
        class="flex flex-col w-full px-3 py-1 space-y-2 font-semibold text-white rounded-b-lg bg-slate-500 lg:items-center lg:flex-row sm:justify-between">

        @admin
        <div class="flex items-center justify-between w-full lg:w-auto">
            <div class="flex space-x-4">
                {{-- Move Up Button --}}
                @if ($section->order > 1)
                <form method="POST" action="{{route('project-sections.update', $section)}}" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_position" value="up">
                    <button type="submit" class="flex items-center transition-colors hover:text-gray-300">
                        <i class="mr-1 fa-solid fa-caret-up"></i>
                        <span>Move Up</span>
                    </button>
                </form>
                @endif

                {{-- Move Down Button --}}
                @if($section->order < $totalSections) <form method="POST"
                    action="{{route('project-sections.update', $section)}}" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_position" value="down">
                    <button type="submit" class="flex items-center transition-colors hover:text-gray-300">
                        <i class="mr-1 fa-solid fa-caret-down"></i>
                        <span>Move Down</span>
                    </button>
                    </form>
                    @endif
            </div>

            <div class="flex items-center ml-4">
                <span class="mr-2">{{$section->published ? 'Published' : 'Draft'}}</span>

                <form method="POST" action="{{route('project-sections.update', $section)}}" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="published" value="{{$section->published ? 'true' : 'false'}}">
                    <button type="submit"
                        class="flex items-center space-x-1 hover:text-gray-300 transition-colors {{$section->published ? 'text-red-400' : 'text-green-400'}}">
                        @if ($section->published)
                        <i class="fa-solid fa-eye-slash"></i>
                        <span>Set Draft</span>
                        @else
                        <i class="fa-solid fa-eye"></i>
                        <span>Publish</span>
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <div class="w-full border-b border-white lg:hidden"></div>
        @endadmin

        <div class="text-sm text-right">
            <div>
                <span>Created by:</span>
                <span>{{ $section->user_id == Auth::id() ? 'You' : ($section->author->name ?? 'Unknown') }}</span>
            </div>
            <div>
                <span>Last edited by:</span>
                <span>{{ $section->last_edited_by == Auth::id() ? 'You' : ($section->lastEditedBy->name ?? 'Unknown')
                    }}</span>
            </div>
            <div>
                <span>{{ $section->updated_at ? 'Updated:' : 'Created:' }}</span>
                <span>{{ $section->updated_at ? $section->updated_at->format('d/m/Y H:i') :
                    $section->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
    @endif
</div>