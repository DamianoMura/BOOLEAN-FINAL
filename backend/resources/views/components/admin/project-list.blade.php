@admin
<div class="px-4 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white sm:px-6">
     <div class="border border-gray-300 rounded-lg">
          <div class="flex justify-between px-6 py-3">
               <h2 class="flex items-center text-xl font-bold text-gray-800 sm:text-2xl">
                    <i class="fa-solid fa-folder-tree"></i>
                    <span class="ml-2">Your Projects</span>
               </h2>
               <a href="{{route('projects.create')}}"><i class="p-3 text-3xl text-green-500 fa-solid fa-folder-plus"></i></a>
          </div>

          <div class="px-6 py-3 border-t sm:px-4">
               <!-- Projects List -->
               <div class="p-4 sm:p-6">
                    <ul class="space-y-4">
                         @if($elements['projects']->count()===0)
                              <li class="text-red-500"> You are either not part of any project or you didn't create any</li>
                         @endif

                         @foreach ($elements['projects'] as $project)
                         <li class="flex flex-col p-4 transition-colors duration-200 border border-gray-100 rounded-lg bg-gradient-to-r from-gray-50/50 to-white hover:border-blue-200 sm:flex-row sm:items-center sm:justify-between">
                              
                              <!-- Project Info -->
                              <div
                                   class="flex flex-col w-full space-y-4 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4">
                                   <!-- Project ID and Title -->
                                   <div class="flex items-center space-x-3">
                                        <div
                                             class="flex items-center justify-center w-10 h-10 border border-blue-200 rounded-full bg-gradient-to-br from-blue-100 to-blue-50">
                                             <span class="font-semibold text-blue-700 capitalize">{{ $project->id
                                                  }}</span>
                                        </div>
                                        <div class="flex flex-col">
                                             <span class="text-lg font-semibold text-gray-800 capitalize sm:text-3xl">{{
                                                  $project->title }}</span>
                                             <p
                                                  class="mt-1 text-xs capitalize {{ $project->published ? 'text-green-500' : 'text-red-500' }}">
                                                  {{ $project->published ? 'published' : 'not published' }}
                                             </p>
                                        </div>
                                   </div>

                                   <!-- ASSIGNED EDITORS CON HOVER -->
                                   <div class="flex items-center justify-between w-full sm:w-auto">
                                        <div x-data="{ showEditors: false }" @mouseenter="showEditors = true"
                                             @mouseleave="setTimeout(() => showEditors = false, 150)" class="relative">
                                             <!-- Trigger -->
                                             <div @mouseenter="showEditors = true"
                                                  class="flex items-center justify-between p-2 space-x-2 transition border rounded-lg cursor-pointer hover:bg-gray-50 sm:p-3 sm:space-x-3">
                                                  <span class="text-sm text-gray-800 font-small sm:text-base">
                                                       {{ $project->editor->count() - 1 > 0 ? 'Assigned Editors
                                                       '.($project->editor->count() - 1) : 'No Editors' }}
                                                  </span>
                                                  @if (($project->editor->count() - 1)>0)
                                                  <svg :class="showEditors ? 'text-blue-500 rotate-180' : 'text-gray-400'"
                                                       class="w-4 h-4 transition transform sm:w-4 sm:h-4" fill="none"
                                                       stroke="currentColor" viewBox="0 0 24 24">
                                                       <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                  </svg>
                                                  @endif
                                             </div>

                                             <!-- Dropdown -->
                                             @if (($project->editor->count() - 1)>0)
                                             <div x-show="showEditors" @mouseenter="showEditors = true"
                                                  @mouseleave="showEditors = false" x-transition.opacity.duration.200ms
                                                  class="absolute left-0 z-50 p-3 mt-1 bg-white border rounded-lg shadow-lg top-full min-w-[200px] sm:left-auto sm:right-0"
                                                  style="display: none;">
                                                  <div class="flex flex-wrap gap-2">
                                                       @foreach ($project->editor as $editor)
                                                       @if($editor->id != Auth::id())
                                                       <span
                                                            class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full sm:px-3 sm:text-sm">
                                                            {{ $editor->name }}
                                                       </span>
                                                       @endif
                                                       @endforeach
                                                  </div>

                                                  <!-- Freccetta del dropdown -->
                                                  <div
                                                       class="absolute -top-1.5 left-4 w-3 h-3 bg-white border-l border-t border-gray-200 transform rotate-45 sm:left-auto sm:right-4">
                                                  </div>
                                             </div>
                                             @endif
                                        </div>
                                   </div>
                                   <!-- FINE ASSIGNED EDITORS -->
                              </div>

                              <!-- Editors Buttons -->
                              <div
                                   class="flex flex-col w-full mt-4 space-y-2 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4 sm:mt-0 sm:w-auto">
                                   <button command="show-modal" commandfor="add-editor-{{$project->id}}"
                                        class="flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-blue-700 transition-all duration-200 border border-blue-200 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 sm:w-auto sm:px-4">
                                        <svg class="w-4 h-4 mr-2 sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01M12 8v1m0 0v1m0-1h1m-1 0h-1" />
                                        </svg>
                                        <span class="text-xs sm:text-sm">Add Editors</span>
                                   </button>

                                   <button command="show-modal" commandfor="delete-editor-{{$project->id}}"
                                        class="flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-blue-700 transition-all duration-200 border border-blue-200 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 sm:w-auto sm:px-4">
                                        <svg class="w-4 h-4 mr-2 sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4m-4-5h.01M9 16h.01" />
                                        </svg>
                                        <span class="text-xs sm:text-sm">Delete Editors</span>
                                   </button>
                              </div>
                         </li>

                         <!-- Modal to add editors -->
                         <el-dialog>
                              <dialog id="add-editor-{{$project->id}}" aria-labelledby="dialog-title"
                                   class="fixed inset-0 z-50 overflow-y-auto bg-transparent">
                                   <el-dialog-backdrop
                                        class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm">
                                   </el-dialog-backdrop>

                                   <div
                                        class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                                        <el-dialog-panel
                                             class="relative w-full overflow-hidden text-left transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:max-w-lg">

                                             <!-- Modal Header -->
                                             <div
                                                  class="px-4 pt-4 pb-3 bg-gradient-to-r from-gray-50 to-white rounded-t-2xl sm:px-6 sm:pt-6 sm:pb-4">
                                                  <div class="flex items-start">
                                                       <!-- Icon -->
                                                       <div
                                                            class="flex items-center justify-center w-10 h-10 border border-blue-200 shadow-sm bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl sm:w-12 sm:h-12">
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                 stroke-width="1.5"
                                                                 class="w-5 h-5 text-blue-600 sm:w-6 sm:h-6">
                                                                 <path stroke-linecap="round" stroke-linejoin="round"
                                                                      d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                            </svg>
                                                       </div>

                                                       <!-- Content -->
                                                       <div class="flex-1 ml-3 sm:ml-4">
                                                            <h3 id="dialog-title"
                                                                 class="text-base font-semibold text-gray-900 sm:text-lg">
                                                                 Add editor for the Project <span
                                                                      class="text-blue-600 capitalize">{{
                                                                      $project->title }}</span>
                                                            </h3>
                                                       </div>
                                                  </div>
                                             </div>

                                             <!-- Modal Body -->
                                             <div class="px-4 py-4 bg-white sm:px-6 sm:py-5">
                                                  <form method="POST"
                                                       action="{{ route('projects.assignEditor', $project) }}"
                                                       class="space-y-4 sm:space-y-6">
                                                       @csrf
                                                       @method('PUT')
                                                       <input type="hidden" name="project_id" value="{{$project->id}}">

                                                       <!-- Editor Selector -->
                                                       <div class="space-y-2 sm:space-y-3">
                                                            <label
                                                                 class="block text-sm font-medium text-gray-700">Select
                                                                 User</label>
                                                            <div class="relative">
                                                                 <select name="user_id"
                                                                      onchange="toggleSubmitButton(this)"
                                                                      id="user-select-{{ $project->id }}"
                                                                      class="w-full px-3 py-2.5 text-sm transition-colors duration-200 bg-white border border-gray-300 shadow-sm appearance-none cursor-pointer rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-400 sm:px-4 sm:py-3 sm:text-base">
                                                                      <option value="" class="py-2" selected>
                                                                           Add User
                                                                      </option>
                                                                      @foreach ($elements['available_users'] as $user)
                                                                      @if (!$project->editor->contains($user))
                                                                      <option value="{{$user->id}}" class="py-2">
                                                                           {{ ucfirst($user->name) }}
                                                                      </option>
                                                                      @endif
                                                                      @endforeach
                                                                 </select>
                                                                 <div
                                                                      class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none sm:pr-3">
                                                                      <svg class="w-4 h-4 text-gray-400 sm:w-5 sm:h-5"
                                                                           fill="none" stroke="currentColor"
                                                                           viewBox="0 0 24 24">
                                                                           <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M19 9l-7 7-7-7" />
                                                                      </svg>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <!-- Buttons -->
                                                       <div
                                                            class="flex justify-end pt-3 space-x-2 border-t border-gray-100 sm:pt-4 sm:space-x-3">
                                                            <button type="button" command="close"
                                                                 commandfor="add-editor-{{$project->id}}"
                                                                 class="px-3 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 shadow-sm sm:px-5 sm:py-2.5 sm:text-sm">
                                                                 Cancel
                                                            </button>
                                                            <button type="submit" id="submit-btn-{{ $project->id }}"
                                                                 disabled
                                                                 data-enabled-classes="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600"
                                                                 data-disabled-classes="bg-gray-400 cursor-not-allowed opacity-75"
                                                                 class="px-3 py-2 text-xs text-white rounded-xl bg-gray-400 cursor-not-allowed opacity-75 sm:px-5 sm:py-2.5 sm:text-sm">
                                                                 <div class="flex items-center space-x-1 sm:space-x-2">
                                                                      <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none"
                                                                           stroke="currentColor" viewBox="0 0 24 24">
                                                                           <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M5 13l4 4L19 7" />
                                                                      </svg>
                                                                      <span>Confirm Change</span>
                                                                 </div>
                                                            </button>
                                                       </div>
                                                  </form>
                                             </div>
                                        </el-dialog-panel>
                                   </div>
                              </dialog>
                         </el-dialog>
                         <!-- Modal to delete editors -->
                         <el-dialog>
                              <dialog id="delete-editor-{{$project->id}}" aria-labelledby="delete-user"
                                   class="fixed inset-0 z-50 overflow-y-auto bg-transparent">
                                   <el-dialog-backdrop
                                        class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm">
                                   </el-dialog-backdrop>

                                   <div
                                        class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                                        <el-dialog-panel
                                             class="relative w-full overflow-hidden text-left transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:max-w-lg">

                                             <!-- Modal Header -->
                                             <div
                                                  class="px-4 pt-4 pb-3 bg-gradient-to-r from-gray-50 to-white rounded-t-2xl sm:px-6 sm:pt-6 sm:pb-4">
                                                  <div class="flex items-start">
                                                       <!-- Icon -->
                                                       <div
                                                            class="flex items-center justify-center w-10 h-10 border border-blue-200 shadow-sm bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl sm:w-12 sm:h-12">
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                 stroke-width="1.5"
                                                                 class="w-5 h-5 text-blue-600 sm:w-6 sm:h-6">
                                                                 <path stroke-linecap="round" stroke-linejoin="round"
                                                                      d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                            </svg>
                                                       </div>

                                                       <!-- Content -->
                                                       <div class="flex-1 ml-3 sm:ml-4">
                                                            <h3 id="delete-user"
                                                                 class="text-base font-semibold text-gray-900 sm:text-lg">
                                                                 Remove editor from <span
                                                                      class="text-blue-600 capitalize">{{
                                                                      $project->title }}</span>
                                                            </h3>
                                                       </div>
                                                  </div>
                                             </div>

                                             <!-- Modal Body -->
                                             <div class="px-4 py-4 bg-white sm:px-6 sm:py-5">
                                                  <form method="POST" action="{{ route('projects.removeEditor') }}"
                                                       class="space-y-4 sm:space-y-6">
                                                       @csrf
                                                       @method('DELETE')
                                                       <input type="hidden" name="project_id" value="{{$project->id}}">

                                                       <!-- Editor Selector -->
                                                       <div class="space-y-2 sm:space-y-3">
                                                            <label
                                                                 class="block text-sm font-medium text-gray-700">Select
                                                                 User to Remove</label>
                                                            <div class="relative">
                                                                 <select name="user_id"
                                                                      onchange="toggleSubmitButton(this)"
                                                                      id="user-delete-{{ $project->id }}"
                                                                      class="w-full px-3 py-2.5 text-sm transition-colors duration-200 bg-white border border-gray-300 shadow-sm appearance-none cursor-pointer rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-400 sm:px-4 sm:py-3 sm:text-base">
                                                                      <option class="py-2">
                                                                           Remove User
                                                                      </option>
                                                                      @foreach ($project->editor as $user)
                                                                      @if (($user->id != Auth::id()))
                                                                      <option value="{{$user->id}}" class="py-2">
                                                                           {{ ucfirst($user->name) }}
                                                                      </option>
                                                                      @endif
                                                                      @endforeach
                                                                 </select>
                                                                 <div
                                                                      class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none sm:pr-3">
                                                                      <svg class="w-4 h-4 text-gray-400 sm:w-5 sm:h-5"
                                                                           fill="none" stroke="currentColor"
                                                                           viewBox="0 0 24 24">
                                                                           <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M19 9l-7 7-7-7" />
                                                                      </svg>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <!-- Buttons -->
                                                       <div
                                                            class="flex justify-end pt-3 space-x-2 border-t border-gray-100 sm:pt-4 sm:space-x-3">
                                                            <button type="button" command="close"
                                                                 commandfor="delete-editor-{{$project->id}}"
                                                                 class="px-3 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 shadow-sm sm:px-5 sm:py-2.5 sm:text-sm">
                                                                 Cancel
                                                            </button>
                                                            <button type="submit" id="delete-btn-{{ $project->id }}"
                                                                 disabled
                                                                 data-enabled-classes="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600"
                                                                 data-disabled-classes="bg-gray-400 cursor-not-allowed opacity-75"
                                                                 class="px-3 py-2 text-xs text-white rounded-xl bg-gray-400 cursor-not-allowed opacity-75 sm:px-5 sm:py-2.5 sm:text-sm">
                                                                 <div class="flex items-center space-x-1 sm:space-x-2">
                                                                      <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none"
                                                                           stroke="currentColor" viewBox="0 0 24 24">
                                                                           <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M5 13l4 4L19 7" />
                                                                      </svg>
                                                                      <span>Confirm Change</span>
                                                                 </div>
                                                            </button>
                                                       </div>
                                                  </form>
                                             </div>
                                        </el-dialog-panel>
                                   </div>
                              </dialog>
                         </el-dialog>
                         @endforeach
                    </ul>
               </div>
          </div>
     </div>
</div>
@endadmin
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