<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/table.js'])
    <title>Kehadiran Pegawai</title>
</head>

<body class="bg-gradient-to-br from-[#f5f3ff] to-[#f0e9ff] min-h-screen text-gray-800">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-8 fade-in">
                <h1 class="text-3xl font-extrabold text-[#6B5DD3] flex items-center gap-2">
                    📋 Kehadiran Pegawai
                </h1>
                @include('components.ava')
            </div>

            <!-- Tabel Kehadiran -->
            <div class="bg-white rounded-2xl shadow-lg p-8 fade-in">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-[#6B5DD3] flex items-center gap-2">
                        🧾 Tabel Daftar Pegawai
                    </h2>
                    <form action="{{ route('kehadiranpegawai.index') }}" method="GET" id="search-form">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari Pegawai..."
                            class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:outline-none text-sm" />
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table
                        class="min-w-full bg-white rounded-lg border border-[#6B5DD3]/30 overflow-hidden text-center">
                        <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-6 w-1/3">Nama Pegawai</th>
                                <th class="py-3 px-6 w-1/3">Divisi</th>
                                <th class="py-3 px-6 w-1/3">Posisi</th>
                            </tr>
                        </thead>
                        <tbody id="listkehadiran" class="text-gray-700 text-sm">
                            @forelse ($pegawaiList as $user)
                                <tr onclick="window.location='{{ route('kehadiran.pegawai', ['id' => $user->id]) }}'"
                                    class="border-b border-[#6B5DD3]/20 cursor-pointer hover:bg-[#6B5DD3]/5 hover:scale-[1.01] hover:shadow-md transition duration-200 ease-in-out">
                                    <td class="py-3 px-6 font-medium">{{ $user->name }}</td>
                                    <td class="py-3 px-6">
                                        {{ $user->divisi->nama_divisi }} </td>
                                    <td class="py-3 px-6">{{ $user->posisi }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-6 text-gray-400 italic">😔 Tidak ada data pegawai
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $pegawaiList->appends(request()->query())->links() }}
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
