<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/table.js'])
    <title>Detail Kehadiran Pegawai</title>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-pink-100 min-h-screen font-sans">
    <div class="flex h-screen">
        @include('components.sidebar')

        <div class="flex-1 p-6 fade-in">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-extrabold text-[#6B5DD3] flex items-center gap-2">
                    📋 Detail Kehadiran Pegawai
                </h1>
                @include('components.ava')
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-6 hover:shadow-2xl transition duration-300 ease-in-out">
                <h2 class="text-2xl font-semibold text-[#6B5DD3] mb-6">
                    Jadwal:
                    <span class="font-normal text-gray-700">
                        {{ $jadwal->tipe_jadwal === 'Setiap Hari' ? 'Senin - Sabtu' : \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d M Y') }}
                    </span> |
                    <span
                        class="font-normal text-gray-700">{{ \Carbon\Carbon::parse($jadwal->jam_buka)->format('H:i') }}
                        - {{ \Carbon\Carbon::parse($jadwal->jam_tutup)->format('H:i') }}</span>
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden text-center">
                        <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] uppercase text-xs font-semibold">
                            <tr>
                                @if ($jadwal->tipe_jadwal == 'Setiap Hari')
                                    <th class="py-3 px-4">Tanggal</th>
                                @endif
                                <th class="py-3 px-4">Nama Pegawai</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Jam Submit</th>
                                <th class="py-3 px-4">Foto</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse ($users as $user)
                                @php
                                    $kehadiran = $kehadiranByUser[$user->id] ?? null;
                                    $jamTutup = \Carbon\Carbon::parse($jadwal->jam_tutup);
                                    $sekarang = \Carbon\Carbon::now();
                                    $status = '-';

                                    if ($kehadiran) {
                                        $status = $kehadiran->status;
                                    } elseif ($sekarang->greaterThan($jamTutup)) {
                                        $status = 'Tidak Hadir';
                                    } else {
                                        $status = 'Belum Absen';
                                    }
                                @endphp
                                <tr class="border-b border-gray-200">
                                    @if ($jadwal->tipe_jadwal == 'Setiap Hari')
                                        <td class="py-3 px-4">
                                            {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                                        </td>
                                    @endif
                                    <td class="py-3 px-4">
                                        {{ $user->name }}
                                    </td>
                                    <td class="py-3 px-4">
                                        @php
                                            $status = $kehadiranByUser[$user->id]->status ?? 'Belum Ada';
                                            $textClass = match ($status) {
                                                'Hadir' => 'text-green-600',
                                                'Tidak Hadir' => 'text-red-600',
                                                'Izin' => 'text-yellow-600',
                                                'Sakit' => 'text-blue-600',
                                                default => 'text-gray-500',
                                            };
                                        @endphp

                                        <span class="text-sm font-semibold {{ $textClass }}">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-4">
                                        @if ($kehadiran && $kehadiran->jam_submit)
                                            {{ \Carbon\Carbon::parse($kehadiran->jam_submit)->timezone('Asia/Jakarta')->format('H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if ($kehadiran && $kehadiran->foto)
                                            <img src="{{ Storage::url($kehadiran->foto) }}" alt="Foto Absen"
                                                class="w-10 h-10 object-cover mx-auto rounded-lg border border-gray-300 shadow-sm" />
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada foto</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $jadwal->tipe_jadwal == 'Setiap Hari' ? 5 : 4 }}"
                                        class="py-6 text-gray-400 italic">
                                        😔 Tidak ada pegawai
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
