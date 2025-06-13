@extends('layouts.app')

@section('title', 'Team Members')

@section('content')
<div class="space-y-6">
    <!-- Header with buttons -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Team Members</h2>
    </div>
    <!-- Search and filter section -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Search input -->
            <div class="relative w-full md:w-64">
                <input type="text" placeholder="Search team members..."
                       class="pl-10 pr-4 py-2 w-full rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <i class="ri-search-line absolute left-3 top-2.5 text-gray-400"></i>
            </div>

            <!-- Sort dropdown -->
            <div class="flex space-x-2">
                <select
                    id="sort-select"
                    class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    onchange="updateSort(this.value)"
                >
                    <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="name-asc" {{ $sort === 'name-asc' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="name-desc" {{ $sort === 'name-desc' ? 'selected' : '' }}>Name (Z-A)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Team members table -->
    <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Tasks</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover"
                                             src="{{ $user->profile_picture ? asset('images/' . $user->profile_picture) : asset('useravatar.avif') }}"
                                             alt="{{ $user->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->is_admin ? 'Admin' : 'Member' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->assigned_tasks_count }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="#" class="text-gray-600 hover:text-gray-900">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-900">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="{{ $users->previousPageUrl() }}&sort={{ $sort }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
                <a href="{{ $users->nextPageUrl() }}&sort={{ $sort }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">{{ $users->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $users->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $users->total() }}</span>
                        results
                    </p>
                </div>
                <div>
                    {{ $users->appends(['sort' => $sort])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateSort(sortValue) {
        // Get current URL and query parameters
        const url = new URL(window.location.href);

        // Update sort parameter
        url.searchParams.set('sort', sortValue);

        // Reload page with new sort parameter
        window.location.href = url.toString();
    }
</script>
@endsection
