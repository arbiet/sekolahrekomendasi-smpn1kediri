<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('School Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <strong><i class="fas fa-school"></i> Name:</strong> {{ $school->name }}
                    </div>
                    <div class="mb-4">
                        <strong><i class="fas fa-map-marker-alt"></i> Address:</strong> {{ $school->address }}
                    </div>
                    <div class="mb-4">
                        <strong><i class="fas fa-city"></i> City:</strong> {{ $school->city }}
                    </div>
                    <div class="mb-4">
                        <strong><i class="fas fa-star"></i> Accreditation:</strong> {{ $school->accreditation }}
                    </div>
                    <div class="mb-4">
                        <strong><i class="fas fa-globe"></i> Website:</strong> <a href="{{ $school->website }}" target="_blank">{{ $school->website }}</a>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('schools.edit', $school->id) }}" class="bg-yellow-500 text-white p-2 rounded">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
