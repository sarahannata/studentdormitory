<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/dashboard.js'])
    <title>Dashboard</title>
</head>

<body class="bg-gradient-to-br from-[#f5f3ff] to-[#f0e9ff] min-h-screen text-gray-800">

    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-[#6B5DD3] flex items-center gap-2">📊
            Dashboard</h1>

        <!-- 👤 Avatar di kanan -->
        <div>
            @include('components.ava')
        </div>
    </div>




    <div class="flex h-screen">
        @include('components.sidebar')
        <div class="flex-1 p-4 sm:p-6 ml-0  container mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 sm:mb-8 gap-4">
                <h1
                    class="hidden sm:flex text-xl sm:text-2xl md:text-3xl font-extrabold text-[#6B5DD3] items-center gap-2">
                    📊 Dashboard
                </h1>
                <div class="hidden sm:flex">
                    @include('components.ava')
                </div>
            </div>

            <main class="flex flex-col gap-6">
                <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-black font-bold text-lg sm:text-xl select-none">
                            Hai, {{ Auth::user()->name }} ✨
                        </h1>
                        <p class="text-black text-opacity-70 text-sm select-none">Welcome back!</p>
                    </div>
                </header>

                <section class="grid grid-cols-1 gap-6">
                    <div class="flex flex-col gap-6">
                        @can('admin')
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <div class="col-span-2 bg-white bg-opacity-90 rounded-2xl p-6 flex flex-col gap-4 transition-transform duration-200 ease-in-out transform hover:scale-105 hover:shadow-xl animate-fade-in"
                                    style="backdrop-filter: blur(40px);">
                                    <h2 class="text-[#6B5DD3] font-bold text-xl select-none">👥 Jumlah Setiap Role</h2>
                                    <ul class="flex flex-col gap-4">
                                        <li class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#A3B7F9] to-[#F7C9E7] flex items-center justify-center">
                                                <i class="fas fa-pen-nib text-white text-sm"></i>
                                            </div>
                                            <span class="text-[#6B5DD3] font-semibold text-l select-none">Admin :
                                                {{ $jumlahAdmin }}</span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#A3B7F9] to-[#F7C9E7] flex items-center justify-center">
                                                <i class="fas fa-paint-brush text-white text-sm"></i>
                                            </div>
                                            <span class="text-[#6B5DD3] font-semibold text-l select-none">Pimpinan :
                                                {{ $jumlahPimpinan }}</span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#A3B7F9] to-[#F7C9E7] flex items-center justify-center">
                                                <i class="fas fa-chart-bar text-white text-sm"></i>
                                            </div>
                                            <span class="text-[#6B5DD3] font-semibold text-l select-none">Pegawai :
                                                {{ $jumlahPegawai }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <div
                                        class="animated-gradient rounded-2xl p-6 flex items-center justify-between text-white font-semibold text-sm select-none hover:shadow-xl transition-transform duration-300">
                                        <div>
                                            <div class="text-xl md:text-2xl font-bold">Total Akun</div>
                                            <div class="text-base md:text-xl opacity-80">{{ $totalAkun }} Akun</div>
                                        </div>
                                    </div>
                                    <div
                                        class="animated-gradient rounded-2xl p-6 flex items-center justify-between text-white font-semibold text-sm select-none hover:shadow-xl transition-transform duration-300">
                                        <div>
                                            <div class="text-xl md:text-2xl font-bold">Event Bulan Ini</div>
                                            <div class="text-base md:text-xl opacity-80">{{ $totalEventBulanIni }} Event
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan

                        @canany(['pimpinan', 'pegawai'])
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                <div
                                    class="animated-gradient rounded-2xl p-6 flex items-center justify-between text-white font-semibold text-sm select-none hover:shadow-xl transition-transform duration-300">
                                    <div>
                                        <div class="text-xl font-bold">Ajuan Cuti Bulan Ini</div>
                                        <div class="text-base opacity-80">
                                            {{ Auth::user()->can('pimpinan') ? $jumlahcuti : $jumlahCutiSaya }} Ajuan
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="animated-gradient rounded-2xl p-6 flex items-center justify-between text-white font-semibold text-sm select-none hover:shadow-xl transition-transform duration-300">
                                    <div>
                                        <div class="text-xl font-bold">Ajuan Lembur Bulan Ini</div>
                                        <div class="text-base opacity-80">
                                            {{ Auth::user()->can('pimpinan') ? $jumlahlembur : $jumlahLemburSaya }} Ajuan
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="animated-gradient rounded-2xl p-6 flex items-center justify-between text-white font-semibold text-sm select-none hover:shadow-xl transition-transform duration-300">
                                    <div>
                                        <div class="text-xl font-bold">Event Bulan Ini</div>
                                        <div class="text-base opacity-80">{{ $totalEventBulanIni }} Event</div>
                                    </div>
                                </div>
                            </div>
                        @endcanany

                        <div class="bg-white bg-opacity-90 rounded-2xl p-6 flex flex-col gap-4 transition-transform duration-300 ease-in-out transform hover:scale-[1.02] hover:shadow-xl animate-fade-in"
                            style="backdrop-filter: blur(40px);">
                            <div class="flex justify-between items-center">
                                <h3 class="text-[#6B5DD3] font-bold text-xl select-none">📅 Upcoming Event</h3>
                                @can('admin')
                                    <a href="{{ route('event.create') }}">
                                        @include('components.plusbutton')
                                    </a>
                                @endcan
                            </div>
                            <div class="overflow-x-auto rounded-xl shadow-md">
                                <table
                                    class="min-w-full bg-white bg-opacity-80 backdrop-blur-md rounded-xl text-sm text-left text-[#6B5DD3]">
                                    <thead class="bg-[#6B5DD3]/10 text-[#6B5DD3] font-semibold">
                                        <tr>
                                            <th class="px-6 py-3">Nama Event</th>
                                            <th class="px-6 py-3">Tanggal</th>
                                            <th class="px-6 py-3">Waktu</th>
                                            <th class="px-6 py-3">Venue</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#6B5DD3]/10">
                                        @forelse ($upcomingEvents->sortByDesc('tanggal') as $event)
                                            <tr onclick="window.location='{{ route('event.show', $event->id) }}'"
                                                class="hover:bg-[#6B5DD3]/5 transition cursor-pointer duration-200">
                                                <td class="px-6 py-4 font-medium">{{ $event->nama }}</td>
                                                <td class="px-6 py-4 font-medium">{{ $event->tanggal }}</td>
                                                <td class="px-6 py-4 font-medium">
                                                    {{ \Carbon\Carbon::parse($event->tanggal)->format('h:i A') }}</td>
                                                <td class="px-6 py-4 font-medium">{{ $event->venue }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 text-gray-500 text-center italic">
                                                    😔 Belum ada event mendatang.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>

</body>

</html>
