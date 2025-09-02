<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/form.js'])
    <title>Tambah Akun</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-6 fade-in">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                    👤 Tambah Profile
                </h1>
                @include('components.ava')
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="username" class="block text-gray-700 font-medium mb-1">Username</label>
                            <input type="text" id="username" name="username" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>

                        <div>
                            <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>

                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-1">Nama</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>

                        <div>
                            <label for="divisi_id" class="block text-gray-700 font-medium mb-1">Divisi</label>
                            <select id="divisi_id" name="divisi_id" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                                <option value="" disabled selected>Pilih Divisi</option>
                                @foreach ($divisi as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_divisi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="posisi" class="block text-gray-700 font-medium mb-1">Posisi</label>
                            <input type="text" id="posisi" name="posisi" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>

                        <div>
                            <label for="role" class="block text-gray-700 font-medium mb-1">Role</label>
                            <select id="role" name="role" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="pegawai">Pegawai</option>
                                <option value="pimpinan">Pimpinan</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-5 mt-8">
                        <button type="submit"
                            class="w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Simpan Akun
                        </button>
                        <a href="{{ route('user.index') }}"
                            class="w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white text-center py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
