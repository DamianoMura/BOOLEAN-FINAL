<div class="p-4 rounded-lg bg-gray-50">
     <h3 class="mb-3 font-semibold text-gray-700">Available users</h3>
     <ul class="divide-y divide-gray-200">
          @foreach($user_names as $name)
          <li class="flex items-center py-2">
               <span class="w-2 h-2 mr-3 bg-green-500 rounded-full"></span>
               {{ $name }}
          </li>
          @endforeach
     </ul>
</div>