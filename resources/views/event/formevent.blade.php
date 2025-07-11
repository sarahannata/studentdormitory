<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/form.js'])
    <title>{{ isset($event) ? 'Edit Acara' : 'Tambah Acara' }}</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-6 fade-in">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                    🎉 {{ isset($event) ? 'Edit Acara' : 'Tambah Acara' }}
                </h1>
                @include('components.ava')
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <form method="POST"
                    action="{{ isset($event) ? route('event.update', $event->id) : route('event.store') }}">
                    @csrf
                    @if (isset($event))
                        @method('PUT')
                    @endif

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kolom Kiri -->
                        <div class="space-y-6">
                            <div>
                                <label for="acara" class="block text-gray-700 font-medium mb-1">Nama Acara</label>
                                <input type="text" id="acara" name="nama"
                                    value="{{ old('nama', $event->nama ?? '') }}"
                                    class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                            </div>

                            <div>
                                <label for="tanggal" class="block text-gray-700 font-medium mb-1">Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal"
                                    value="{{ old('tanggal', $event->tanggal ?? '') }}"
                                    class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                            </div>

                            <div>
                                <label for="venue" class="block text-gray-700 font-medium mb-1">Venue</label>
                                <input type="text" id="venue" name="venue"
                                    value="{{ old('venue', $event->venue ?? '') }}"
                                    class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                            </div>

                            <div>
                                <label for="kategori" class="block text-gray-700 font-medium mb-1">Kategori</label>
                                <select name="kategori"
                                    class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                                    <option disabled
                                        {{ old('kategori', $event->kategori ?? '') == null ? 'selected' : '' }}>Pilih
                                        Kategori</option>
                                    <option value="Tamu Internal"
                                        {{ old('kategori', $event->kategori ?? '') == 'Tamu Internal' ? 'selected' : '' }}>
                                        Tamu Internal</option>
                                    <option value="Tamu Eksternal"
                                        {{ old('kategori', $event->kategori ?? '') == 'Tamu Eksternal' ? 'selected' : '' }}>
                                        Tamu Eksternal</option>
                                </select>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-6">
                            <div>
                                <label for="jumlah_tamu" class="block text-gray-700 font-medium mb-1">Jumlah
                                    Tamu</label>
                                <input type="number" name="jumlah_tamu"
                                    value="{{ old('jumlah_tamu', $event->jumlah_tamu ?? '') }}"
                                    class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                            </div>

                            <div>
                                <label for="mulai" class="block text-gray-700 font-medium mb-1">Jam Mulai</label>
                                <input type="time" name="mulai" value="{{ old('mulai', $event->mulai ?? '') }}"
                                    class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                            </div>

                            <div>
                                <label for="selesai" class="block text-gray-700 font-medium mb-1">Jam Selesai</label>
                                <input type="time" name="selesai"
                                    value="{{ old('selesai', $event->selesai ?? '') }}"
                                    class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                            </div>

                            <div>
                                <label for="catatan" class="block text-gray-700 font-medium mb-1">Catatan</label>
                                <textarea name="catatan" rows="4"
                                    class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] resize-none transition duration-300">{{ old('catatan', $event->catatan ?? '') }}</textarea>
                            </div>
                            <div class="flex gap-5 mt-8">
                                <button type="submit"
                                    class="w-1/2 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                                    {{ isset($event) ? 'Update' : 'Save' }}
                                </button>
                                <a href="{{ route('dashboard') }}"
                                    class="btn btn-secondary w-1/2 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white text-center py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">Cancel</a>
                            </div>
                        </div>
                    </div>


                    <!-- Buttons -->

                </form>
            </div>
        </div>
    </div>
</body>

</html>
