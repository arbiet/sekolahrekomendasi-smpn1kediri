<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Facility Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <strong><i class="fas fa-building"></i> Facility Name:</strong> {{ $facility->facility_name }}
                    </div>
                    <div class="mb-4">
                        <strong><i class="fas fa-info-circle"></i> Facility Description:</strong> {{ $facility->facility_description }}
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('facilities.edit', $facility->id) }}" class="bg-yellow-500 text-white p-2 rounded">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
