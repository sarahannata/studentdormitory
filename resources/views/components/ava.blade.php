<div class="flex items-center">
    <!-- Nama hanya muncul di layar md ke atas -->
    <h3 class="hidden md:block text-gray-500 text-l font-bold uppercase">
        {{ Auth::user()->name }}
    </h3>

    <!-- Avatar selalu tampil -->
    <img alt="Profile Picture"
        class="h-8 w-8 rounded-full ml-0 md:ml-5 mr-0 md:mr-5 object-cover"
        src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : asset('images/user.png') }}" />

    <script>
        document.getElementById('foto').addEventListener('change', function (e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('preview').src = URL.createObjectURL(file);
            }
        });
    </script>
</div>
