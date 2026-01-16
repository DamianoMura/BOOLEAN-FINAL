@if (Auth::id() == $current_project->author_id)
<div class="flex flex-col gap-3 sm:flex-row">
    <div
        class="relative flex items-center justify-between w-full p-2 space-x-2 border rounded-lg cursor-pointer group hover:bg-gray-50 sm:p-3 sm:space-x-3">
        <div class="w-full text-sm text-center text-gray-800 font-small sm:text-base">
            {{ $current_project->editor->count() > 1 ? 'Assigned Editors : ' : 'No Editors' }}
            {{$current_project->editor->count() > 1 &&
            $current_project->editor->count()}}
            @if ($current_project->editor->count() >1)
            <div
                class="absolute bottom-0 left-0 p-3 mt-1 bg-white border rounded-lg shadow-lg opacity-0 group-hover:opacity-100 z-100">
                <div class="flex items-center gap-2">
                    <span>Editors:</span>
                    @foreach ($current_project->editor as $editor)
                    @if(!$editor->id != Auth::id() && $editor->id != $current_project->author_id)
                    <span class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full sm:px-3 sm:text-sm">
                        {{ $editor->name }}
                    </span>
                    @endif
                    @endforeach
                </div>

            </div>
            @endif
        </div>

    </div>
    <!-- editors buttons -->
    <admin-x-editors-modal :project="$current_project" />
</div>
@endif