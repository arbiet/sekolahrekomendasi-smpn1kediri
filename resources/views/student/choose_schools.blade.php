<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Choose Schools') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('student.store_choice', $student) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="first_choice" class="block text-sm font-medium text-gray-700">First Choice</label>
                            <select name="first_choice" id="first_choice" class="mt-1 block w-full border p-2 rounded">
                                @foreach($schools as $school)
                                    <option value="{{ $school->name }}" {{ old('first_choice', $student->schoolChoice->first_choice ?? '') == $school->name ? 'selected' : '' }}>{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="second_choice" class="block text-sm font-medium text-gray-700">Second Choice</label>
                            <select name="second_choice" id="second_choice" class="mt-1 block w-full border p-2 rounded">
                                @foreach($schools as $school)
                                    <option value="{{ $school->name }}" {{ old('second_choice', $student->schoolChoice->second_choice ?? '') == $school->name ? 'selected' : '' }}>{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="third_choice" class="block text-sm font-medium text-gray-700">Third Choice</label>
                            <select name="third_choice" id="third_choice" class="mt-1 block w-full border p-2 rounded">
                                @foreach($schools as $school)
                                    <option value="{{ $school->name }}" {{ old('third_choice', $student->schoolChoice->third_choice ?? '') == $school->name ? 'selected' : '' }}>{{ $school->name }}</option>
                                @endforeach
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
