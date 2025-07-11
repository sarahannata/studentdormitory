<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Slip Gaji</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">
    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-pink-600">💰 Slip Gaji</h1>
        <div>
            @include('components.ava')
        </div>
    </div>
    <div class="flex h-full">
        @include('components.sidebar')

        <div class="flex-1 p-6 fade-in">
            <div class="hidden sm:flex flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-pink-600">
                    💰 Slip Gaji
                </h1>
                @include('components.ava')
            </div>
            <div>
                @if (session('error'))
                    <div id="error-alert"
                        class="bg-red-100 text-red-700 px-4 py-2 rounded-md mb-4 transition-opacity duration-500">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="flex justify-center gap-3">
                <div class="bg-white rounded-2xl shadow-lg p-8 w-fit max-w-4xl">
                    <div class="w-full flex flex-col items-center mb-2">
                        <div class="text-center w-full max-w-xl px-4">
                            <h2 class="text-2xl font-bold text-pink-600">STUDENT DORMITORY UMY</h2>
                            <p class="text-gray-600 text-sm">Geblagan, Tamantirto, Kasihan, Bantul, Yogyakarta</p>
                        </div>
                        <div class="border-b-2 border-pink-300 w-full max-w-xl my-4"></div>
                        <div class="text-center w-full max-w-xl px-4">
                            <h3 class="text-lg font-semibold text-gray-800">SLIP GAJI PEGAWAI</h3>
                            <p class="text-sm text-gray-600">Nomor Slip : {{ $nomorSlip }}</p>
                            <p class="text-sm text-gray-600">Periode :
                                {{ ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$slip->bulan - 1] }}
                                {{ $slip->tahun }}</p>
                        </div>
                    </div>


                    <div class="flex mt-5">
                        <div class="text-sm text-gray-700 text-left grid grid-cols-[150px_10px_auto] gap-x-2">
                            <p class="font-medium">Nama Penerima</p>
                            <p>:</p>
                            <p>{{ $slip->user->name }}</p>

                            <p class="font-medium">Jabatan</p>
                            <p>:</p>
                            <p>{{ $slip->user->posisi ?? '-' }}</p>

                            <p class="font-medium">Metode Pembayaran</p>
                            <p>:</p>
                            <p>
                                {{ $slip->metode_pembayaran === 'norek' ? 'Transfer' : ucfirst($slip->metode_pembayaran) }}
                            </p>

                            @if ($slip->metode_pembayaran === 'norek')
                                <p class="font-medium">Nomor Rekening</p>
                                <p>:</p>
                                <p>{{ $slip->nomor_rekening ?? '-' }}</p>
                            @endif

                            <p class="font-medium">Pemberi</p>
                            <p>:</p>
                            <p>{{ $slip->creator->name ?? 'Unknown' }}</p>
                        </div>
                    </div>


                    <!-- Bagian Penghasilan dan Potongan di tengah -->
                    <div class="flex justify-center mt-5">
                        <div class="grid grid-cols-2 gap-5 text-sm text-gray-700 w-fit">
                            <!-- Kolom Penghasilan -->
                            <div class="bg-pink-50 rounded-xl p-6 shadow">
                                <p class="font-semibold border-b border-pink-300 text-pink-600 mb-4 text-center">
                                    PENGHASILAN
                                </p>
                                @php
                                    $rincian = json_decode($slip->rincian_gaji, true);
                                    $totalGaji = array_sum($rincian);
                                @endphp

                                <div class="space-y-2">
                                    @foreach ($rincian as $label => $nominal)
                                        <div class="flex justify-between gap-3">
                                            <span>{{ $label }}</span><span>{{ number_format($nominal, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                    <div class="border-t border-gray-300 my-2"></div>
                                    <div class="flex justify-between font-semibold text-pink-700">
                                        <span>TOTAL</span><span>{{ number_format($totalGaji, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Potongan -->
                            <div class="bg-pink-50 rounded-xl p-6 shadow">
                                <p class="font-semibold border-b border-pink-300 text-pink-600 mb-4 text-center">
                                    POTONGAN
                                </p>
                                @php
                                    $potongan = json_decode($slip->potongan_pajak, true);
                                    $totalGaji = array_sum($potongan);
                                @endphp

                                <div class="space-y-2">
                                    @foreach ($potongan as $label => $nominal)
                                        <div class="flex justify-between gap-3">
                                            <span>{{ $label }}</span><span>{{ number_format($nominal, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                    <div class="border-t border-gray-300 my-2"></div>
                                    <div class="flex justify-between font-semibold text-pink-700">
                                        <span>TOTAL</span><span>{{ number_format($totalGaji, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-left font-semibold text-l text-pink-700">
                        TOTAL GAJI : Rp {{ number_format($totalBersih, 0, ',', '.') }} ,-
                        <span class="block mt-1">Terbilang : {{ angkaKeTerbilang($totalBersih) }} Rupiah</span>
                    </div>



                    <div class="text-right text-sm text-gray-700 mt-7 ">
                        <p class="mb-1">Yogyakarta, {{ $tanggalSekarang }}</p>
                        <div class="w-40 ml-auto border-t border-pink-300 mb-1"></div>
                        <p class="font-semibold text-gray-800">{{ $slip->creator->name ?? 'Unknown' }}</p>
                        <p class="text-xs italic text-pink-500">Pemberi</p>
                    </div>
                </div>
                @can('admin')
                    <a href="{{ route('slipgaji.edit', ['id' => $slip->id]) }}"> @include('components.editbutton')
                    </a>
                @endcan

            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('error-alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500); // Remove after fade out
            }
        }, 3000); // hilang setelah 3 detik
    </script>

</body>


</html>
