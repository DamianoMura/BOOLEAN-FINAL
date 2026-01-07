<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
       
    </x-slot>
    <div class="py-12">
    @if (session('default-user'))
        @if (session('default-user')['name']!='changed'||session('default-user')['email']!='changed')
        <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
            <p class="text-3xl text-center text-red-500 capitalize">You must change your default credentials</p>
            <div class="max-w-xl">
        
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
        @else
          @if (session('default-user')['name']='changed'||session('default-user')['email']='changed')
          @endif
          <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
              <p class="text-3xl text-center text-red-500 capitalize">You must also change the password </p>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        @endif
       
    @else 
    
       
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
           
            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
          
        </div>
        @endif
    </div>
</x-app-layout>
