<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/table.js'])
    <title>Kehadiran Pegawai</title>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-pink-100 min-h-screen font-sans">
    <!-- Header Mobile -->
    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-[#6B5DD3]">🕒 Kehadiran Pegawai</h1>
        <div>
            @include('components.ava')
        </div>
    </div>

    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <div class="flex-1 p-4 sm:p-6 fade-in">
            <!-- Header Desktop -->
            <div class="hidden md:flex justify-between items-center mb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#6B5DD3] flex items-center gap-2">
                    🕒 Kehadiran Pegawai
                </h1>
                @include('components.ava')
            </div>

            <!-- Card -->
            <div class="bg-white rounded-3xl shadow-xl p-4 sm:p-6 hover:shadow-2xl transition duration-300 ease-in-out overflow-x-auto">
                <!-- Filter -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    <h2 class="text-xl sm:text-2xl font-semibold text-[#6B5DD3] flex items-center gap-2">
                        📅 Kehadiran {{ $user->name }}
                    </h2>

                    <form method="GET" action="{{ route('kehadiran.pegawai', ['id' => $user->id]) }}"
                        class="flex flex-col sm:flex-row sm:items-end gap-4 w-full sm:w-auto">
                        <select name="bulan" id="bulan"
                            class="w-full sm:w-48 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:outline-none text-sm">
                            <option value="">Pilih Bulan</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>

                        <select name="tahun" id="tahun"
                            class="w-full sm:w-48 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:outline-none text-sm">
                            <option value="">Pilih Tahun</option>
                            @for ($y = 2020; $y <= now()->year; $y++)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>

                        <div class="flex gap-2">
                            <button type="submit"
                                class="px-4 py-2 bg-[#6B5DD3] text-white rounded-lg hover:bg-[#5848c2] transition text-sm font-semibold">
                                Filter
                            </button>
                            <a href="{{ route('kehadiran.pegawai', ['id' => $user->id]) }}"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition text-sm font-semibold">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full text-sm text-center text-gray-700 bg-white">
                        <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-4 whitespace-nowrap">Tanggal</th>
                                <th class="py-3 px-4 whitespace-nowrap">Jam</th>
                                <th class="py-3 px-4 whitespace-nowrap">Tipe Kehadiran</th>
                                <th class="py-3 px-4 whitespace-nowrap">Status</th>
                                @can('admin')
                                    <th class="py-3 px-4 whitespace-nowrap">Jam Submit</th>
                                    <th class="py-3 px-4 whitespace-nowrap">Foto</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse ($kehadiranList as $item)
                                <tr class="border-b border-gray-200">
                                    <td class="py-3 px-4">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d M Y') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ \Carbon\Carbon::parse($item->jam_buka)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($item->jam_tutup)->format('H:i') }}
                                    </td>
                                    <td class="py-3 px-4">{{ $item->tipe_kehadiran }}</td>
                                    <td class="py-3 px-4">
                                        <span class="font-semibold
                                            @if ($item->status === 'Hadir') text-green-600
                                            @elseif ($item->status === 'Tidak Hadir') text-red-600
                                            @elseif ($item->status === 'Sakit') text-blue-600
                                            @elseif ($item->status === 'Izin') text-yellow-600
                                            @elseif ($item->status === 'Libur') text-gray-500
                                            @else text-black @endif">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    @can('admin')
                                        <td class="py-3 px-4">
                                            {{ $item->jam_submit ? \Carbon\Carbon::parse($item->jam_submit)->format('H:i') : '-' }}
                                        </td>
                                        <td class="py-3 px-4">
                                            @if ($item->foto)
                                                <img src="{{ Storage::url($item->foto) }}" alt="Foto Absen"
                                                    class="w-10 h-10 object-cover mx-auto rounded" />
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="@can('admin') 6 @else 4 @endcan" class="py-6 text-gray-400 italic">
                                        😔 Belum ada data kehadiran
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $jadwalList->links() }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
