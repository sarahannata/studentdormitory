<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/table.js'])
    <title>Kelola Profile Pegawai</title>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-pink-100 min-h-screen font-sans">
    <div class="flex h-screen">
        @include('components.sidebar')

        <div class="flex-1 p-6 fade-in">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-3xl font-extrabold text-[#6B5DD3]">👥 Kelola Profile Pegawai</h1>
                @include('components.ava')
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-6 hover:shadow-2xl transition duration-300 ease-in-out">
                <div class="flex justify-between items-center mb-2 flex-wrap gap-4">
                    <h2 class="text-2xl font-semibold text-[#6B5DD3] flex items-center gap-2">
                        👤 Table Profile
                    </h2>
                    <div class="flex justify-end gap-3 flex-wrap">
                        <form action="{{ route('user.index') }}" method="GET" id="search-form" class="mb-4">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari Pegawai..."
                                class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:outline-none text-sm" />
                        </form>

                        <a href="{{ route('user.divisiindex') }}">
                            <button
                                class="bg-blue-100 hover:bg-blue-200 text-[#3b82f6] font-semibold text-sm px-4 py-2 rounded-lg transition">
                                Tambah Divisi
                            </button>
                        </a>
                        <a href="{{ route('addprofile') }}">
                            @include('components.plusbutton')
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table
                        class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden text-center text-gray-700 text-sm">
                        <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-4 whitespace-nowrap">Foto Profile</th>
                                <th class="py-3 px-4 whitespace-nowrap">Username</th>
                                {{-- <th class="py-3 px-4 whitespace-nowrap">Password</th> --}}
                                <th class="py-3 px-4 whitespace-nowrap">Nama</th>
                                <th class="py-3 px-4 whitespace-nowrap">Email</th>
                                <th class="py-3 px-4 whitespace-nowrap">Nomor Telepon</th>
                                <th class="py-3 px-4 whitespace-nowrap">Divisi</th>
                                <th class="py-3 px-4 whitespace-nowrap">Role</th>
                                <th class="py-3 px-4 whitespace-nowrap">Posisi</th>
                                <th class="py-3 px-4 whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body">
                            @include('table.usertable')
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        const searchInput = document.querySelector('#search-form input[name="search"]');
        const tableBody = document.getElementById('user-table-body');

        let debounceTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                const query = searchInput.value;

                fetch(`{{ route('user.index') }}?search=${encodeURIComponent(query)}`, {
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
