<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/form.js'])
    <title>Kehadiran Pegawai</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">

    <!-- Header Mobile -->
    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-pink-600">🕒 Kehadiran Pegawai</h1>
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
                    🕒 Kehadiran Pegawai
                </h1>
                @include('components.ava')
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow p-6">
                @if (session('error'))
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('kehadiran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="jadwal_id" value="{{ $jadwal_id }}">

                    <!-- Tanggal -->
                    <h2 class="text-xl font-bold text-pink-700">
                        📅 {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                    </h2>

                    <!-- Status -->
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Status Kehadiran</label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" id="hadir" name="status" value="Hadir" required
                                    class="accent-pink-400 scale-125">
                                <span class="text-gray-700">Hadir</span>
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" id="tidak_hadir" name="status" value="Tidak Hadir"
                                    class="accent-pink-400 scale-125">
                                <span class="text-gray-700">Tidak Hadir</span>
                            </label>
                        </div>
                    </div>

                    <!-- Foto Upload -->
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Upload Foto 📷</label>
                        <label for="foto"
                            class="inline-block px-5 py-2 bg-pink-200 text-pink-800 rounded-full shadow hover:bg-pink-300 transition cursor-pointer">
                            Pilih Foto
                        </label>
                        <input type="file" id="foto" name="foto" class="hidden" accept="image/*" required>
                        <p id="nama-file" class="text-sm mt-2 text-pink-500 italic"></p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        <button type="submit"
                            class="w-full sm:w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Submit
                        </button>
                        <a href="{{ route('jadwal.userindex') }}"
                            class="w-full sm:w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white text-center py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const inputFoto = document.getElementById("foto");
        const namaFile = document.getElementById("nama-file");

        inputFoto.addEventListener("change", function () {
            namaFile.textContent = this.files[0]?.name || "Belum memilih file";
        });
    </script>
</body>

</html>
