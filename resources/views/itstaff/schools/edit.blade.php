<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit School') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('schools.update', $school->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-school"></i> Name
                            </label>
                            <input type="text" name="name" value="{{ $school->name }}" class="mt-1 block w-full border p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-map-marker-alt"></i> Address
                            </label>
                            <textarea name="address" class="mt-1 block w-full border p-2 rounded">{{ $school->address }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="city" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-city"></i> City
                            </label>
                            <input type="text" name="city" value="{{ $school->city }}" class="mt-1 block w-full border p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label for="accreditation" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-star"></i> Accreditation
                            </label>
                            <input type="text" name="accreditation" value="{{ $school->accreditation }}" class="mt-1 block w-full border p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label for="website" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-globe"></i> Website
                            </label>
                            <input type="url" name="website" value="{{ $school->website }}" class="mt-1 block w-full border p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label for="passing_rate" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-chart-line"></i> Passing Rate
                            </label>
                            <input type="number" name="passing_rate" value="{{ $school->academics->first()->passing_rate ?? '' }}" class="mt-1 block w-full border p-2 rounded" step="0.01">
                        </div>

                        <div class="mb-4">
                            <label for="average_score" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-chart-bar"></i> Average Score
                            </label>
                            <input type="number" name="average_score" value="{{ $school->academics->first()->average_score ?? '' }}" class="mt-1 block w-full border p-2 rounded" step="0.01">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('facilities.create') }}" class="bg-green-500 text-white p-2 rounded">
                            <i class="fas fa-plus"></i> Add Facility
                        </a>
                        <a href="{{ route('extracurriculars.create') }}" class="bg-green-500 text-white p-2 rounded">
                            <i class="fas fa-plus"></i> Add Extracurricular
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
