<button command="show-modal" commandfor="add-section-{{$project}}"
    class="flex items-center justify-center px-4 py-2 space-x-2 text-blue-800 bg-blue-200 border border-blue-800 rounded-lg self-right hover:text-blue-200 hover:bg-blue-800">
    <i class="fa-solid fa-users"></i>
    <div>Add New Section</div>
</button>
<!-- Modal to delete editors -->
<el-dialog>
    <dialog id="add-section-{{$project}}" aria-labelledby="add-section"
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
                           <i class="fa-solid fa-file-circle-plus"></i>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 ml-3 sm:ml-4">
                            <h3 id="delete-user" class="text-base font-semibold text-gray-900 sm:text-lg">
                                Add Descriptive section to  : <span class="text-blue-600 capitalize">{{
                                    $project->title }}</span>
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-4 py-4 bg-white sm:px-6 sm:py-5">
                    <form method="POST" action="{{ route('project-sections.store') }}" class="space-y-4 sm:space-y-6">
                        @csrf
                        
                    
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                    
                        <!-- Title -->
                        <div>
                            <label for="title" class="block mb-1 text-sm font-medium text-gray-700">
                                Title *
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required maxlength="255"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('title') border-red-500 @enderror"
                                placeholder="Enter section title">
                            @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <!-- Content -->
                        <div>
                            <label for="content" class="block mb-1 text-sm font-medium text-gray-700">
                                Content
                            </label>
                            <textarea id="content" name="content" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('content') border-red-500 @enderror"
                                placeholder="Enter section content (optional)">{{ old('content') }}</textarea>
                            @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    
                    
                        <!-- Buttons -->
                        <div class="flex justify-end pt-4 space-x-3 border-t border-gray-100">
                            <button type="button" command="close" commandfor="add-section-{{$project}}"
                                class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl
                                hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors
                                duration-200">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2.5 text-sm text-white rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-file-circle-plus"></i>
                                    <span>Add Section</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </el-dialog-panel>
        </div>
    </dialog>
</el-dialog>

