<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/form.js'])
    <title>Ajukan Cuti/Perizinan</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">

    <!-- Header Mobile -->
    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-pink-600">📝 Ajukan Cuti</h1>
        <div>
            @include('components.ava')
        </div>
    </div>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-6 fade-in">
            <!-- Header Desktop -->
            <div class="hidden sm:flex flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <h1 class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                    📝 Ajukan Cuti/Perizinan
                </h1>
                @include('components.ava')
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('cutiperizinan.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="tanggal_mulai" class="block text-gray-700 font-medium mb-1">Tanggal Mulai Cuti</label>
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                value="{{ old('tanggal_mulai') }}"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300"
                                required>
                        </div>

                        <div>
                            <label for="tanggal_selesai" class="block text-gray-700 font-medium mb-1">Tanggal Akhir Cuti</label>
                            <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                                value="{{ old('tanggal_selesai') }}"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300"
                                required>
                        </div>

                        <div>
                            <label for="keterangan" class="block text-gray-700 font-medium mb-1">Keterangan</label>
                            <select name="keterangan" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                                 <option value="" disabled {{ old('keterangan') == null ? 'selected' : '' }}>Pilih Keterangan</option>
                                <option value="Sakit" {{ old('keterangan') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Izin" {{ old('keterangan') == 'Izin' ? 'selected' : '' }}>Izin</option>
                            </select>
                        </div>

                        <div>
                            <label for="alasan" class="block text-gray-700 font-medium mb-1">Alasan</label>
                            <input type="text" id="alasan" name="alasan"
                                value="{{ old('alasan') }}"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300"
                                required>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        <button type="submit"
                            class="w-full sm:w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Ajukan
                        </button>
                        <a href="{{ route('cutiperizinan.user') }}"
                            class="w-full sm:w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white text-center py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
