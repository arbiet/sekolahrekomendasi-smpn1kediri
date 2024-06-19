<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <form method="GET" action="{{ route('students.index') }}">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search students..." class="border p-2 rounded">
                            <select name="status" class="border p-2 rounded">
                                <option value="">All Status</option>
                                <option value="active" @if(request('status') == 'active') selected @endif>Active</option>
                                <option value="graduated" @if(request('status') == 'graduated') selected @endif>Graduated</option>
                                <option value="dropped" @if(request('status') == 'dropped') selected @endif>Dropped</option>
                            </select>
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                        <a href="{{ route('students.create') }}" class="bg-green-500 text-white p-2 rounded">
                            <i class="fas fa-plus"></i> Add Student
                        </a>
                    </div>

                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Batch Year</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Missing Info</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr class="hover:bg-gray-200">
                                    <td class="cursor-pointer" onclick="window.location='{{ route('students.show', $student->id) }}'">{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->gender }}</td>
                                    <td>{{ $student->batch_year }}</td>
                                    <td class="p-4">
                                        @if($student->address)
                                            {{ Str::limit($student->address->street . ', ' . $student->address->subdistrict . ', ' . $student->address->district . ', ' . $student->address->city . ', ' . $student->address->province . ', ' . $student->address->postal_code, 15, '...') }}
                                        @else
                                            No Address
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($student->status) }}</td>
                                    <td>
                                        @php
                                            $missingInfo = [];
                                            if (!$student->address) $missingInfo[] = 'Address';
                                                if (!$student->finalScore) $missingInfo[] = 'Final Scores';
                                            if (!$student->schoolChoice) $missingInfo[] = 'School Choices';
                                            if ($student->status == 'graduated' && !$student->graduatedSchool) $missingInfo[] = 'Graduated School';
                                        @endphp
                                        @if (!empty($missingInfo))
                                            <div class="relative group">
                                                <i class="fas fa-info-circle text-red-500"></i>
                                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2">
                                                    {{ implode(', ', $missingInfo) }}
                                                </div>
                                            </div>
                                        @else
                                            <i class="fas fa-check-circle text-green-500"></i>
                                        @endif
                                    </td>
                                    <td class="space-x-2">
                                        <a href="{{ route('students.edit', $student->id) }}" class="bg-yellow-500 text-white p-2 rounded">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button onclick="confirmDelete(event, {{ $student->id }})" class="bg-red-500 text-white p-2 rounded">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                        <form id="delete-form-{{ $student->id }}" action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(event, studentId) {
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
                    document.getElementById('delete-form-' + studentId).submit();
                }
            })
        }
    </script>
</x-app-layout>
