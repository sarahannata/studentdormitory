<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/form.js'])
    <title>Edit Profile</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">

    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-pink-600">✏️ Edit Profile</h1>
        <div>
            @include('components.ava')
        </div>
    </div>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-6 fade-in">
            <!-- Header -->
            <div class="hidden sm:flex flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <h1 class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                    ✏️ Edit Profile
                </h1>
                @include('components.ava')
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('updateprofile', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Foto dan Upload -->
                    <div class="flex flex-row items-center gap-4 mb-6">
                        <img id="preview" alt="Profile Picture"
                            class="h-20 w-20 rounded-full object-cover border-2 border-pink-300"
                            src="{{ $user->foto ? asset($user->foto) : asset('images/user.png') }}" />

                        <label for="foto"
                            class="flex items-center gap-2 text-[#FFA09B] cursor-pointer hover:text-[#FCC6FF] transition duration-200">
                            <img src="{{ asset('images/pencil.png') }}" alt="Edit" class="w-5 h-5" />
                            <span>Atur Foto Profil</span>
                        </label>

                        <input type="file" id="foto" name="foto" class="hidden">
                    </div>



                    <!-- Form Inputs -->
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
                            <input type="text" id="name" name="name" placeholder="Nama"
                                value="{{ $user->name }}" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>

                        <div>
                            <label for="telepon" class="block text-gray-700 font-medium mb-1">Nomor Telepon</label>
                            <input type="text" id="telepon" name="telepon" placeholder="Nomor Telepon"
                                value="{{ $user->telepon }}" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                            <input type="text" id="email" name="email" placeholder="Email"
                                value="{{ $user->email }}" required
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300" />
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        <button type="submit"
                            class="w-full sm:w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Simpan
                        </button>
                        <a href="{{ route('profile') }}"
                            class="w-full sm:w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white text-center py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Foto Script -->
    <script>
        document.getElementById('foto')?.addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('preview').src = URL.createObjectURL(file);
            }
        });
    </script>

</body>

</html>
