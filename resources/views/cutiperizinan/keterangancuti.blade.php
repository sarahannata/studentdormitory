<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/table.js'])
    <title>Cuti/Perizinan</title>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-pink-100 min-h-screen font-sans overflow-x-hidden">

    <!-- Header Mobile -->
    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-[#6B5DD3]">📅 Cuti/Perizinan</h1>
        <div>@include('components.ava')</div>
    </div>

    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <div class="flex-1 p-4 sm:p-6 fade-in">
            <!-- Header Desktop -->
            <div class="hidden md:flex justify-between items-center mb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#6B5DD3] flex items-center gap-2">
                    📅 Cuti/Perizinan
                </h1>
                @include('components.ava')
            </div>

            <!-- Card -->
            <div
                class="bg-white rounded-3xl shadow-xl p-4 sm:p-6 hover:shadow-2xl transition duration-300 ease-in-out overflow-x-auto">
                <!-- Title + Button -->
                <div class="flex flex-row justify-between items-center flex-wrap gap-4 mb-6">
                    <h2 class="text-xl sm:text-2xl font-semibold text-[#6B5DD3] flex items-center gap-2">
                        ✍️ Pengajuan Cuti/Izin
                    </h2>
                    <a href="{{ route('cutiperizinan.create') }}">
                        @include('components.plusbutton')
                    </a>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full text-sm text-center text-gray-700 bg-white">
                        <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-4 whitespace-nowrap">Keterangan</th>
                                <th class="py-3 px-4 whitespace-nowrap">Alasan</th>
                                <th class="py-3 px-4 whitespace-nowrap">Tanggal Mulai</th>
                                <th class="py-3 px-4 whitespace-nowrap">Tanggal Selesai</th>
                                <th class="py-3 px-4 whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($cutis as $data)
                                <tr class="border-b border-gray-200 transition duration-200 ease-in-out">
                                    <td class="py-3 px-4">{{ $data->keterangan }}</td>
                                    <td class="py-3 px-4">{{ $data->alasan }}</td>
                                    <td class="py-3 px-4">{{ $data->tanggal_mulai }}</td>
                                    <td class="py-3 px-4">{{ $data->tanggal_selesai }}</td>
                                    <td class="py-3 px-4">
                                        @php
                                            $statusColor = match (strtolower($data->status)) {
                                                'disetujui' => 'green',
                                                'ditolak' => 'red',
                                                default => 'yellow',
                                            };
                                        @endphp
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700">
                                            {{ $data->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-gray-400 italic">😔 Belum ada pengajuan
                                        cuti/izin.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $cutis->links() }}
                </div>
            </div>
        </div>
    </div>

</body>

</html>
