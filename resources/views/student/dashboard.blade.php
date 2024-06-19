<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col space-y-4">
                        <div>
                            <h4 class="text-lg font-semibold">Informasi Umum</h4>
                            <table class="min-w-full bg-white">
                                <tbody class="text-gray-600 text-sm font-light">
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <td class="px-4 py-2">Nama</td>
                                        <td class="px-4 py-2">Gender</td>
                                        <td class="px-4 py-2">Tahun Angkatan</td>
                                        <td class="px-4 py-2">Kelas</td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <td class="px-4 py-2">{{ $student->name }}</td>
                                        <td class="px-4 py-2">{{ $student->gender }}</td>
                                        <td class="px-4 py-2">{{ $student->batch_year }}</td>
                                        <td class="px-4 py-2">{{ $student->class }}</td>
                                    </tr>
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <td class="px-4 py-2">Tempat, Tanggal Lahir</td>
                                        <td class="px-4 py-2">NISN</td>
                                        <td class="px-4 py-2">Nomor Telepon</td>
                                        <td class="px-4 py-2">Email</td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <td class="px-4 py-2">{{ $student->place_of_birth }}, {{ $student->date_of_birth }}</td>
                                        <td class="px-4 py-2">{{ $student->nisn }}</td>
                                        <td class="px-4 py-2">{{ $student->phone_number }}</td>
                                        <td class="px-4 py-2">{{ $student->email }}</td>
                                    </tr>
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <td colspan="4" class="px-4 py-2">Status</td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <td colspan="4" class="px-4 py-2">{{ $student->status }}</td>
                                    </tr>
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
                                    <tr class="bg-white border-b">
                                        <td class="px-4 py-2">{{ $student->address->street }}</td>
                                        <td class="px-4 py-2">{{ $student->address->subdistrict }}</td>
                                        <td class="px-4 py-2">{{ $student->address->district }}</td>
                                        <td class="px-4 py-2">{{ $student->address->city }}</td>
                                        <td class="px-4 py-2">{{ $student->address->province }}</td>
                                        <td class="px-4 py-2">{{ $student->address->postal_code }}</td>
                                        <td class="px-4 py-2">{{ $student->address->location_type }}</td>
                                        <td class="px-4 py-2">{{ $student->address->latitude }}</td>
                                        <td class="px-4 py-2">{{ $student->address->longitude }}</td>
                                    </tr>
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
                                    @foreach ($student->achievements as $achievement)
                                        <tr class="bg-white border-b">
                                            <td class="px-4 py-2">{{ $achievement->achievement_type }}</td>
                                            <td class="px-4 py-2">{{ $achievement->activity_name }}</td>
                                            <td class="px-4 py-2">{{ $achievement->level }}</td>
                                            <td class="px-4 py-2">{{ $achievement->achievement }}</td>
                                            <td class="px-4 py-2">{{ $achievement->achievement_year }}</td>
                                        </tr>
                                    @endforeach
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
                                    <tr class="bg-white border-b">
                                        <td class="px-4 py-2">{{ $student->finalScore->mathematics }}</td>
                                        <td class="px-4 py-2">{{ $student->finalScore->science }}</td>
                                        <td class="px-4 py-2">{{ $student->finalScore->english }}</td>
                                        <td class="px-4 py-2">{{ $student->finalScore->indonesian }}</td>
                                        <td class="px-4 py-2">{{ $student->finalScore->civics }}</td>
                                        <td class="px-4 py-2">{{ $student->finalScore->religion }}</td>
                                        <td class="px-4 py-2">{{ $student->finalScore->physical_education }}</td>
                                        <td class="px-4 py-2">{{ $student->finalScore->arts_and_crafts }}</td>
                                        <td class="px-4 py-2">{{ $student->finalScore->local_content }}</td>
                                    </tr>
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
                                    <tr class="bg-white border-b">
                                        <td class="px-4 py-2">{{ $student->schoolChoice->first_choice }}</td>
                                        <td class="px-4 py-2">{{ $student->schoolChoice->second_choice }}</td>
                                        <td class="px-4 py-2">{{ $student->schoolChoice->third_choice }}</td>
                                    </tr>
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
                                    <tr class="bg-white border-b">
                                        <td class="px-4 py-2">{{ number_format($probabilities['first_choice'] * 100, 2) }}%</td>
                                        <td class="px-4 py-2">{{ number_format($probabilities['second_choice'] * 100, 2) }}%</td>
                                        <td class="px-4 py-2">{{ number_format($probabilities['third_choice'] * 100, 2) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
