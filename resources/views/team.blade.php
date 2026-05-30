@extends('layouts.app')

@section('title', 'Team Members')

@section('content')

    <div class="space-y-4">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between gap-3">
            <p class="text-sm text-gray-500">
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} members
            </p>
            @if (auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('teams.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700
                  text-white text-sm font-medium rounded-lg transition-colors duration-150">
                    <i class="ri-user-add-line"></i> Create Team
                </a>
            @endif
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-800">
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                Member</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                Role</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                Tasks</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                Status</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                Joined</th>
                            @if (auth()->check() && auth()->user()->role === 'admin')
                                <th
                                    class="px-5 py-3.5 text-right text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-100">

                                {{-- Member --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $user->profile_picture ?: asset('useravatar.avif') }}"
                                            alt="{{ $user->name }}"
                                            class="w-9 h-9 rounded-full object-cover flex-shrink-0 border border-gray-100">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Role --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        <i class="ri-user-line text-xs"></i> Member
                                    </span>
                                </td>

                                {{-- Tasks --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="text-sm font-semibold text-gray-800">{{ $user->assigned_tasks_count }}</span>
                                        <span class="text-xs text-gray-400">assigned</span>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Active
                                    </span>
                                </td>

                                {{-- Joined --}}
                                <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>

                                {{-- Actions (admin only) --}}
                                @if (auth()->check() && auth()->user()->role === 'admin')
                                    <td class="px-5 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('teams.edit', $user) }}" title="Edit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400
                                          hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                                <button type="button"
                                                        data-url="{{ route('teams.destroy', $user) }}"
                                                        data-name="{{ $user->name }}"
                                                        title="Delete"
                                                        class="delete-user-btn w-8 h-8 flex items-center justify-center rounded-lg text-gray-400
                                                               hover:bg-red-50 hover:text-red-600 transition-colors">
                                                    <i class="ri-delete-bin-line text-base"></i>
                                                </button>
                                        </div>
                                    </td>
                                @endif

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class="ri-team-line text-2xl text-gray-400"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-600">No team members yet</p>
                                            <p class="text-xs text-gray-400 mt-1">Add your first member to get started</p>
                                        </div>
                                        @if (auth()->check() && auth()->user()->role === 'admin')
                                            <a href="{{ route('teams.create') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                                          text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                                                <i class="ri-user-add-line"></i> Add first member
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="px-5 py-3.5 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            @endif

        </div>
    </div>
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const deleteModalText = document.getElementById('deleteModalText');
        const deleteSubmitBtn = deleteForm.querySelector('button[type="submit"]');

        let lastClickedBtn = null;
        let isSubmitting = false;

        document.querySelectorAll('.delete-user-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const url = btn.getAttribute('data-url');
                const name = btn.getAttribute('data-name');
                deleteForm.action = url;
                deleteModalText.textContent = `Are you sure you want to delete ${name}? This action cannot be undone.`;
                lastClickedBtn = btn;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        // Prevent multiple submits
        deleteForm.addEventListener('submit', function (e) {
            if (isSubmitting) {
                e.preventDefault();
                return;
            }
            isSubmitting = true;
            if (deleteSubmitBtn) deleteSubmitBtn.disabled = true;
            if (lastClickedBtn) lastClickedBtn.disabled = true;
        });

        document.getElementById('cancelDelete').addEventListener('click', function () {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            // reset
            if (deleteSubmitBtn) deleteSubmitBtn.disabled = false;
            if (lastClickedBtn) lastClickedBtn.disabled = false;
            isSubmitting = false;
            lastClickedBtn = null;
        });

        // Close modal when clicking outside dialog
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                if (deleteSubmitBtn) deleteSubmitBtn.disabled = false;
                if (lastClickedBtn) lastClickedBtn.disabled = false;
                isSubmitting = false;
                lastClickedBtn = null;
            }
        });
    });
    </script>
    @endpush

@endsection

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-2">Delete Team Member</h3>
            <p id="deleteModalText" class="text-sm text-gray-600 mb-4">Are you sure you want to delete this team member? This action cannot be undone.</p>

            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" id="cancelDelete" class="px-4 py-2 bg-gray-100 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
                </div>
            </form>
        </div>
    </div>
