<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Facility') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('facilities.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="school_target_id" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-school"></i> School
                            </label>
                            <select name="school_target_id" class="mt-1 block w-full border p-2 rounded">
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>

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
                                <i class="fas fa-save"></i> Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
