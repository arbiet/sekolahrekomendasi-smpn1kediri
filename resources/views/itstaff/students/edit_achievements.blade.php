<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Achievements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('students.update_achievements', $student->id) }}">
                        @csrf
                        @method('PUT')

                        @foreach($achievements as $achievement)
                            <div x-data="{ open: false }" class="mb-4 border rounded-lg">
                                <div @click="open = !open" class="bg-gray-200 p-4 cursor-pointer flex justify-between items-center">
                                    <h3 class="text-lg font-medium">{{ $achievement->achievement_type }} ({{ $achievement->achievement_year }})</h3>
                                    <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                                </div>
                                <div x-show="open" class="p-4">
                                    <div class="mb-4">
                                        <label for="achievement_type_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Achievement Type</label>
                                        <input type="text" name="achievement_type_{{ $achievement->id }}" class="mt-1 block w-full border p-2 rounded" value="{{ old('achievement_type_' . $achievement->id, $achievement->achievement_type) }}">
                                    </div>

                                    <div class="mb-4">
                                        <label for="activity_name_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Activity Name</label>
                                        <input type="text" name="activity_name_{{ $achievement->id }}" class="mt-1 block w-full border p-2 rounded" value="{{ old('activity_name_' . $achievement->id, $achievement->activity_name) }}">
                                    </div>

                                    <div class="mb-4">
                                        <label for="level_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Level</label>
                                        <input type="text" name="level_{{ $achievement->id }}" class="mt-1 block w-full border p-2 rounded" value="{{ old('level_' . $achievement->id, $achievement->level) }}">
                                    </div>

                                    <div class="mb-4">
                                        <label for="achievement_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Achievement</label>
                                        <input type="text" name="achievement_{{ $achievement->id }}" class="mt-1 block w-full border p-2 rounded" value="{{ old('achievement_' . $achievement->id, $achievement->achievement) }}">
                                    </div>

                                    <div class="mb-4">
                                        <label for="achievement_year_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Achievement Year</label>
                                        <input type="number" name="achievement_year_{{ $achievement->id }}" class="mt-1 block w-full border p-2 rounded" value="{{ old('achievement_year_' . $achievement->id, $achievement->achievement_year) }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
