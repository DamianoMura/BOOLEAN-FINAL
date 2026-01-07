<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between text-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Dashboard') }}
                
            </h2>
           
        </div>
    </x-slot>
@if (session('status'))
<dev class="self-center p-2 text-center text-green-500 border border-green-500 rounded-lg">
    {{ session('status')}}
</dev>
@endif

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
