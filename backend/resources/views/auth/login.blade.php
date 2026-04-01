<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Live Demo</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Select a user to explore the application</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="demo_user" :value="__('Select a User')" />
            <select id="demo_user" name="demo_user"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                @foreach($demoUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->getRoleLabel() }})</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('demo_user')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Enter Demo') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-xs text-center text-gray-400 dark:text-gray-500">
        Each session starts with a fresh copy of the database.
    </div>
</x-guest-layout>
