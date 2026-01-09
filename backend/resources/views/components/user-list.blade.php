
    <div class="container px-4 py-6 mx-auto">
        <div class="overflow-hidden bg-white shadow-lg rounded-xl">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <h2 class="flex items-center text-2xl font-bold text-gray-800">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.828 0-1.5.672-1.5 1.5s.672 1.5 1.5 1.5 1.5-.672 1.5-1.5-.672-1.5-1.5-1.5z" />
                    </svg>
                    Users List
                </h2>
                <p class="mt-1 text-sm text-gray-500">Manage user roles</p>
            </div>

            <!-- Users List -->
            <div class="p-6">
                <ul class="space-y-4">
                    @foreach ($users as $user)
                    <li
                        class="flex items-center justify-between p-4 transition-colors duration-200 border border-gray-100 rounded-lg bg-gradient-to-r from-gray-50/50 to-white hover:border-blue-200 group">
                        <!-- User Info -->
                        <div class="flex items-center space-x-4">
                            <div
                                class="flex items-center justify-center w-10 h-10 border border-blue-200 rounded-full bg-gradient-to-br from-blue-100 to-blue-50">
                                <span class="font-semibold text-blue-700">{{ strtoupper(substr($user->name, 0, 1))
                                    }}</span>
                            </div>
                            <div>
                                <div class="flex items-center space-x-3">
                                    <span class="font-medium text-gray-800 capitalize">{{ $user->name }}</span>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $user->getRoleName() == 'dev' ? 'bg-gradient-to-r from-red-100 to-red-50 text-red-700 border border-red-200' : 
                          ($user->getRoleName() == 'admin' ? 'bg-gradient-to-r from-blue-100 to-blue-50 text-blue-700 border border-blue-200' : 
                          'bg-gradient-to-r from-gray-100 to-gray-50 text-gray-700 border border-gray-200') }}">
                                        {{ ucfirst($user->getRoleName()) }}
                                    </span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ $user->email ?? 'No email' }}</p>
                            </div>
                        </div>

                        <!-- Change Role Button -->
                        @if (!($user->isDev() && $devs==1))
                        <button command="show-modal" commandfor="dialog-{{$user->id}}"
                            class="px-4 py-2 text-sm font-medium text-blue-700 transition-all duration-200 border border-blue-200 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 hover:shadow-sm hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Change Role</span>
                            </div>
                        </button>
                        @endif
                    </li>

                    <!-- Modal -->
                    <el-dialog>
                        <dialog id="dialog-{{$user->id}}" aria-labelledby="dialog-title"
                            class="fixed inset-0 z-50 overflow-y-auto bg-transparent">
                            <el-dialog-backdrop
                                class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm">
                            </el-dialog-backdrop>

                            <div
                                class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                                <el-dialog-panel
                                    class="relative w-full overflow-hidden text-left transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:max-w-lg">

                                    <!-- Modal Header -->
                                    <div class="px-6 pt-6 pb-4 bg-gradient-to-r from-gray-50 to-white rounded-t-2xl">
                                        <div class="flex items-start">
                                            <!-- Icon -->
                                            <div
                                                class="flex items-center justify-center w-12 h-12 border border-blue-200 shadow-sm bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" class="w-6 h-6 text-blue-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                </svg>
                                            </div>

                                            <!-- Content -->
                                            <div class="flex-1 ml-4">
                                                <h3 id="dialog-title" class="text-lg font-semibold text-gray-900">
                                                    Change Role for <span class="text-blue-600 capitalize">{{
                                                        $user->name }}</span>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    Select a new role from the dropdown below
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="px-6 py-5 bg-white">
                                        <form method="POST" action="{{ route('dashboard.role-update', $user) }}"
                                            class="space-y-6">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="user_id" value="{{$user->id}}">

                                            <!-- Role Selector -->
                                            <div class="space-y-3">
                                                <label class="block text-sm font-medium text-gray-700">Select
                                                    Role</label>
                                                <div class="relative">
                                                    <select name="role"
                                                        class="w-full px-4 py-3 transition-colors duration-200 bg-white border border-gray-300 shadow-sm appearance-none cursor-pointer rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-400">
                                                        @foreach ($roles as $role)
                                                        <option value="{{$role->name}}" {{ $user->getRoleName() ==
                                                            $role->name ? 'selected' : '' }}
                                                            class="py-2">
                                                            {{ ucfirst($role->name) }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <div
                                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                        <svg class="w-5 h-5 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </div>
                                                </div>

                                                <!-- Current Role Badge -->
                                                <div
                                                    class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-gray-100 to-gray-50 rounded-lg border border-gray-200">
                                                    <span class="text-xs text-gray-600">Current role:</span>
                                                    <span class="ml-2 text-sm font-medium text-gray-800">{{
                                                        ucfirst($user->getRoleName())
                                                        }}</span>
                                                </div>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="flex justify-end pt-4 space-x-3 border-t border-gray-100">
                                                <button type="button" command="close" commandfor="dialog-{{$user->id}}"
                                                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 shadow-sm">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                    class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 border border-blue-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
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

                <!-- Footer Stats -->
                <div class="pt-6 mt-8 border-t border-gray-200">
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-red-500 rounded-full"></div>
                                <span>Developers: {{ $devs }}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-blue-500 rounded-full"></div>
                                <span>Administrators: {{ $admins }}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-gray-500 rounded-full"></div>
                                <span>Total Users: {{ $users->count() }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

