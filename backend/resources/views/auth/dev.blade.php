<x-dashboard>
  <div class="columns-1">
    <x-user-list
    :users="$users"
    :roles="$roles"
    :devs="$devs"
    :admins="$admins"
    >
    </x-user-list>
  </div>

</x-dashboard>


