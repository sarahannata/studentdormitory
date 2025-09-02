<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/form.js'])
    <title>Tambah Kehadiran</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-6 fade-in">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                    📅 Tambah Jadwal Kehadiran
                </h1>
                @include('components.ava')
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow p-6">
                <form id="jadwalForm" method="POST" action="{{ route('jadwal.store') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="tipe_jadwal" class="block text-gray-700 font-medium mb-1">Tipe Jadwal</label>
                            <select name="tipe_jadwal" id="tipe_jadwal" required
                                class="block w-full bg-white border border-[#FFA09B] rounded-xl px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                                <option disabled selected>Pilih Tipe Jadwal</option>
                                <option value="tanggal">Tanggal Tertentu</option>
                                <option value="setiap_hari">Setiap Hari</option>
                            </select>
                        </div>

                        <div id="tanggal-container" class="mt-4">
                            <label for="tanggal" class="block text-gray-700 font-medium mb-1">Pilih Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal"
                                class="block w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>

                        <div id="range-container" class="mt-4 hidden">
                            <label class="block text-gray-700 font-medium mb-1">Pilih Rentang Tanggal</label>
                            <div class="flex gap-4">
                                <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                    class="w-1/2 px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
                                <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                                    class="w-1/2 px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
                            </div>
                        </div>

                        <div>
                            <label for="tipe_kehadiran" class="block text-gray-700 font-medium mb-1">Kehadiran</label>
                            <select name="tipe_kehadiran" id="tipe_kehadiran" required
                                class="block w-full bg-white border border-[#FFA09B] rounded-xl px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                                <option disabled selected>Pilih Kehadiran</option>
                                <option value="Shift Pagi">Shift Pagi</option>
                                <option value="Shift Malam">Shift Malam</option>
                            </select>
                        </div>

                        <div>
                            <label for="jam_buka" class="block text-gray-700 font-medium mb-1">Jam Buka</label>
                            <input type="time" id="jam_buka" name="jam_buka" required
                                class="block w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>

                        <div>
                            <label for="jam_tutup" class="block text-gray-700 font-medium mb-1">Jam Selesai</label>
                            <input type="time" id="jam_tutup" name="jam_tutup" required
                                class="block w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-5 mt-8">
                        <button type="submit" id="submitButton"
                            class="w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Simpan
                        </button>
                        <a href="{{ route('jadwal.index') }}"
                            class="w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white text-center py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Batal
                        </a>
                    </div>
                </form>
                @if ($errors->any())
                    <div class="mt-4 text-red-600 bg-red-100 rounded-lg p-4">
                        <ul class="list-disc ml-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Modal Notifikasi Jam Lewat -->
    <div id="expiredModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg max-w-sm w-full">
            <h2 class="text-lg font-bold mb-4">Jam Melewati Waktu Saat Ini</h2>
            <p class="mb-6">Jam tutup yang kamu masukkan sudah melewati waktu sekarang</p>
            <div class="flex justify-center items-center gap-3">
                <button onclick="closeModal('expiredModal')"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        const tipeJadwal = document.getElementById('tipe_jadwal');
        const tanggalInput = document.getElementById('tanggal');
        const tanggalContainer = document.getElementById('tanggal-container');
        const rangeContainer = document.getElementById('range-container');
        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalSelesai = document.getElementById('tanggal_selesai');

        tipeJadwal.addEventListener('change', function() {
            if (this.value === 'tanggal') {
                tanggalContainer.style.display = 'block';
                rangeContainer.style.display = 'none';
                tanggalInput.required = true;
                tanggalMulai.required = false;
                tanggalSelesai.required = false;
            } else if (this.value === 'setiap_hari') {
                tanggalContainer.style.display = 'none';
                rangeContainer.style.display = 'block';
                tanggalInput.required = false;
                tanggalMulai.required = true;
                tanggalSelesai.required = true;
            } else {
                tanggalContainer.style.display = 'none';
                rangeContainer.style.display = 'none';
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            const selected = tipeJadwal.value;
            if (selected === 'tanggal') {
                tanggalContainer.style.display = 'block';
                rangeContainer.style.display = 'none';
            } else if (selected === 'setiap_hari') {
                tanggalContainer.style.display = 'none';
                rangeContainer.style.display = 'block';
            } else {
                tanggalContainer.style.display = 'none';
                rangeContainer.style.display = 'none';
            }
        });
    </script>
</body>

</html>
