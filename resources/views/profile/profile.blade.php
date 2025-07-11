<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/form.js'])
    <title>Profile</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">
    <!-- 🔘 Toggle dan Avatar Header (Mobile Only) -->
    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-pink-600">👤 Profile</h1>
        <div>
            @include('components.ava')
        </div>
    </div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-4 sm:p-6 ml-0  container mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 sm:mb-8 gap-4">
                <h1 class="hidden sm:flex text-2xl font-bold text-pink-600 items-center gap-2">
                    👤 Profile
                </h1>
                <div class="hidden sm:flex">
                    @include('components.ava')
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-3/4">
                        <div class="flex justify-between">
                        <h2 class="text-xl font-semibold mb-6 text-pink-500">
                            My Profile
                        </h2>
                        <div class="">
                            <a href="{{ route('editprofile', Auth::user()->id) }}">
                                @include('components.editbutton')
                            </a>
                        </div>
                        </div>
                        <div class="bg-gray-50 p-4 sm:p-6 rounded-lg mb-6">
                            <div class="bg-gray-50 p-4 sm:p-6 rounded-lg mb-6">
                                <div class="relative flex flex-row gap-6 items-start">
                                    <!-- Gambar Profil -->
                                    <img id="preview" alt="Profile Picture"
                                        class="h-20 w-20 rounded-full object-cover ring-2 ring-pink-300"
                                        src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : asset('images/user.png') }}" />

                                    <!-- Detail Info Profil -->
                                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                                        <div>
                                            <div class="font-medium">Nama</div>
                                            <div class="text-gray-500">{{ Auth::user()->name ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="font-medium">Nomor Telepon</div>
                                            <div class="text-gray-500">{{ Auth::user()->telepon ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="font-medium">Email</div>
                                            <div class="text-gray-500">{{ Auth::user()->email ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="font-medium">Divisi</div>
                                            <div class="text-gray-500">{{ Auth::user()->divisi->nama_divisi ?? '-' }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-medium">Posisi</div>
                                            <div class="text-gray-500">{{ Auth::user()->posisi ?? '-' }}</div>
                                        </div>
                                    </div>

                                    <!-- Tombol edit -->

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
