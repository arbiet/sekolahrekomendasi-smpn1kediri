<!-- resources/views/itstaff/schooltargets/attach_extracurriculars.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attach Extracurriculars to ' . $schoolTarget->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('schooltargets.extracurriculars.store', $schoolTarget->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="activity_name" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-futbol"></i> Activity Name
                            </label>
                            <input type="text" name="activity_name" class="mt-1 block w-full border p-2 rounded" value="{{ old('activity_name') }}">
                        </div>

                        <div class="mb-4">
                            <label for="activity_description" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-info-circle"></i> Activity Description
                            </label>
                            <textarea name="activity_description" class="mt-1 block w-full border p-2 rounded">{{ old('activity_description') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-save"></i> Attach
                            </button>
                        </div>
                    </form>

                    <h3 class="mt-6 mb-4 text-lg font-semibold">Attached Extracurriculars</h3>

                    <form method="GET" action="{{ route('schooltargets.extracurriculars.attach', $schoolTarget->id) }}">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search activities..." class="border p-2 rounded">
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </form>

                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>Activity Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($extracurriculars as $activity)
                                <tr class="hover:bg-gray-200">
                                    <td>{{ $activity->activity_name }}</td>
                                    <td>{{ $activity->activity_description }}</td>
                                    <td class="space-x-2">
                                        <a href="{{ route('extracurriculars.edit', $activity->id) }}" class="bg-yellow-500 text-white p-2 rounded">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button onclick="confirmDelete(event, {{ $activity->id }})" class="bg-red-500 text-white p-2 rounded">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                        <form id="delete-form-{{ $activity->id }}" action="{{ route('extracurriculars.destroy', $activity->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $extracurriculars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(event, activityId) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + activityId).submit();
                }
            })
        }
    </script>
</x-app-layout>
