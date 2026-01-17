<button command="show-modal" commandfor="manage-editors-{{$project->id}}"
    class="flex items-center justify-center px-4 py-2 space-x-2 text-blue-800 bg-blue-200 border border-blue-800 rounded-lg self-right hover:text-blue-200 hover:bg-blue-800">
    <i class="fa-solid fa-users"></i>
    <div>Manage Editors</div>
</button>
<!-- Modal to delete editors -->
<el-dialog>
    <dialog id="manage-editors-{{$project->id}}" aria-labelledby="manage-editors"
        class="fixed inset-0 z-50 overflow-y-auto bg-transparent">
        <el-dialog-backdrop class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm">
        </el-dialog-backdrop>

        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <el-dialog-panel
                class="relative w-full overflow-hidden text-left transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:max-w-lg">

                <!-- Modal Header -->
                <div
                    class="px-4 pt-4 pb-3 bg-gradient-to-r from-gray-50 to-white rounded-t-2xl sm:px-6 sm:pt-6 sm:pb-4">
                    <div class="flex items-start">
                        <!-- Icon -->
                        <div
                            class="flex items-center justify-center w-10 h-10 border border-blue-200 shadow-sm bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl sm:w-12 sm:h-12">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                class="w-5 h-5 text-blue-600 sm:w-6 sm:h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 ml-3 sm:ml-4">
                            <h3 id="delete-user" class="text-base font-semibold text-gray-900 sm:text-lg">
                                Manage editors for  : <span class="text-blue-600 capitalize">{{
                                    $project->title }}</span>
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-4 py-4 bg-white sm:px-6 sm:py-5">
                    <form method="POST" action="{{ route('projects.manageEditor') }}" class="space-y-4 sm:space-y-6">
                        @csrf
                        @method('put')
                        <input type="hidden" name="project_id" value="{{$project->id}}">

                        <!-- Checkbox List -->
                        <div class="space-y-2 sm:space-y-3">
                            <label class="block text-sm font-medium text-gray-700">Manage Editors</label>
                            <div class="overflow-y-auto border border-gray-200 rounded-lg max-h-48">
                                <div class="p-3 space-y-2 bg-gray-50 sm:p-4">
                                    @foreach ($availableEditors as $user)
                                    @if (($user->id != Auth::id()))
                                    <div
                                        class="flex items-center p-2 transition-colors duration-200 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 sm:p-3">
                                        <input type="checkbox" name="user_ids[]" value="{{$user->id}}"
                                            id="user-{{$project->id}}-{{$user->id}}"
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 sm:w-5 sm:h-5"
                                            {{$project->editor->contains($user) ? 'checked' :''}}>
                                        <label for="user-{{$project->id}}-{{$user->id}}"
                                            class="flex-1 ml-3 text-sm text-gray-700 cursor-pointer sm:ml-4 sm:text-base">
                                            <div class="font-medium">{{ ucfirst($user->name) }}</div>
                                            <div class="text-xs text-gray-500 sm:text-sm">{{ $user->email }}</div>
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end pt-3 space-x-2 border-t border-gray-100 sm:pt-4 sm:space-x-3">
                            <button type="button" command="close" commandfor="delete-editor-{{$project->id}}"
                                class="px-3 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 shadow-sm sm:px-5 sm:py-2.5 sm:text-sm">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-3 py-2 text-xs text-white rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 sm:px-5 sm:py-2.5 sm:text-sm">
                                <div class="flex items-center space-x-1 sm:space-x-2">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Update Editors</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </el-dialog-panel>
        </div>
    </dialog>
</el-dialog>

<script>
    document.querySelectorAll('select[name="user_id"]').forEach(select => {
        select.addEventListener('change', function() {
            const btn = this.closest('form').querySelector('button[type="submit"]');
            const isEmpty = this.value === '';
            
            btn.disabled = isEmpty;
            
            // Swap classes
            const enabledClasses = btn.dataset.enabledClasses.split(' ');
            const disabledClasses = btn.dataset.disabledClasses.split(' ');
            
            if (isEmpty) {
                btn.classList.remove(...enabledClasses);
                btn.classList.add(...disabledClasses);
            } else {
                btn.classList.remove(...disabledClasses);
                btn.classList.add(...enabledClasses);
            }
        });
    });
</script>