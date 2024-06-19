<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Final Scores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('students.update_final_scores', $student->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="mathematics" class="block text-sm font-medium text-gray-700">Mathematics</label>
                            <input type="number" name="mathematics" class="mt-1 block w-full border p-2 rounded" value="{{ old('mathematics', $finalScore->mathematics ?? '') }}" min="0" max="100">
                        </div>

                        <div class="mb-4">
                            <label for="science" class="block text-sm font-medium text-gray-700">Science</label>
                            <input type="number" name="science" class="mt-1 block w-full border p-2 rounded" value="{{ old('science', $finalScore->science ?? '') }}" min="0" max="100">
                        </div>

                        <div class="mb-4">
                            <label for="english" class="block text-sm font-medium text-gray-700">English</label>
                            <input type="number" name="english" class="mt-1 block w-full border p-2 rounded" value="{{ old('english', $finalScore->english ?? '') }}" min="0" max="100">
                        </div>

                        <div class="mb-4">
                            <label for="indonesian" class="block text-sm font-medium text-gray-700">Indonesian</label>
                            <input type="number" name="indonesian" class="mt-1 block w-full border p-2 rounded" value="{{ old('indonesian', $finalScore->indonesian ?? '') }}" min="0" max="100">
                        </div>

                        <div class="mb-4">
                            <label for="civics" class="block text-sm font-medium text-gray-700">Civics</label>
                            <input type="number" name="civics" class="mt-1 block w-full border p-2 rounded" value="{{ old('civics', $finalScore->civics ?? '') }}" min="0" max="100">
                        </div>

                        <div class="mb-4">
                            <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                            <input type="number" name="religion" class="mt-1 block w-full border p-2 rounded" value="{{ old('religion', $finalScore->religion ?? '') }}" min="0" max="100">
                        </div>

                        <div class="mb-4">
                            <label for="physical_education" class="block text-sm font-medium text-gray-700">Physical Education</label>
                            <input type="number" name="physical_education" class="mt-1 block w-full border p-2 rounded" value="{{ old('physical_education', $finalScore->physical_education ?? '') }}" min="0" max="100">
                        </div>

                        <div class="mb-4">
                            <label for="arts_and_crafts" class="block text-sm font-medium text-gray-700">Arts and Crafts</label>
                            <input type="number" name="arts_and_crafts" class="mt-1 block w-full border p-2 rounded" value="{{ old('arts_and_crafts', $finalScore->arts_and_crafts ?? '') }}" min="0" max="100">
                        </div>

                        <div class="mb-4">
                            <label for="local_content" class="block text-sm font-medium text-gray-700">Local Content</label>
                            <input type="number" name="local_content" class="mt-1 block w-full border p-2 rounded" value="{{ old('local_content', $finalScore->local_content ?? '') }}" min="0" max="100">
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
