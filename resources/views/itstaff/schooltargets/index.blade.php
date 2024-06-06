<!-- resources/views/itstaff/schooltargets/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('School Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <form method="GET" action="{{ route('schooltargets.index') }}">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search schools..." class="border p-2 rounded">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                        <div class="flex space-x-2">
                            <a href="{{ route('schooltargets.create') }}" class="bg-green-500 text-white p-2 rounded">
                                <i class="fas fa-plus"></i> Add School
                            </a>
                            <a href="{{ route('facilities.index') }}" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-building"></i> Facilities
                            </a>
                            <a href="{{ route('extracurriculars.index') }}" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-futbol"></i> Extracurriculars
                            </a>
                        </div>
                    </div>

                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>City</th>
                                <th>Accreditation</th>
                                <th>Facilities</th>
                                <th>Extracurriculars</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schools as $school)
                                <tr class="hover:bg-gray-200">
                                    <td class="cursor-pointer" onclick="window.location='{{ route('schooltargets.show', $school->id) }}'">{{ $school->name }}</td>
                                    <td>{{ $school->city }}</td>
                                    <td>{{ $school->accreditation }}</td>
                                    <td>
                                        @foreach($school->facilities as $facility)
                                            <span class="badge badge-primary">{{ $facility->facility_name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($school->extracurriculars as $extracurricular)
                                            <span class="badge badge-primary">{{ $extracurricular->activity_name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="space-x-2">
                                        <a href="{{ route('schooltargets.edit', $school->id) }}" class="bg-yellow-500 text-white p-2 rounded">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button onclick="confirmDelete(event, {{ $school->id }})" class="bg-red-500 text-white p-2 rounded">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                        <form id="delete-form-{{ $school->id }}" action="{{ route('schooltargets.destroy', $school->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="{{ route('schooltargets.facilities.attach', $school->id) }}" class="bg-blue-500 text-white p-2 rounded">
                                            <i class="fas fa-building"></i> Facilities
                                        </a>
                                        <a href="{{ route('schooltargets.extracurriculars.attach', $school->id) }}" class="bg-blue-500 text-white p-2 rounded">
                                            <i class="fas fa-futbol"></i> Extracurriculars
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $schools->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(event, schoolId) {
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
                    document.getElementById('delete-form-' + schoolId).submit();
                }
            })
        }
    </script>
</x-app-layout>
