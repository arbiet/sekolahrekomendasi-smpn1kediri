<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center mb-6">
                        <img class="w-24 h-24 rounded-full mx-auto" src="{{ $student->profile_picture }}" alt="{{ $student->name }}">
                        <h3 class="text-2xl font-semibold mt-4">{{ $student->name }}</h3>
                        <p class="text-gray-600">{{ ucfirst($student->status) }}</p>
                    </div>

                    <div class="grid grid-cols-3 gap-6 text-center mb-6">
                        <div>
                            <h4 class="text-xl font-bold">{{ $student->achievements->count() }}</h4>
                            <p class="text-gray-600">Achievements</p>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold">{{ $student->finalScore ? $student->average_score : 'N/A' }}</h4>
                            <p class="text-gray-600">Final Score (Average)</p>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold">{{ $student->schoolChoice ? 1 : 0 }}</h4>
                            <p class="text-gray-600">School Choices</p>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="mb-6">
                        <h4 class="text-xl font-bold mb-2">Address</h4>
                        @if($student->address)
                            <p>{{ $student->address->street }}, {{ $student->address->subdistrict }}, {{ $student->address->district }}, {{ $student->address->city }}, {{ $student->address->province }}, {{ $student->address->postal_code }}</p>
                        @else
                            <p>No address available. Please edit to add the address.</p>
                        @endif
                        <div class="text-right mt-2">
                            <a href="{{ route('students.edit_address', $student->id) }}" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-edit"></i> Edit Address
                            </a>
                        </div>
                    </div>

                    <!-- Achievements -->
                    <div class="mb-6">
                        <h4 class="text-xl font-bold mb-2">Achievements</h4>
                        @if($student->achievements->isNotEmpty())
                            <ul class="list-disc pl-5">
                                @foreach($student->achievements as $achievement)
                                    <li>{{ $achievement->achievement_type }} - {{ $achievement->activity_name }} - {{ $achievement->level }} - {{ $achievement->achievement }} ({{ $achievement->achievement_year }})</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No achievements available. Please edit to add achievements.</p>
                        @endif
                        <div class="text-right mt-2">
                            <a href="{{ route('students.edit_achievements', $student->id) }}" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-edit"></i> Edit Achievements
                            </a>
                        </div>
                    </div>

                    <!-- Final Scores -->
                    <div class="mb-6">
                        <h4 class="text-xl font-bold mb-2">Final Scores</h4>
                        @if($student->finalScore)
                            <ul class="list-disc pl-5">
                                <li>Mathematics: {{ $student->finalScore->mathematics }}</li>
                                <li>Science: {{ $student->finalScore->science }}</li>
                                <li>English: {{ $student->finalScore->english }}</li>
                                <li>Indonesian: {{ $student->finalScore->indonesian }}</li>
                                <li>Civics: {{ $student->finalScore->civics }}</li>
                                <li>Religion: {{ $student->finalScore->religion }}</li>
                                <li>Physical Education: {{ $student->finalScore->physical_education }}</li>
                                <li>Arts and Crafts: {{ $student->finalScore->arts_and_crafts }}</li>
                                <li>Local Content: {{ $student->finalScore->local_content }}</li>
                            </ul>
                        @else
                            <p>No final scores available. Please edit to add final scores.</p>
                        @endif
                        <div class="text-right mt-2">
                            <a href="{{ route('students.edit_final_scores', $student->id) }}" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-edit"></i> Edit Final Scores
                            </a>
                        </div>
                    </div>

                    <!-- School Choices -->
                    <div class="mb-6">
                        <h4 class="text-xl font-bold mb-2">School Choices</h4>
                        @if($student->schoolChoice)
                            <ul class="list-disc pl-5">
                                <li><i class="fas fa-star text-yellow-500"></i> First Choice: {{ $student->schoolChoice->first_choice }}</li>
                                <li><i class="fas fa-star text-gray-400"></i> Second Choice: {{ $student->schoolChoice->second_choice }}</li>
                                <li><i class="fas fa-star text-gray-300"></i> Third Choice: {{ $student->schoolChoice->third_choice }}</li>
                            </ul>
                        @else
                            <p>No school choices available. Please edit to add school choices.</p>
                        @endif
                        <div class="text-right mt-2">
                            <a href="{{ route('students.edit_school_choices', $student->id) }}" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-edit"></i> Edit School Choices
                            </a>
                        </div>
                    </div>

                    <!-- Graduated School -->
                    <div class="mb-6">
                        <h4 class="text-xl font-bold mb-2">Graduated School</h4>
                        @if($student->graduatedSchool)
                            <p>Selected School: {{ $student->graduatedSchool->selected_school }}</p>
                            <p>Accepted School: {{ $student->graduatedSchool->accepted_school }}</p>
                        @else
                            <p>No graduated school information available. Please edit to add graduated school information.</p>
                        @endif
                        <div class="text-right mt-2">
                            <a href="{{ route('students.edit_graduated_school', $student->id) }}" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-edit"></i> Edit Graduated School
                            </a>
                        </div>
                    </div>

                    <div class="flex justify-between mt-4">
                        <a href="{{ route('students.index') }}" class="bg-gray-500 text-white p-2 rounded">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <a href="{{ route('students.edit', $student->id) }}" class="bg-yellow-500 text-white p-2 rounded ml-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
