<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-blue-500 text-white p-4 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold">Total Students</h3>
                        <p class="text-2xl">{{ $totalStudents }}</p>
                    </div>
                    <div class="bg-green-500 text-white p-4 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold">Average Math Score</h3>
                        <p class="text-2xl">{{ $averageScores->avg_math }}</p>
                    </div>
                    <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold">Average Science Score</h3>
                        <p class="text-2xl">{{ $averageScores->avg_science }}</p>
                    </div>
                    <div class="bg-red-500 text-white p-4 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold">Average English Score</h3>
                        <p class="text-2xl">{{ $averageScores->avg_english }}</p>
                    </div>
                </div>

                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <canvas id="averageScoresChart"></canvas>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold">Schools</h3>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($schools as $school)
                                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                                    <h4 class="text-lg font-semibold">{{ $school->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $school->address }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold">Student Achievements</h3>
                        <div x-data="{ openSections: {} }">
                            @foreach ($studentAchievements as $year => $achievements)
                                <div class="mb-4">
                                    <button @click="openSections['{{ $year }}'] = !openSections['{{ $year }}']"
                                            class="w-full text-left px-4 py-2 text-lg font-semibold text-gray-800 bg-gray-200 rounded">
                                        {{ $year }}
                                    </button>
                                    <div x-show="openSections['{{ $year }}']" x-collapse>
                                        <ul class="pl-4 mt-2 text-gray-700">
                                            @foreach ($achievements as $achievement)
                                                <li>{{ $achievement->activity_name }} - {{ $achievement->level }} ({{ $achievement->achievement_year }})</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        var ctx = document.getElementById('averageScoresChart').getContext('2d');
        var averageScoresChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mathematics', 'Science', 'English', 'Indonesian', 'Civics', 'Religion', 'PE', 'Arts', 'Local Content'],
                datasets: [{
                    label: 'Average Scores',
                    data: [
                        {{ $averageScores->avg_math }},
                        {{ $averageScores->avg_science }},
                        {{ $averageScores->avg_english }},
                        {{ $averageScores->avg_indonesian }},
                        {{ $averageScores->avg_civics }},
                        {{ $averageScores->avg_religion }},
                        {{ $averageScores->avg_pe }},
                        {{ $averageScores->avg_arts }},
                        {{ $averageScores->avg_local }}
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
