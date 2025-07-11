<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/table.js'])
    <title>Riwayat Cuti/Perizinan Pegawai</title>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-pink-100 min-h-screen font-sans">
    <div class="flex h-screen">
        @include('components.sidebar')

        <div class="flex-1 p-6 fade-in">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-3xl font-extrabold text-[#6B5DD3]">📋 Riwayat Cuti/Perizinan</h1>
                @include('components.ava')
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-6 hover:shadow-2xl transition duration-300 ease-in-out">
                <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                    <h2 class="text-2xl font-semibold text-[#6B5DD3] flex items-center gap-2">
                        🗓️ Data Riwayat Cuti/Perizinan
                    </h2>
                    <form action="{{ route('riwayatcuti') }}" method="GET" id="search-form">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari Pegawai..."
                            class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:outline-none text-sm" />
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table
                        class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden text-center text-gray-700 text-sm">
                        <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-4 whitespace-nowrap">Nama Pegawai</th>
                                <th class="py-3 px-4 whitespace-nowrap">Keterangan</th>
                                <th class="py-3 px-4 whitespace-nowrap">Tanggal Mulai</th>
                                <th class="py-3 px-4 whitespace-nowrap">Tanggal Selesai</th>
                                <th class="py-3 px-4 whitespace-nowrap">Alasan</th>
                                <th class="py-3 px-4 whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse ($riwayatCuti as $cuti)
                                <tr
                                    class="border-b border-gray-200 transition duration-200 ease-in-out hover:bg-indigo-50">
                                    <td class="py-3 px-4">{{ $cuti->user->name }}</td>
                                    <td class="py-3 px-4">{{ $cuti->keterangan }}</td>
                                    <td class="py-3 px-4">{{ $cuti->tanggal_mulai }}</td>
                                    <td class="py-3 px-4">{{ $cuti->tanggal_selesai }}</td>
                                    <td class="py-3 px-4">{{ $cuti->alasan }}</td>
                                    <td class="py-3 px-4">
                                        @php
                                            $statusColor = match ($cuti->status) {
                                                'Disetujui' => 'bg-green-100 text-green-600',
                                                'Ditolak' => 'bg-red-100 text-red-600',
                                                default => 'bg-yellow-100 text-yellow-600',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                            {{ $cuti->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-gray-400 italic">😔 Tidak ada data cuti yang
                                        sudah diproses.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $riwayatCuti->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        const input = document.querySelector('#search-form input[name="search"]');
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('search-form').submit();
            }
        });
    </script>
</body>

</html>
