<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Address') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('students.update_address', $student->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="street" class="block text-sm font-medium text-gray-700">Street</label>
                            <input type="text" name="street" class="mt-1 block w-full border p-2 rounded" value="{{ old('street', $address->street) }}">
                        </div>

                        <div class="mb-4">
                            <label for="subdistrict" class="block text-sm font-medium text-gray-700">Subdistrict</label>
                            <input type="text" name="subdistrict" class="mt-1 block w-full border p-2 rounded" value="{{ old('subdistrict', $address->subdistrict) }}">
                        </div>

                        <div class="mb-4">
                            <label for="district" class="block text-sm font-medium text-gray-700">District</label>
                            <input type="text" name="district" class="mt-1 block w-full border p-2 rounded" value="{{ old('district', $address->district) }}">
                        </div>

                        <div class="mb-4">
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" class="mt-1 block w-full border p-2 rounded" value="{{ old('city', $address->city) }}">
                        </div>

                        <div class="mb-4">
                            <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                            <input type="text" name="province" class="mt-1 block w-full border p-2 rounded" value="{{ old('province', $address->province) }}">
                        </div>

                        <div class="mb-4">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                            <input type="text" name="postal_code" class="mt-1 block w-full border p-2 rounded" value="{{ old('postal_code', $address->postal_code) }}">
                        </div>

                        <div class="mb-4">
                            <label for="location_type" class="block text-sm font-medium text-gray-700">Location Type</label>
                            <input type="text" name="location_type" class="mt-1 block w-full border p-2 rounded" value="{{ old('location_type', $address->location_type) }}">
                        </div>

                        <div class="mb-4">
                            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="mt-1 block w-full border p-2 rounded" value="{{ old('latitude', $address->latitude) }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="mt-1 block w-full border p-2 rounded" value="{{ old('longitude', $address->longitude) }}" readonly>
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
            var map = L.map('map').setView([{{ $address->latitude ?? 0 }}, {{ $address->longitude ?? 0 }}], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker = L.marker([{{ $address->latitude ?? 0 }}, {{ $address->longitude ?? 0 }}], {
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
