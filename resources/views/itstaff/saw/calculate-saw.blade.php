<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Calculate SAW') }}
            </h2>
            <div class="mb-4">
                <a href="{{ route('check-probability.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Lihat Semua Cek Probabilitas Siswa
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Form untuk mengecek probabilitas siswa -->
                    <h3 class="font-bold mb-4">Cek Probabilitas Siswa</h3>
                    <form id="check-probability-form">
                        <div class="mb-4">
                            <label for="student" class="block text-gray-700">Pilih Siswa:</label>
                            <select id="student" name="student" class="mt-1 block w-full">
                                @foreach ($students->where('status', 'active') as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="button" onclick="checkProbability()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Cek Probabilitas
                            </button>
                        </div>
                    </form>

                    <!-- Tabel C1 - C5 -->
                    <h3 class="font-bold mb-4">Hasil Perhitungan Kriteria (C1 - C5)</h3>
                    <table class="min-w-full bg-white mb-6">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">Sekolah</th>
                                <th class="py-2 px-4 border">C1 (Average School Score)</th>
                                <th class="py-2 px-4 border">C2 (Lowest Accepted Score)</th>
                                <th class="py-2 px-4 border">C3 (Academic Path Percentage)</th>
                                <th class="py-2 px-4 border">C4 (Non-Academic Path Percentage)</th>
                                <th class="py-2 px-4 border">C5 (Average Distance)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schools as $index => $school)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $school->name }}</td>
                                    <td class="py-2 px-4 border">{{ number_format($C1[$index], 2) }}</td>
                                    <td class="py-2 px-4 border">{{ number_format($C2[$index], 2) }}</td>
                                    <td class="py-2 px-4 border">{{ number_format($C3[$index], 2) }}</td>
                                    <td class="py-2 px-4 border">{{ number_format($C4[$index], 2) }}</td>
                                    <td class="py-2 px-4 border">{{ number_format($C5[$index], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Tabel Rating Kinerja (R) -->
                    <h3 class="font-bold mb-4">Rating Kinerja (R)</h3>
                    <table class="min-w-full bg-white mb-6">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">Sekolah</th>
                                <th class="py-2 px-4 border">R1 (C1)</th>
                                <th class="py-2 px-4 border">R2 (C2)</th>
                                <th class="py-2 px-4 border">R3 (C3)</th>
                                <th class="py-2 px-4 border">R4 (C4)</th>
                                <th class="py-2 px-4 border">R5 (C5)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schools as $index => $school)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $school->name }}</td>
                                    @foreach ($performanceRatings[$index] as $rating)
                                        <td class="py-2 px-4 border">{{ number_format($rating, 2) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Tabel Nilai Bobot Preferensi (Vi) -->
                    <h3 class="font-bold mb-4">Nilai Bobot Preferensi (Vi)</h3>
                    <table class="min-w-full bg-white mb-6">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">Rangking</th>
                                <th class="py-2 px-4 border">Sekolah</th>
                                <th class="py-2 px-4 border">Vi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schoolsSorted as $rank => $school)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $rank + 1 }}</td>
                                    <td class="py-2 px-4 border">{{ $school->name }}</td>
                                    <td class="py-2 px-4 border">{{ number_format($school->preference_value, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
function checkProbability() {
    var studentId = document.getElementById('student').value;

    // Fetch student details using AJAX
    fetch(`/itstaff/student-details/${studentId}`)
        .then(response => response.json())
        .then(data => {
            let achievementsHtml = '';
            if (data.achievements && data.achievements.length > 0) {
                achievementsHtml = data.achievements.map(achievement => `
                    <tr class="bg-white border-b">
                        <td class="px-4 py-2">${achievement.achievement_type}</td>
                        <td class="px-4 py-2">${achievement.activity_name}</td>
                        <td class="px-4 py-2">${achievement.level}</td>
                        <td class="px-4 py-2">${achievement.achievement}</td>
                        <td class="px-4 py-2">${achievement.achievement_year}</td>
                    </tr>
                `).join('');
            } else {
                achievementsHtml = `
                    <tr class="bg-white border-b">
                        <td colspan="5" class="px-4 py-2 text-center">No achievements found</td>
                    </tr>
                `;
            }

            let addressHtml = '';
            if (data.address) {
                addressHtml = `
                    <tr class="bg-white border-b">
                        <td class="px-4 py-2">${data.address.street}</td>
                        <td class="px-4 py-2">${data.address.subdistrict}</td>
                        <td class="px-4 py-2">${data.address.district}</td>
                        <td class="px-4 py-2">${data.address.city}</td>
                        <td class="px-4 py-2">${data.address.province}</td>
                        <td class="px-4 py-2">${data.address.postal_code}</td>
                        <td class="px-4 py-2">${data.address.location_type}</td>
                        <td class="px-4 py-2">${data.address.latitude}</td>
                        <td class="px-4 py-2">${data.address.longitude}</td>
                    </tr>
                `;
            } else {
                addressHtml = `
                    <tr class="bg-white border-b">
                        <td colspan="9" class="px-4 py-2 text-center">No address found</td>
                    </tr>
                `;
            }

            let finalScoreHtml = '';
            if (data.final_score) {
                finalScoreHtml = `
                    <tr class="bg-white border-b">
                        <td class="px-4 py-2">${data.final_score.mathematics}</td>
                        <td class="px-4 py-2">${data.final_score.science}</td>
                        <td class="px-4 py-2">${data.final_score.english}</td>
                        <td class="px-4 py-2">${data.final_score.indonesian}</td>
                        <td class="px-4 py-2">${data.final_score.civics}</td>
                        <td class="px-4 py-2">${data.final_score.religion}</td>
                        <td class="px-4 py-2">${data.final_score.physical_education}</td>
                        <td class="px-4 py-2">${data.final_score.arts_and_crafts}</td>
                        <td class="px-4 py-2">${data.final_score.local_content}</td>
                    </tr>
                `;
            } else {
                finalScoreHtml = `
                    <tr class="bg-white border-b">
                        <td colspan="9" class="px-4 py-2 text-center">No final score found</td>
                    </tr>
                `;
            }

            let schoolChoiceHtml = '';
            if (data.school_choice) {
                schoolChoiceHtml = `
                    <tr class="bg-white border-b">
                        <td class="px-4 py-2">${data.school_choice.first_choice}</td>
                        <td class="px-4 py-2">${data.school_choice.second_choice}</td>
                        <td class="px-4 py-2">${data.school_choice.third_choice}</td>
                    </tr>
                `;
            } else {
                schoolChoiceHtml = `
                    <tr class="bg-white border-b">
                        <td colspan="3" class="px-4 py-2 text-center">No school choices found</td>
                    </tr>
                `;
            }

            // Fetch probabilities
            fetch(`/itstaff/check-probability`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ student: studentId })
            })
            .then(response => response.json())
            .then(probabilities => {
                let probabilityHtml = `
                    <tr class="bg-white border-b">
                        <td class="px-4 py-2">${(probabilities.first_choice * 100).toFixed(2)}%</td>
                        <td class="px-4 py-2">${(probabilities.second_choice * 100).toFixed(2)}%</td>
                        <td class="px-4 py-2">${(probabilities.third_choice * 100).toFixed(2)}%</td>
                    </tr>
                `;

                let generalInfoHtml = `
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <td class="px-4 py-2">Nama</td>
                        <td class="px-4 py-2">Gender</td>
                        <td class="px-4 py-2">Tahun Angkatan</td>
                        <td class="px-4 py-2">Kelas</td>
                    </tr>
                    <tr class="bg-white border-b">
                        <td class="px-4 py-2">${data.name}</td>
                        <td class="px-4 py-2">${data.gender}</td>
                        <td class="px-4 py-2">${data.batch_year}</td>
                        <td class="px-4 py-2">${data.class}</td>
                    </tr>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <td class="px-4 py-2">Tempat, Tanggal Lahir</td>
                        <td class="px-4 py-2">NISN</td>
                        <td class="px-4 py-2">Nomor Telepon</td>
                        <td class="px-4 py-2">Email</td>
                    </tr>
                    <tr class="bg-white border-b">
                        <td class="px-4 py-2">${data.place_of_birth}, ${data.date_of_birth}</td>
                        <td class="px-4 py-2">${data.nisn}</td>
                        <td class="px-4 py-2">${data.phone_number}</td>
                        <td class="px-4 py-2">${data.email}</td>
                    </tr>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <td colspan="4" class="px-4 py-2">Status</td>
                    </tr>
                    <tr class="bg-white border-b">
                        <td colspan="4" class="px-4 py-2">${data.status}</td>
                    </tr>
                `;

                Swal.fire({
                    title: 'Detail Siswa',
                    html: `
                        <div class="flex flex-col space-y-4">
                            <div>
                                <h4 class="text-lg font-semibold">Informasi Umum</h4>
                                <table class="min-w-full bg-white">
                                    <tbody class="text-gray-600 text-sm font-light">
                                        ${generalInfoHtml}
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold">Alamat</h4>
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-4">Street</th>
                                            <th class="py-3 px-4">Subdistrict</th>
                                            <th class="py-3 px-4">District</th>
                                            <th class="py-3 px-4">City</th>
                                            <th class="py-3 px-4">Province</th>
                                            <th class="py-3 px-4">Postal Code</th>
                                            <th class="py-3 px-4">Location Type</th>
                                            <th class="py-3 px-4">Latitude</th>
                                            <th class="py-3 px-4">Longitude</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        ${addressHtml}
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold">Prestasi</h4>
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-4">Tipe Prestasi</th>
                                            <th class="py-3 px-4">Nama Kegiatan</th>
                                            <th class="py-3 px-4">Level</th>
                                            <th class="py-3 px-4">Prestasi</th>
                                            <th class="py-3 px-4">Tahun Prestasi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        ${achievementsHtml}
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold">Nilai Akhir</h4>
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-4">Matematika</th>
                                            <th class="py-3 px-4">IPA</th>
                                            <th class="py-3 px-4">Bahasa Inggris</th>
                                            <th class="py-3 px-4">Bahasa Indonesia</th>
                                            <th class="py-3 px-4">PKN</th>
                                            <th class="py-3 px-4">Agama</th>
                                            <th class="py-3 px-4">Penjas</th>
                                            <th class="py-3 px-4">Seni Budaya</th>
                                            <th class="py-3 px-4">Muatan Lokal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        ${finalScoreHtml}
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold">Pilihan Sekolah</h4>
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-4">Pilihan Pertama</th>
                                            <th class="py-3 px-4">Pilihan Kedua</th>
                                            <th class="py-3 px-4">Pilihan Ketiga</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        ${schoolChoiceHtml}
                                    </tbody>
                                </table>
                                <h4 class="text-lg font-semibold mt-4">Probabilitas Penerimaan</h4>
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-4">Probabilitas Pilihan Pertama</th>
                                            <th class="py-3 px-4">Probabilitas Pilihan Kedua</th>
                                            <th class="py-3 px-4">Probabilitas Pilihan Ketiga</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        ${probabilityHtml}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `,
                    width: '80%',
                    customClass: {
                        popup: 'px-4 py-6 rounded-lg shadow-lg'
                    },
                    showCloseButton: true,
                    showConfirmButton: false
                });
            })
            .catch(error => console.error('Error fetching probabilities:', error));
        })
        .catch(error => console.error('Error fetching student details:', error));
}
    </script>
</x-app-layout>
