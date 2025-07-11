<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/table.js'])
    <title>Slip Gaji Pegawai - {{ $user->name }}</title>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-pink-100 min-h-screen font-sans">
    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-[#6B5DD3]">🧾 Slip Gaji Pegawai</h1>
        <div>
            @include('components.ava')
        </div>
    </div>

    <div class="flex flex-col md:flex-row min-h-screen">
        @include('components.sidebar')

        <div class="flex-1 p-4 sm:p-6 fade-in">
            <!-- Header -->
            <div class="hidden sm:flex flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#6B5DD3]">🧾 Slip Gaji Pegawai: {{ $user->name }}</h1>
                <div class="w-full sm:w-auto">
                    @include('components.ava')
                </div>
            </div>

            <!-- Card Container -->
            <div class="bg-white rounded-3xl shadow-xl p-4 sm:p-6 hover:shadow-2xl transition duration-300 ease-in-out">
                <!-- Top Area: Title + Search + Button -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                    <h2 class="text-xl sm:text-2xl font-semibold text-[#6B5DD3] flex items-center gap-2">
                        📄 Daftar Slip Gaji
                    </h2>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full sm:w-auto">
                        <form action="{{ route('listslipgajipegawai', $user->id) }}" method="GET" id="search-form" class="w-full sm:w-64">
                            <input type="text" name="bulan" value="{{ request('bulan') }}"
                                placeholder="Cari Bulan..."
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:outline-none text-sm" />
                        </form>

                        @can('admin')
                            <a href="{{ route('slipgaji.create', ['id' => $user->id]) }}">
                                @include('components.plusbutton')
                            </a>
                        @endcan
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full text-sm text-center text-gray-700 bg-white">
                        <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-4 whitespace-nowrap">Bulan</th>
                                <th class="py-3 px-4 whitespace-nowrap">Tahun</th>
                                <th class="py-3 px-4 whitespace-nowrap">Dibuat Oleh</th>
                                <th class="py-3 px-4 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="slipgajipegawai-table-body">
                            @include('table.slipgajipegawaitable')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Script -->
    <script>
        const searchInput = document.querySelector('#search-form input[name="bulan"]');
        const tableBody = document.getElementById('slipgajipegawai-table-body');

        let debounceTimeout;
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                const query = searchInput.value;
                fetch(`{{ url('/slipgaji/pegawai/' . $user->id) }}?bulan=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        tableBody.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                    });
            }, 500);
        });
    </script>
</body>

</html>
