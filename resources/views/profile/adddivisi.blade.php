<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/form.js'])
    <title>Tambah Divisi</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-6 fade-in">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                    🗂️ Tambah Divisi
                </h1>
                @include('components.ava')
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow p-6">
                <form action="{{ route('user.divisistore') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="nama_divisi" class="block text-gray-700 font-medium mb-1">Divisi</label>
                            <input type="text" name="nama_divisi" id="nama_divisi" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-5 mt-8">
                        <button type="submit"
                            class="w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Simpan
                        </button>
                        <a href="{{ route('user.divisiindex') }}"
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
