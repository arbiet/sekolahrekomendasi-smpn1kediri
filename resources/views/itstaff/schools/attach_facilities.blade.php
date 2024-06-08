<!-- resources/views/itstaff/schools/attach_facilities.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attach Facilities to ' . $school->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('schools.facilities.store', $school->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="facility_name" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-building"></i> Facility Name
                            </label>
                            <input type="text" name="facility_name" class="mt-1 block w-full border p-2 rounded" value="{{ old('facility_name') }}">
                        </div>

                        <div class="mb-4">
                            <label for="facility_description" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-info-circle"></i> Facility Description
                            </label>
                            <textarea name="facility_description" class="mt-1 block w-full border p-2 rounded">{{ old('facility_description') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-save"></i> Attach
                            </button>
                        </div>
                    </form>

                    <h3 class="mt-6 mb-4 text-lg font-semibold">Attached Facilities</h3>

                    <form method="GET" action="{{ route('schools.facilities.attach', $school->id) }}">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search facilities..." class="border p-2 rounded">
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </form>

                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>Facility Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($facilities as $facility)
                                <tr class="hover:bg-gray-200">
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
