<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cek Probabilitas Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold mb-4">Daftar Probabilitas Siswa</h3>

                    <table class="min-w-full bg-white mb-6">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">Nama Siswa</th>
                                <th class="py-2 px-4 border">Pilihan Pertama</th>
                                <th class="py-2 px-4 border">Pilihan Kedua</th>
                                <th class="py-2 px-4 border">Pilihan Ketiga</th>
                                <th class="py-2 px-4 border">Probabilitas Pertama</th>
                                <th class="py-2 px-4 border">Probabilitas Kedua</th>
                                <th class="py-2 px-4 border">Probabilitas Ketiga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $student->name }}</td>
                                    <td class="py-2 px-4 border">{{ $student->schoolChoice->first_choice }}</td>
                                    <td class="py-2 px-4 border">{{ $student->schoolChoice->second_choice }}</td>
                                    <td class="py-2 px-4 border">{{ $student->schoolChoice->third_choice }}</td>
                                    <td class="py-2 px-4 border">{{ number_format($student->probabilities['first_choice'] * 100, 2) }}%</td>
                                    <td class="py-2 px-4 border">{{ number_format($student->probabilities['second_choice'] * 100, 2) }}%</td>
                                    <td class="py-2 px-4 border">{{ number_format($student->probabilities['third_choice'] * 100, 2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
