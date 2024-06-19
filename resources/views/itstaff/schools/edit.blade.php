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
                        @method('PATCH')

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full border p-2 rounded" value="{{ $school->name }}" required>
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" id="address" class="mt-1 block w-full border p-2 rounded" required>{{ $school->address }}</textarea>
                        </div>

                        <!-- City -->
                        <div class="mb-4">
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" id="city" class="mt-1 block w-full border p-2 rounded" value="{{ $school->city }}" required>
                        </div>

                        <!-- Accreditation -->
                        <div class="mb-4">
                            <label for="accreditation" class="block text-sm font-medium text-gray-700">Accreditation</label>
                            <input type="text" name="accreditation" id="accreditation" class="mt-1 block w-full border p-2 rounded" value="{{ $school->accreditation }}" required>
                        </div>

                        <!-- Website -->
                        <div class="mb-4">
                            <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                            <input type="url" name="website" id="website" class="mt-1 block w-full border p-2 rounded" value="{{ $school->website }}">
                        </div>

                        <!-- Latitude -->
                        <div class="mb-4">
                            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="mt-1 block w-full border p-2 rounded" value="{{ $school->latitude }}" readonly>
                        </div>

                        <!-- Longitude -->
                        <div class="mb-4">
                            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="mt-1 block w-full border p-2 rounded" value="{{ $school->longitude }}" readonly>
                        </div>

                        <div id="map" style="height: 400px;" class="mb-4"></div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([{{ $school->latitude ?? -7.81623 }}, {{ $school->longitude ?? 112.01602 }}], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker = L.marker([{{ $school->latitude ?? -7.81623 }}, {{ $school->longitude ?? 112.01602 }}], {
                draggable: true
            }).addTo(map);

            marker.on('dragend', function (e) {
                var latlng = marker.getLatLng();
                document.getElementById('latitude').value = latlng.lat;
                document.getElementById('longitude').value = latlng.lng;
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            });
        });
    </script>
</x-app-layout>
