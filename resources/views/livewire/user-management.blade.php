<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold mb-6">User Roles</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('message') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Current Role</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4 font-bold uppercase text-xs">
                        <span class="px-2 py-1 rounded 
                            {{ $user->role == 'management' ? 'bg-red-100 text-red-800' : 
                              ($user->role == 'factory' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->id !== auth()->id()) <select wire:change="updateRole({{ $user->id }}, $event.target.value)" class="border-gray-300 rounded text-sm">
                                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="management" {{ $user->role == 'management' ? 'selected' : '' }}>Management</option>
                                <option value="factory" {{ $user->role == 'factory' ? 'selected' : '' }}>Factory</option>
                            </select>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>