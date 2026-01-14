<div class="w-full border-t-2 border-b-2" x-data="{ open: false }">
    <div class="space-y-4">

        <button @click="open = !open" class="w-full p-4 text-left hover:bg-gray-50">
            <div class="flex items-center justify-between">
                <span class="font-medium">Filters Menu</span>
                <i class="transition-transform duration-300 fa-solid fa-chevron-down"
                    :class="open ? 'rotate-180' : ''"></i>
            </div>
        </button>
        <div x-show="open" x-collapse class="p-4 border-t border-gray-100">
            <!-- Content here -->
            <div
                class="px-4 py-6 border-t border-gray-200 bg-gradient-to-b from-gray-50/30 to-white sm:px-6 md:px-8 lg:px-10">
                <form method="GET" action="{{ route('projects.index') }}" class="space-y-6 md:space-y-8">

                    <!-- Filters Grid -->
                    <div
                        class="grid grid-cols-1 gap-4  {{Auth::user()->isAdmin()? 'lg:grid-cols-4': 'sm:grid-cols-3'}}   sm:gap-5 md:gap-6 lg:gap-8">

                        <!-- Search -->
                        <div class="text-center ">
                            <label
                                class="block mb-2 text-sm font-semibold text-gray-700 -translate-x-2 sm:mb-3 sm:text-base">
                                <i class="mr-2 text-blue-500 fa-solid fa-search"></i>
                                Search Projects
                            </label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Type name or description ..." class="w-full rounded-lg">
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="text-center">
                            <label
                                class="block mb-2 text-sm font-semibold text-gray-700 -translate-x-2 sm:mb-3 sm:text-base">
                                <i class="mr-2 text-purple-500 fa-solid fa-folder"></i>
                                Category
                            </label>
                            <div class="relative">
                                <select name="category" class="w-full rounded-lg">
                                    <option value="all" class="py-2"> All Categories</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ request('category')==$category->name ?
                                        'selected' : '' }}
                                        class="py-2">
                                        <span class="font-medium">{{ $category->label }}</span>
                                        <span class="ml-2 font-normal text-gray-500">
                                            ({{ $category->projects->count() ?? 0 }})
                                        </span>
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <!-- Technology Filter -->
                        <div class="text-center">
                            <label
                                class="block mb-2 text-sm font-semibold text-gray-700 -translate-x-2 sm:mb-3 sm:text-base">
                                <i class="mr-2 text-green-500 fa-solid fa-code"></i>
                                Technology
                            </label>

                            <select name="technology" class="w-full rounded-lg">
                                <option value="" class="py-2"> All Technologies</option>
                                @foreach($technologies as $tech)
                                <option value="{{ $tech->id }}" {{ request('technology')==$tech->id ? 'selected' : '' }}
                                    class="py-2">
                                    <span class="font-medium">{{ $tech->label }}</span>
                                    <span class="ml-2 font-normal text-gray-500">
                                        ({{ $tech->projects->count() ?? 0 }})
                                    </span>
                                </option>
                                @endforeach
                            </select>

                        </div>

                        @admin
                        <!-- Status Filter -->
                        <div class="text-center">
                            <label
                                class="block mb-2 text-sm font-semibold text-gray-700 -translate-x-2 sm:mb-3 sm:text-base">
                                <i class="mr-2 text-orange-500 fa-solid fa-flag"></i>
                                Status
                            </label>

                            <select name="published" class="w-full rounded-lg">
                                <option value="" class="py-2">
                                    All Status
                                    <span class="ml-1 font-bold">({{ $stats['total'] }})</span>
                                </option>
                                <option value="true" {{ request('published')==='true' ? 'selected' : '' }} class="py-2">
                                    Published
                                    <span class="ml-1 font-semibold text-green-600">
                                        ({{ $stats['published'] }})
                                    </span>
                                </option>
                                <option value="false" {{ request('published')==='false' ? 'selected' : '' }}
                                    class="py-2">
                                    Drafts
                                    <span class="ml-1 font-semibold text-yellow-600">
                                        ({{ $stats['drafts'] }})
                                    </span>
                                </option>
                            </select>


                        </div>
                        @endadmin
                    </div>

                    <!-- Sort and Actions -->

                    <div class="flex flex-col ">

                        <!-- Sort + buttons -->

                        <div class="flex flex-col items-center justify-between mb-3 space-x-2 space-y-2 sm:flex-row">
                            <label class="w-full text-sm font-semibold text-gray-700 sm:text-base md:text-lg">
                                <i class="mr-2 text-blue-500 fa-solid fa-sort"></i>
                                Sort by:
                            </label>
                            <!--selects-->
                            <div class="flex justify-between w-full space-x-2">
                                <!--order by  -->
                                <select name="sort_by" class="w-full border-2 border-gray-200 rounded-lg">
                                    <option value="created_at" {{ request('sort_by', 'created_at' )=='created_at'
                                        ? 'selected' : '' }}>
                                        Date
                                    </option>
                                    <option value="title" {{ request('sort_by')=='title' ? 'selected' : '' }}>
                                        Title
                                    </option>
                                    <option value="updated_at" {{ request('sort_by')=='updated_at' ? 'selected' : '' }}>
                                        Updated
                                    </option>
                                </select>
                                <!--Order asc-desc -->
                                <select name="sort_order" class="w-full border-2 border-gray-200 rounded-lg">
                                    <option value="desc" {{ request('sort_order', 'desc' )=='desc' ? 'selected' : '' }}>
                                        Descending
                                    </option>
                                    <option value="asc" {{ request('sort_order')=='asc' ? 'selected' : '' }}>
                                        Ascending
                                    </option>
                                </select>


                            </div>



                            <!-- Buttons Section -->
                            <div class="flex justify-between w-full space-x-3">
                                <button type="submit"
                                    class="items-center w-full p-2 space-x-2 text-green-800 bg-green-200 border border-green-800 rounded-md hover:bg-green-800 hover:text-green-200">
                                    <span>
                                        <i class="fa-solid fa-filter"></i>
                                        <span>Apply</span>
                                    </span>

                                </button>

                                <a href="{{ route('projects.index') }}"
                                    class="items-center w-full p-2 space-x-2 text-center text-red-800 bg-red-200 border border-red-800 rounded-md hover:bg-red-800 hover:text-red-200">
                                    <span>
                                        <i class="fa-solid fa-broom"></i>
                                        Clear
                                    </span>
                                </a>
                            </div>

                        </div>


                </form>
            </div>
        </div>

    </div>
</div>