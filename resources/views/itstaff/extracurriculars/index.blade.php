<!-- resources/views/itstaff/extracurriculars/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Extracurriculars Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <form method="GET" action="{{ route('extracurriculars.index') }}">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search activities..." class="border p-2 rounded">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                        <a href="{{ route('extracurriculars.create') }}" class="bg-green-500 text-white p-2 rounded">
                            <i class="fas fa-plus"></i> Add Activity
                        </a>
                    </div>

                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>School</th>
                                <th>Activity Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($extracurriculars as $activity)
                                <tr class="hover:bg-gray-200">
                                    <td>{{ $activity->targetSchool->name }}</td>
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
