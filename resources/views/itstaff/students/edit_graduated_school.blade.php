<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Graduated School') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('students.update_graduated_school', $student->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="selected_school" class="block text-sm font-medium text-gray-700">Selected School</label>
                            <input type="text" name="selected_school" class="mt-1 block w-full border p-2 rounded" value="{{ old('selected_school', $graduatedSchool->selected_school ?? '') }}">
                        </div>

                        <div class="mb-4">
                            <label for="accepted_school" class="block text-sm font-medium text-gray-700">Accepted School</label>
                            <input type="text" name="accepted_school" class="mt-1 block w-full border p-2 rounded" value="{{ old('accepted_school', $graduatedSchool->accepted_school ?? '') }}">
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
