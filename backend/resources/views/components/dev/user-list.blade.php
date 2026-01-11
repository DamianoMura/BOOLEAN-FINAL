@dev
<div class="w-full border border-gray-200 bg-gradient-to-r from-gray-50 to-white">
    <div class="overflow-hidden border border-gray-300 rounded-lg ">
        
            <h2 class="flex items-center p-5 space-x-3 text-lg font-bold text-gray-800 md:text-xl lg:text-2xl">
               <i class="text-2xl fa-solid fa-users"></i>
                <span>Role Management</span>
              
            </h2>
            <div class="p-4 border-t border-gray-200 "> <!-- stats -->
            
                <div class="flex flex-col items-center gap-3 sm:flex-row md:gap-6">
                    <div class="flex items-center">
                        <div class="w-2 h-2 mr-1 bg-red-500 rounded-full md:w-3 md:h-3 md:mr-2"></div>
                        <span class="truncate">Developers: {{ $data['devs'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-2 h-2 mr-1 bg-blue-500 rounded-full md:w-3 md:h-3 md:mr-2"></div>
                        <span class="truncate">Administrators: {{ $data['admins'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-2 h-2 mr-1 bg-gray-500 rounded-full md:w-3 md:h-3 md:mr-2"></div>
                        <span class="truncate">Total Users: {{ $data['users']->count() }}</span>
                    </div>
            
                </div>
            </div>
       

        <div  class="border-t">
            <!-- Users List -->
            
                <ul class="py-3 space-y-3 md:space-y-4">
                    @foreach ($data['users'] as $user)
                    <li class="flex flex-col justify-between p-3 m-2 space-y-1 transition-colors duration-200 border border-gray-100 rounded-lg sm:flex-row sm:items-center items-left bg-gradient-to-r from-gray-50/50 to-white hover:border-blue-200 group">
                        <!-- User Info -->
                        
                           
                            <div class="flex items-center space-x-4 text-start"> <!--badge+userinfo-->
                                <div>  <!--role badge -->
                                    <!-- badge will not resize -->
                                    <span
                                        class="px-2 py-1  text-xs font-semibold rounded-full 
                                                                                                                                {{ $user->getRoleName() == 'dev' ? 'bg-gradient-to-r from-red-100 to-red-50 text-red-700 border border-red-200' : ($user->getRoleName() == 'admin' ? 'bg-gradient-to-r from-blue-100 to-blue-50 text-blue-700 border border-blue-200' : 
                                                                                                                                                              'bg-gradient-to-r from-gray-100 to-gray-50 text-gray-700 border border-gray-200') }}">
                                        {{ ucfirst($user->getRoleName()) }}
                                    </span>
                                </div>
                                <div class="flex flex-col items-center space-x-3 sm:flex-row"> <!-- name and email section -->
                                    <span class="font-medium text-gray-800 capitalize truncate">{{ $user->name }}</span>
                                    <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="items-center pt-3 text-center "> <!--button -->
                                <!-- Change Role Button -->
                                @if (!($user->isDev() && $data['devs']==1))
                                <button command="show-modal" commandfor="dialog-{{$user->id}}"
                                    class="px-3 py-2 text-xs font-medium text-blue-700 transition-all duration-200 border border-blue-200 rounded-lg md:w-auto md:px-4 md:py-2 md:text-sm bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 hover:shadow-sm hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                                    <div class="flex items-center justify-center space-x-2 md:justify-start">
                                        <i class="fa-solid fa-user-tag"></i>
                                        <span>Change Role</span>
                                    </div>
                                </button>
                            </div>
                           
                            @endif
                        

                       
                    </li>

                    <!-- Modal -->
                    <el-dialog>
                        <dialog id="dialog-{{$user->id}}" aria-labelledby="dialog-title"
                            class="fixed inset-0 z-50 overflow-y-auto bg-transparent">
                            <el-dialog-backdrop class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm">
                                <!-- Immagine di sfondo full screen -->
                                
                            </el-dialog-backdrop>

                            <div
                                class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                                <el-dialog-panel
                                    class="relative w-full overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-2xl md:rounded-2xl sm:my-8 sm:max-w-lg">

                                    <!-- Modal Header -->
                                    <div
                                        class="px-4 pt-4 pb-3 rounded-t-lg md:px-6 md:pt-6 md:pb-4 bg-gradient-to-r from-gray-50 to-white md:rounded-t-2xl">
                                        <div class="flex items-center">
                                            <!-- Icon -->
                                            <div class="flex items-center justify-center w-16 h-16">
                                               <img src="{{ Vite::asset('resources/assets/logos/logo-jdw-trans-black.png') }}" alt="Background"
                                                class="object-cover p-2">
                                            </div>

                                            <!-- Content -->
                                            <div class="flex-1 ml-3 md:ml-4">
                                                <h3 id="dialog-title"
                                                    class="text-base font-semibold text-gray-900 md:text-lg">
                                                    Change Role for <span class="text-blue-600 capitalize">{{
                                                        $user->name }}</span>
                                                </h3>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="px-4 py-4 bg-white md:px-6 md:py-5">
                                        <form method="POST" action="{{ route('dashboard.role-update', $user) }}"
                                            class="space-y-4 md:space-y-6">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="user_id" value="{{$user->id}}">

                                            <!-- Role Selector -->
                                            <div class="space-y-2 md:space-y-3">
                                                <label class="block text-sm font-medium">Select new
                                                    Role</label>
                                                <div class="relative">
                                                    <select name="role"
                                                        class="w-full px-3 py-2 transition-colors duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none cursor-pointer md:px-4 md:py-3 md:rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-400">
                                                        @foreach ($data['roles'] as $role)
                                                        <option value="{{$role->name}}" {{ $user->getRoleName() ==
                                                            $role->name ? 'selected' : '' }}
                                                            class="py-2">
                                                            {{ ucfirst($role->name) }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </div>

                                                <!-- Current Role Badge -->
                                                <div class="inline-flex items-center px-2 py-1 md:px-3 md:py-1.5 bg-gradient-to-r from-gray-100 to-gray-50 rounded-lg border border-gray-200">
                                                    <span class="text-xs text-gray-600">Current role:</span>
                                                    <span
                                                        class="ml-1 text-xs font-medium text-gray-800 md:ml-2 md:text-sm">{{
                                                        ucfirst($user->getRoleName())
                                                        }}</span>
                                                </div>
                                            </div>

                                            <!-- Buttons -->
                                            <div
                                                class="flex justify-end pt-4 space-x-2 border-t border-gray-100 md:space-x-3">
                                                <button type="button" command="close" commandfor="dialog-{{$user->id}}"
                                                    class="px-3 py-2 md:px-5 md:py-2.5 text-xs md:text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg md:rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 shadow-sm">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                    class="px-3 py-2 md:px-5 md:py-2.5 text-xs md:text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 border border-blue-600 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                                                    <div class="flex items-center space-x-1 md:space-x-2">
                                                        <svg class="w-3 h-3 md:w-4 md:h-4" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
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

                
               
            
        </div>
    </div>
</div>
@enddev