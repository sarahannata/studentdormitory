<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/table.js'])
    <title>Divisi Pegawai</title>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-pink-100 min-h-screen font-sans">
    <div class="flex h-screen">
        @include('components.sidebar')

        <div class="flex-1 p-6 fade-in">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-extrabold text-[#6B5DD3]">🏢 Divisi Pegawai</h1>
                @include('components.ava')
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-6 hover:shadow-2xl transition duration-300 ease-in-out">
                <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                    <h2 class="text-2xl font-semibold text-[#6B5DD3]">📋 Table Divisi Pegawai</h2>
                    <a href="{{ route('adddivisi') }}">
                        @include('components.plusbutton')
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden text-center">
                        <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-6 w-1/2">Divisi</th>
                                <th class="py-3 px-6 w-1/2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse ($divisis as $divisi)
                                <tr class="border-b transition">
                                    <td class="py-3 px-6">{{ $divisi->nama_divisi }}</td>
                                    <td class="py-3 px-6">
                                        <button type="button" onclick="openModal('hapus-divisi-{{ $divisi->id }}')"
                                            class="text-red-500 hover:text-red-700">
                                            @include('components.deletebutton')
                                        </button>

                                        <x-modal id="hapus-divisi-{{ $divisi->id }}" :action="route('user.divisidestroy', $divisi->id)"
                                            title="Hapus Divisi"
                                            message="Apakah Anda yakin ingin menghapus divisi '{{ $divisi->nama_divisi }}'?"
                                            method="DELETE" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-6 text-gray-400 italic">😔 Anda belum menambahkan divisi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $divisis->links() }}
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
    </script>
</body>

</html>
