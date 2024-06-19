<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('students.update', $student->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" class="mt-1 block w-full border p-2 rounded" value="{{ old('name', $student->name) }}">
                        </div>

                        <div class="mb-4">
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender" class="mt-1 block w-full border p-2 rounded">
                                <option value="Male" @if(old('gender', $student->gender) == 'Male') selected @endif>Male</option>
                                <option value="Female" @if(old('gender', $student->gender) == 'Female') selected @endif>Female</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="batch_year" class="block text-sm font-medium text-gray-700">Batch Year</label>
                            <input type="number" name="batch_year" class="mt-1 block w-full border p-2 rounded" value="{{ old('batch_year', $student->batch_year) }}">
                        </div>

                        <div class="mb-4">
                            <label for="class" class="block text-sm font-medium text-gray-700">Class</label>
                            <select name="class" class="mt-1 block w-full border p-2 rounded">
                                @foreach (range('A', 'L') as $class)
                                    <option value="Class {{ $class }}" @if(old('class', $student->class) == "Class $class") selected @endif>Class {{ $class }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="place_of_birth" class="block text-sm font-medium text-gray-700">Place of Birth</label>
                            <input type="text" name="place_of_birth" class="mt-1 block w-full border p-2 rounded" value="{{ old('place_of_birth', $student->place_of_birth) }}">
                        </div>

                        <div class="mb-4">
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="mt-1 block w-full border p-2 rounded" value="{{ old('date_of_birth', $student->date_of_birth) }}">
                        </div>

                        <div class="mb-4">
                            <label for="nisn" class="block text-sm font-medium text-gray-700">NISN</label>
                            <input type="text" name="nisn" class="mt-1 block w-full border p-2 rounded" value="{{ old('nisn', $student->nisn) }}">
                        </div>

                        <div class="mb-4">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone_number" class="mt-1 block w-full border p-2 rounded" value="{{ old('phone_number', $student->phone_number) }}">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" class="mt-1 block w-full border p-2 rounded" value="{{ old('email', $student->email) }}">
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border p-2 rounded">
                                <option value="active" @if(old('status', $student->status) == 'active') selected @endif>Active</option>
                                <option value="graduated" @if(old('status', $student->status) == 'graduated') selected @endif>Graduated</option>
                                <option value="dropped" @if(old('status', $student->status) == 'dropped') selected @endif>Dropped</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
