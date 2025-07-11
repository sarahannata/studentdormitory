<!-- Sidebar -->
<div id="sidebar"
    class="w-60 min-h-screen fixed top-0 left-0 bg-white/80 backdrop-blur-lg p-6 rounded-tr-2xl rounded-br-2xl shadow-lg border-r border-white/30
           z-50 overflow-y-auto transition-transform duration-300 transform -translate-x-full md:translate-x-0 md:static">

    <div class="flex items-center mb-8">
        <img src="{{ asset('images/logo.png') }}" class="mr-3" height="40" width="150" />
    </div>

    <nav class="text-[#6B5DD3] font-medium">
        <div class="mt-8">
            <h3 class="text-[#b197fc] text-xs font-bold uppercase mb-4 tracking-wide">Menu</h3>
        </div>
        <ul>
            <li class="mb-3">
                <a class="flex items-center hover:text-pink-500 transition-all duration-200" href="{{ route('dashboard') }}">
                    <i class="fas fa-dashboard mr-3"></i> Dashboard
                </a>
            </li>
            @can('admin')
                <li class="mb-3">
                    <a class="flex items-center hover:text-pink-500 transition-all duration-200" href="{{ route('user.index') }}">
                        <i class="fas fa-user-cog mr-3"></i> Kelola Profile
                    </a>
                </li>
            @endcan
            @cannot('admin')
                <li class="mb-3">
                    <a class="flex items-center hover:text-pink-500 transition-all duration-200" href="{{ route('profile') }}">
                        <i class="fas fa-user mr-3"></i> Profile
                    </a>
                </li>
            @endcannot
            @cannot('pimpinan')
                <div class="mt-8">
                    <h3 class="text-[#b197fc] text-xs font-bold uppercase mb-4 tracking-wide">Slip Gaji</h3>
                </div>
            @endcannot
            @cannot('admin')
                @cannot('pimpinan')
                    <li class="mb-3">
                        <a class="flex items-center hover:text-pink-500 transition-all duration-200"
                            href="{{ route('listslipgajipegawai', ['id' => Auth::id()]) }}">
                            <i class="fas fa-file-invoice-dollar mr-3"></i> Slip Gaji
                        </a>
                    </li>
                @endcannot
            @endcannot

            @can('admin')
                <li class="mb-3">
                    <a class="flex items-center hover:text-pink-500 transition-all duration-200" href="{{ route('slipgaji.index') }}">
                        <i class="fas fa-file-invoice mr-3"></i> List Slip Gaji Pegawai
                    </a>
                </li>
            @endcan
        </ul>

        <div class="mt-8">
            <h3 class="text-[#b197fc] text-xs font-bold uppercase mb-4 tracking-wide">Kehadiran</h3>
        </div>
        <ul>
            @cannot('admin')
                @cannot('pimpinan')
                    <li class="mb-3">
                        <a class="flex items-center hover:text-pink-500 transition-all duration-200"
                            href="{{ route('jadwal.userindex') }}">
                            <i class="fas fa-calendar-check mr-3"></i> Kehadiran
                        </a>
                    </li>
                @endcannot
            @endcannot
            @can('admin')
                <li class="mb-3">
                    <a class="flex items-center hover:text-pink-500 transition-all duration-200" href="{{ route('jadwal.index') }}">
                        <i class="fas fa-calendar-alt mr-3"></i> Jadwal Kehadiran
                    </a>
                </li>
                <li class="mb-3">
                    <a class="flex items-center hover:text-pink-500 transition-all duration-200" href="{{ route('kehadiranpegawai.index') }}">
                        <i class="fas fa-users mr-3"></i> List Kehadiran Pegawai
                    </a>
                </li>
            @endcan
            @cannot('admin')
                @cannot('pimpinan')
                    <li class="mb-3">
                        <a class="flex items-center hover:text-pink-500 transition-all duration-200"
                            href="{{ route('kehadiran.pegawai', ['id' => Auth::id()]) }}">
                            <i class="fas fa-user-clock mr-3"></i> Kehadiran Pegawai
                        </a>
                    </li>
                @endcannot
            @endcannot
            @can('pegawai')
                <li class="mb-3">
                    <a class="flex items-center hover:text-pink-500 transition-all duration-200" href="{{ route('cutiperizinan.user') }}">
                        <i class="fas fa-plane-departure mr-3"></i> Cuti/Perizinan
                    </a>
                </li>
            @endcan
            @can('pimpinan')
                <li class="mb-3">
                    <a class="flex items-center hover:text-pink-500 transition-all duration-200" href="{{ route('cutiperizinan.admin') }}">
                        <i class="fas fa-list-alt mr-3"></i> List Cuti/Perizinan
                    </a>
                </li>
            @endcan
            @can('pegawai')
                <li class="mb-3">
                    <a class="flex items-center hover:text-pink-500 transition-all duration-200" href="{{ route('lembur.user') }}">
                        <i class="fas fa-business-time mr-3"></i> Lembur
                    </a>
                </li>
            @endcan
            @can('pimpinan')
                <li class="mb-3">
                    <a class="flex items-center hover:text-pink-500 transition-all duration-200" href="{{ route('lembur.admin') }}">
                        <i class="fas fa-briefcase mr-3"></i> List Lembur
                    </a>
                </li>
            @endcan
        </ul>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center mt-7 text-red-500 hover:text-red-600 transition-all duration-200">
                <img src="{{ asset('images/logout.png') }}" alt="Logout Icon" class="w-5 h-5 mr-2">
                <span class="ml-2 font-semibold">Logout</span>
            </button>
        </form>
    </nav>
</div>
