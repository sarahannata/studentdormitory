<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/dashboard.js'])
    <title>Kehadiran</title>
</head>

<body class="bg-gradient-to-br from-[#f5f3ff] to-[#f0e9ff] min-h-screen text-gray-800">
    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-[#6B5DD3]">Kehadiran</h1>
        <div>
            @include('components.ava')
        </div>
    </div>
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="hidden sm:flex flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold">Kehadiran</h1>
                @include('components.ava')
            </div>

            <main class="flex flex-col gap-6">
                <section>
                    <div class="bg-white bg-opacity-90 rounded-2xl p-6 transition-transform duration-300 ease-in-out transform hover:scale-[1.02] hover:shadow-xl"
                        style="backdrop-filter: blur(40px);">
                        <h2 class="text-xl font-semibold mb-6 text-[#6B5DD3]">Isi Kehadiran</h2>
                        @php
                            $groupedJadwal = $jadwals->groupBy(function ($item) {
                                return \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y');
                            });
                        @endphp

                        @forelse ($groupedJadwal as $tanggal => $items)
                            <div class="mb-8">
                                <h3 class="text-lg font-bold mb-4 text-[#6B5DD3]">{{ $tanggal }}</h3>

                                @foreach ($items as $jadwal)
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $jamBuka = \Carbon\Carbon::parse($jadwal->tanggal . ' ' . $jadwal->jam_buka);
                                        $jamTutup = \Carbon\Carbon::parse($jadwal->tanggal . ' ' . $jadwal->jam_tutup);

                                        $bisaIsi = $now->between($jamBuka, $jamTutup); // waktu sekarang antara buka & tutup
                                    @endphp


                                    <a @if ($bisaIsi) href="{{ route('kehadiran.form', ['jadwal_id' => $jadwal->id]) }}" @endif
                                        class="block {{ $bisaIsi ? '' : 'pointer-events-none cursor-not-allowed opacity-50' }}">

                                        <div
                                            class="bg-blue-100 p-4 mb-4 rounded-lg flex justify-between items-center hover:bg-blue-200 transition">
                                            <div>
                                                <h4 class="font-semibold">{{ $jadwal->tipe_kehadiran }}</h4>
                                                <p class="text-sm">
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_buka)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_tutup)->format('H:i') }}
                                                </p>
                                            </div>
                                            <div class="ml-4 w-8 h-8 flex items-center justify-center overflow-hidden">
                                                <img src="https://cdn-icons-png.flaticon.com/512/271/271228.png"
                                                    alt="Icon" class="w-full h-full object-cover" />
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        @empty
                            <p class="text-gray-500 italic">Tidak ada jadwal kehadiran. 🤲🏻</p>
                        @endforelse

                    </div>
                </section>
            </main>
        </div>
    </div>
</body>

</html>
