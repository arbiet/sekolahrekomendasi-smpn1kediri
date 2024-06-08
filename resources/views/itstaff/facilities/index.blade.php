<!-- resources/views/itstaff/facilities/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Facilities Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <form method="GET" action="{{ route('facilities.index') }}">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search facilities..." class="border p-2 rounded">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                        <a href="{{ route('facilities.create') }}" class="bg-green-500 text-white p-2 rounded">
                            <i class="fas fa-plus"></i> Add Facility
                        </a>
                    </div>

                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>School</th>
                                <th>Facility Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($facilities as $facility)
                                <tr class="hover:bg-gray-200">
                                    <td>{{ $facility->targetSchool->name }}</td>
                                    <td>{{ $facility->facility_name }}</td>
                                    <td>{{ $facility->facility_description }}</td>
                                    <td class="space-x-2">
                                        <a href="{{ route('facilities.edit', $facility->id) }}" class="bg-yellow-500 text-white p-2 rounded">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button onclick="confirmDelete(event, {{ $facility->id }})" class="bg-red-500 text-white p-2 rounded">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                        <form id="delete-form-{{ $facility->id }}" action="{{ route('facilities.destroy', $facility->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $facilities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(event, facilityId) {
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
                    document.getElementById('delete-form-' + facilityId).submit();
                }
            })
        }
    </script>
</x-app-layout>
