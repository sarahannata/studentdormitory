<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/form.js'])
    <title>Ajukan Lembur</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">

    <!-- Header Mobile -->
    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-pink-600">⏰ Ajukan Lembur</h1>
        <div>@include('components.ava')</div>
    </div>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-6 fade-in">
            <!-- Header Desktop -->
            <div class="hidden sm:flex flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <h1 class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                    ⏰ Ajukan Lembur
                </h1>
                @include('components.ava')
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('lembur.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="tanggal" class="block text-gray-700 font-medium mb-1">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300"
                                required>
                            @error('tanggal')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="waktu_mulai" class="block text-gray-700 font-medium mb-1">Waktu Mulai</label>
                            <input type="time" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300"
                                required>
                            @error('waktu_mulai')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="waktu_selesai" class="block text-gray-700 font-medium mb-1">Waktu Selesai</label>
                            <input type="time" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300"
                                required>
                            @error('waktu_selesai')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="keterangan_lembur" class="block text-gray-700 font-medium mb-1">Keterangan</label>
                            <input type="text" id="keterangan_lembur" name="keterangan_lembur" value="{{ old('keterangan_lembur') }}"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        <button type="submit"
                            class="w-full sm:w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Ajukan
                        </button>
                        <a href="{{ route('lembur.user') }}"
                            class="w-full sm:w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white text-center py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Error Modal -->
            @if (session('error_tanggal_kurang'))
                <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6 text-center relative" role="alert">
                        <p class="text-red-600 font-semibold mb-4">
                            {{ session('error_tanggal_kurang') }}
                        </p>
                        <button type="button" onclick="document.getElementById('errorModal').style.display='none'"
                            class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Tutup
                        </button>
                        <button type="button" onclick="document.getElementById('errorModal').style.display='none'"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" aria-label="Close modal">
                            &times;
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
