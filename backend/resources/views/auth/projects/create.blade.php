<x-app-layout>
  <x-slot name="header">
    <h1 class="font-extrabold ">Create new Project</h1>
  </x-slot>

  <div class="w-full py-2 ">
    <div class="mx-auto bg-white max-w-7xl sm:px-6 lg:px-8">
     asd
     

      <!-- Main Content -->
     <x-app-layout>
      <x-slot name="header">
        <div class="flex flex-col justify-between w-full sm:flex-row sm:items-center">
          <div class="flex items-center justify-between w-full px-3">
            <div class="flex items-center space-x-3">
              <div class="flex-col">
                <ul class="inline-flex items-center space-x-1 md:space-x-3">
                  <li>
                    <div class="flex items-center">
                      <i class="text-gray-400 fa-solid fa-chevron-right"></i>
                      <a href="{{ route('projects.index') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                        Projects
                      </a>
                    </div>
                  </li>
                  
                  <li aria-current="page">
                    <div class="flex items-center">
                      <i class="text-gray-400 fa-solid fa-chevron-right"></i>
                      <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                        Create New Project
                      </span>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </x-slot>
    
      <div class="w-full py-6">
        <div class="max-w-6xl mx-auto">
          <!-- Success/Error Messages -->
          @if (session('success'))
          <div class="p-4 mb-6 border border-green-200 rounded-lg bg-green-50">
            <div class="flex items-center">
              <i class="text-green-600 fa-solid fa-check-circle"></i>
              <span class="ml-2 text-green-700">{{ session('success') }}</span>
            </div>
          </div>
          @endif
    
          @if ($errors->any())
          <div class="p-4 mb-6 border border-red-200 rounded-lg bg-red-50">
            <div class="flex items-center">
              <i class="text-red-600 fa-solid fa-exclamation-circle"></i>
              <span class="ml-2 font-medium text-red-700">Please fix the following errors:</span>
            </div>
            <ul class="mt-2 ml-6 text-sm text-red-600 list-disc">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
    
          <!-- Edit Project Form -->
          <div
            class="flex flex-col p-6 space-y-6 transition-colors duration-200 border border-gray-100 rounded-lg bg-gradient-to-r from-gray-50/50 to-white">
            <form action="{{ route('projects.store') }}" method="POST">
              @csrf
              
    
    
              <div class="flex flex-col items-center justify-between pb-6 border-b">
                <!-- title  -->
                <div class="flex flex-col w-full">
                  <input type="text" name="title" value=""
                    class="text-2xl font-semibold text-gray-800 bg-transparent border rounded-lg focus:ring-0 focus:border-blue-300"
                    placeholder="Project Title" required>
                </div>
              </div>
              <!-- category + published -->
              <div class="flex flex-wrap items-center gap-3 p-3 border border-gray-200 rounded-lg bg-white/50">
                @foreach($categories as $category)
                <div class="flex items-center">
                  <input type="radio" id="category-{{ $category->id }}" name="category_id" value="{{ $category->id }}"
                  class="hidden peer">
                  <label for="category-{{ $category->id }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-100 border border-gray-300 rounded-lg cursor-pointer peer-checked:bg-blue-100 peer-checked:text-blue-800 peer-checked:border-blue-400 hover:bg-gray-200">
                    <span class="mr-2">{{ $category->label }}</span>
                    @if($category->icon)
                    <i class="{{ $category->icon }}"></i>
                    @endif
                  </label>
                </div>
                @endforeach
              </div>
              <div class="text-center">
                <input type="checkbox" id="published" name="published" value="0" 
                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <label for="published" class="ml-2 text-sm font-medium text-center text-gray-700">
                  Published
                </label>
              </div>
    
          </div>
          <!-- Technologies Selection -->
          <div class="mt-3 space-y-2">
            <label class="block text-sm font-medium text-center text-gray-700">
              Technologies
            </label>
            <div class="flex flex-wrap gap-2 p-3 border border-gray-200 rounded-lg bg-white/50">
              @foreach($technologies as $tech)
              <div class="flex items-center">
                <input type="checkbox" id="tech-{{ $tech->id }}" name="technologies[]" value="{{ $tech->id }}"
                class="hidden peer">
                <label for="tech-{{ $tech->id }}"
                  class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-800 bg-blue-100 border border-blue-200 rounded-full cursor-pointer peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-700 hover:bg-blue-200">
                  {{ $tech->label }}
                  <i class="ml-1 {{ $tech->fontawesome_class }}"></i>
                </label>
              </div>
              @endforeach
            </div>
          </div>
          <!-- Description -->
          <div class="mt-3 space-y-2">
            <label for="description" class="block text-sm font-medium text-center text-gray-700">
              Brief Description
            </label>
            <textarea id="description" name="description" rows="4"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50"
              placeholder="Describe your project..."></textarea>
          </div>
    
    
    
    
    
    
          <!-- Form Actions -->
          <div class="flex items-center justify-end pt-6 border-t">
            <a href="{{ route('projects.index') }}"
              class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-200">
              Cancel
            </a>
            <button type="submit"
              class="px-5 py-2.5 ml-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
              <i class="mr-2 fa-solid fa-pen-ruler"></i>
              Create Project
            </button>
          </div>
          </form>
        </div>
      </div>
      </div>
    
    
    </x-app-layout>
    </div>
  </div>


</x-app-layout>