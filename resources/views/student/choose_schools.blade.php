<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Choose Schools') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">
                <div class="p-6 text-gray-900 w-1/2">
                    <form id="schoolForm" method="POST" action="{{ route('student.store_choice', $student) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="first_choice" class="block text-sm font-medium text-gray-700">First Choice</label>
                            <select name="first_choice" id="first_choice" class="mt-1 block w-full border p-2 rounded" data-choice="first_choice">
                                <option value="">Select a School</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->name }}" data-id="{{ $school->id }}" {{ old('first_choice', $student->schoolChoice->first_choice ?? '') == $school->name ? 'selected' : '' }}>{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="second_choice" class="block text-sm font-medium text-gray-700">Second Choice</label>
                            <select name="second_choice" id="second_choice" class="mt-1 block w-full border p-2 rounded" data-choice="second_choice">
                                <option value="">Select a School</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->name }}" data-id="{{ $school->id }}" {{ old('second_choice', $student->schoolChoice->second_choice ?? '') == $school->name ? 'selected' : '' }}>{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="third_choice" class="block text-sm font-medium text-gray-700">Third Choice</label>
                            <select name="third_choice" id="third_choice" class="mt-1 block w-full border p-2 rounded" data-choice="third_choice">
                                <option value="">Select a School</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->name }}" data-id="{{ $school->id }}" {{ old('third_choice', $student->schoolChoice->third_choice ?? '') == $school->name ? 'selected' : '' }}>{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Update</button>
                        </div>
                    </form>
                </div>
                
                <div class="p-6 text-gray-900 w-1/2" id="school-details">
                    <!-- School details will be displayed here -->
                    <h3 class="text-lg font-semibold">School Details</h3>
                    <div id="school-info">
                        <!-- School info will be injected here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const choices = ['first_choice', 'second_choice', 'third_choice'];
            const schoolDetails = document.getElementById('school-info');

            choices.forEach(choice => {
                document.getElementById(choice).addEventListener('change', function() {
                    updateChoices();
                    const selectedOption = this.options[this.selectedIndex];
                    const schoolId = selectedOption.getAttribute('data-id');
                    fetchSchoolDetails(schoolId);
                });
            });

            function updateChoices() {
                const selectedNames = choices.map(choice => document.getElementById(choice).value);
                choices.forEach(choice => {
                    const selectElement = document.getElementById(choice);
                    Array.from(selectElement.options).forEach(option => {
                        if (selectedNames.includes(option.value) && option.value !== "" && option.value !== selectElement.value) {
                            option.disabled = true;
                        } else {
                            option.disabled = false;
                        }
                    });
                });
            }

            function fetchSchoolDetails(schoolId) {
                if (schoolId) {
                    fetch(`/schools/json/${schoolId}`)
                        .then(response => response.json())
                        .then(data => {
                            schoolDetails.innerHTML = `
                                <h3 class="text-lg font-semibold">${data.name}</h3>
                                <h4 class="font-semibold mt-4">Location</h4>
                                <div id="map" style="height: 300px;"></div>
                                <h4 class="font-semibold mt-4">Facilities</h4>
                                <ul>
                                    ${data.facilities.map(facility => `<li>${facility.facility_name}</li>`).join('')}
                                </ul>
                                <h4 class="font-semibold mt-4">Extracurricular Activities</h4>
                                <ul>
                                    ${data.extracurriculars.map(activity => `<li>${activity.activity_name}</li>`).join('')}
                                </ul>
                            `;
                            // Initialize the map
                            const map = L.map('map').setView([data.latitude, data.longitude], 13);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);
                            L.marker([data.latitude, data.longitude]).addTo(map);
                        });
                } else {
                    schoolDetails.innerHTML = `<p>Select a school to see details.</p>`;
                }
            }

            // Initialize with previously selected values
            choices.forEach(choice => {
                const selectedOption = document.getElementById(choice).selectedOptions[0];
                if (selectedOption) {
                    const schoolId = selectedOption.getAttribute('data-id');
                    fetchSchoolDetails(schoolId);
                }
            });
            updateChoices();
        });
    </script>
</x-app-layout>
