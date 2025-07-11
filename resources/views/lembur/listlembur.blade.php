<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/table.js'])
    <title>Lembur Pegawai</title>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-pink-100 min-h-screen font-sans">
    <div class="flex h-screen">
        @include('components.sidebar')

        <div class="flex-1 p-6 fade-in">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-3xl font-extrabold text-[#6B5DD3]">⏰ Lembur Pegawai</h1>
                @include('components.ava')
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-6 hover:shadow-2xl transition duration-300 ease-in-out">
                <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                    <h2 class="text-2xl font-semibold text-[#6B5DD3] flex items-center gap-2">
                        📝 Tabel Pengajuan
                    </h2>
                    <div class="flex gap-5">
                    <form action="{{ route('lembur.admin') }}" method="GET" id="search-form">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari Pegawai..."
                                class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:outline-none text-sm" />
                        </form>
                    <a href="{{ route('riwayatlembur') }}">
                        <button class="bg-blue-100 hover:bg-blue-200 text-[#3b82f6] font-semibold text-sm px-4 py-2 rounded-lg transition">
                            Riwayat Lembur
                        </button>
                    </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden text-center text-gray-700 text-sm">
                        <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-4 whitespace-nowrap">Nama Pegawai</th>
                                <th class="py-3 px-4 whitespace-nowrap">Tanggal</th>
                                <th class="py-3 px-4 whitespace-nowrap">Waktu Mulai</th>
                                <th class="py-3 px-4 whitespace-nowrap">Waktu Selesai</th>
                                <th class="py-3 px-4 whitespace-nowrap">Keterangan</th>
                                <th class="py-3 px-4 whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse ($lemburs as $lembur)
                                <tr class="border-b border-gray-200 transition duration-200 ease-in-out">
                                    <td class="py-3 px-4">{{ $lembur->user->name }}</td>
                                    <td class="py-3 px-4">{{ $lembur->tanggal }}</td>
                                    <td class="py-3 px-4">{{ $lembur->waktu_mulai }}</td>
                                    <td class="py-3 px-4">{{ $lembur->waktu_selesai }}</td>
                                    <td class="py-3 px-4">{{ $lembur->keterangan_lembur }}</td>
                                    <td class="py-3 px-4">
                                        @php $status = strtolower(trim($lembur->status)); @endphp
                                        @if ($status === 'dalam proses')
                                            <div class="flex justify-center gap-2">
                                                <form action="{{ route('lembur.setujui', $lembur->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    @include('components.buttonapprove')
                                                </form>
                                                <form action="{{ route('lembur.tolak', $lembur->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    @include('components.buttonrejected')
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-500 italic">Sudah diproses</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-gray-400 italic">😔 Belum ada pengajuan lembur.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $lemburs->links() }}
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
