<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/table.js'])
    <title>Jadwal Kehadiran Pegawai</title>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-pink-100 min-h-screen font-sans">
    <div class="flex h-screen">
        @include('components.sidebar')

        <div class="flex-1 p-6 fade-in">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-extrabold text-[#6B5DD3]">📅 Jadwal Kehadiran Pegawai</h1>
                @include('components.ava')
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-6 hover:shadow-2xl transition duration-300 ease-in-out">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold text-[#6B5DD3] flex items-center gap-2">
                        🕒 Table Kehadiran
                    </h2>
                    <div class="flex">
                        <form method="GET" action="{{ route('jadwal.index') }}" class=" flex gap-2 items-end">
                            <div>
                                <select name="bulan" id="bulan"
                                    class="w-60 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:outline-none text-sm">
                                    <option value="">Pilih Bulan</option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}"
                                            {{ request('bulan') == $m ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <select name="tahun" id="tahun"
                                    class="w-60 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:outline-none text-sm">
                                    <option value="">Pilih Tahun</option>
                                    @for ($y = 2020; $y <= now()->year; $y++)
                                        <option value="{{ $y }}"
                                            {{ request('tahun') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit"
                                class="px-4 py-2 bg-[#6B5DD3] text-white rounded-lg hover:bg-[#5848c2] transition text-sm font-semibold">
                                Filter
                            </button>
                            <a href="{{ route('jadwal.index') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition text-sm font-semibold">
                                Reset
                            </a>
                        </form>
                        <a href="{{ route('jadwal.create') }}" class="mt-1">
                            @include('components.plusbutton')
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden text-center">
                        <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Tipe Kehadiran</th>
                                <th class="py-3 px-4">Tipe Jadwal</th>
                                <th class="py-3 px-4">Jam Buka</th>
                                <th class="py-3 px-4">Jam Tutup</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse ($jadwals as $jadwal)
                                <tr onclick="window.location='{{ route('kehadiran.index', ['jadwal_id' => $jadwal->id]) }}'"
                                    class="border-b hover:bg-[#6B5DD3]/5 transition cursor-pointer hover:scale-[1.01]">
                                    <td class="py-3 px-4">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}
                                    </td>
                                    <td class="py-3 px-4">{{ $jadwal->tipe_kehadiran }}</td>
                                    <td class="py-3 px-4">
                                        {{ $jadwal->tipe_jadwal === 'tanggal' ? 'Tanggal Tertentu' : ($jadwal->tipe_jadwal === 'setiap_hari' ? 'Setiap Hari' : '-') }}
                                    </td>
                                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($jadwal->jam_buka)->format('H:i') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_tutup)->format('H:i') }}
                                    </td>
                                    <td
                                        class="py-3 px-4 {{ $jadwal->is_aktif ? 'text-green-600' : 'text-red-600' }} font-bold">
                                        {{ $jadwal->is_aktif ? 'Aktif ✅' : 'Nonaktif ❌' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <form action="{{ route('jadwal.toggleStatus', $jadwal->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                class="px-4 py-1 rounded-full {{ $jadwal->is_aktif ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white text-xs font-semibold transition">
                                                {{ $jadwal->is_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-gray-400 italic">😔 Tidak ada jadwal ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $jadwals->links() }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
