<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/form.js'])
    @vite(['resources/js/dashboard.js'])

    <script>
        function toggleRekeningField() {
            const metode = document.querySelector('select[name="metode_pembayaran"]').value;
            document.getElementById('rekening_field').style.display = (metode === 'norek') ? 'block' : 'none';
        }
        window.addEventListener('DOMContentLoaded', toggleRekeningField);
    </script>
    <title>{{ isset($slip) ? 'Edit Slip Gaji' : 'Tambah Slip Gaji' }}</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">
    <div class="flex h-full">
        @include('components.sidebar')

        <div class="flex-1 p-6 fade-in">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                    💸 {{ isset($slip) ? 'Edit Slip Gaji' : 'Tambah Slip Gaji' }}
                </h1>
                @include('components.ava')
            </div>
            <div class="mb-5">
                <div>
                    <div class="flex gap-4 w-full ">
                        <div
                            class="w-1/3 animated-gradient rounded-2xl p-6 flex items-center justify-between text-white font-semibold text-sm select-none hover:shadow-xl transition-transform duration-300">
                            <div>
                                <div class="text-2xl font-bold">Kehadiran</div>
                                <div class="text-xl opacity-80">{{ $jumlahHadirdiaBulanIni }} Kehadiran</div>
                            </div>
                        </div>
                        <div
                            class="w-1/3 animated-gradient rounded-2xl p-6 flex items-center justify-between text-white font-semibold text-sm select-none hover:shadow-xl transition-transform duration-300">
                            <div>
                                <div class="text-2xl font-bold">Lembur</div>
                                <div class="text-xl opacity-80">{{ $jumlahLemburdiaBulanIni }} Lembur</div>
                            </div>
                        </div>
                        <div
                            class="w-1/3 animated-gradient rounded-2xl p-6 flex items-center justify-between text-white font-semibold text-sm select-none hover:shadow-xl transition-transform duration-300">
                            <div>
                                <div class="text-2xl font-bold">Cuti</div>
                                <div class="text-xl opacity-80">{{ $jumlahCutidiaBulanIni }} Cuti</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <form method="POST"
                    action="{{ isset($slip) ? route('slipgaji.update', $slip->id) : route('slipgaji.store', ['id' => $user->id]) }}">
                    @csrf
                    @if (isset($slip))
                        @method('PUT')
                    @endif
                    <div class="space-y-6">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Metode Pembayaran</label>
                            <select name="metode_pembayaran" onchange="toggleRekeningField()"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                                <option value="cash"
                                    {{ old('metode_pembayaran', $slip->metode_pembayaran ?? '') == 'cash' ? 'selected' : '' }}>
                                    Cash</option>
                                <option value="norek"
                                    {{ old('metode_pembayaran', $slip->metode_pembayaran ?? '') == 'norek' ? 'selected' : '' }}>
                                    Transfer</option>
                            </select>
                        </div>

                        <div id="rekening_field">
                            <label class="block text-gray-700 font-medium mb-1">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening"
                                value="{{ old('nomor_rekening', $slip->nomor_rekening ?? '') }}"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Rincian Gaji</label>
                            <div id="rincian-container" class="space-y-2">
                                @php
                                    $rincian = old('rincian_gaji')
                                        ? json_decode(old('rincian_gaji'), true)
                                        : (isset($slip)
                                            ? json_decode($slip->rincian_gaji, true)
                                            : []);
                                @endphp
                                @foreach ($rincian as $key => $value)
                                    <div class="flex gap-2 items-center rincian-item">
                                        <input type="text" name="rincian_label[]"
                                            placeholder="Label (e.g. Gaji Pokok)" value="{{ $key }}"
                                            class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
                                        <input type="number" name="rincian_nominal[]" placeholder="Nominal"
                                            value="{{ $value }}"
                                            class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
                                        <button type="button" onclick="hapusRincian(this)"
                                            class="text-red-500 hover:text-red-700 text-xl px-2 font-bold">&times;</button>
                                    </div>
                                @endforeach

                                @if (empty($rincian))
                                    <div class="flex gap-2 items-center rincian-item">
                                        <input type="text" name="rincian_label[]"
                                            placeholder="Label (e.g. Gaji Pokok)"
                                            class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
                                        <input type="number" name="rincian_nominal[]" placeholder="Nominal"
                                            class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
                                        <button type="button" onclick="hapusRincian(this)"
                                            class="text-red-500 hover:text-red-700 text-xl px-2 font-bold">&times;</button>
                                    </div>
                                @endif
                            </div>

                            <button type="button" onclick="tambahRincian()"
                                class="mt-2 text-sm text-pink-600 hover:underline focus:outline-none">
                                + Tambah Rincian
                            </button>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Potongan</label>
                            <div id="potongan-container" class="space-y-2">
                                @php
                                    $potongan = old('potongan_pajak')
                                        ? json_decode(old('potongan_pajak'), true)
                                        : (isset($slip)
                                            ? json_decode($slip->potongan_pajak, true)
                                            : []);
                                @endphp
                                @foreach ($potongan as $key => $value)
                                    <div class="flex gap-2 items-center potongan-item">
                                        <input type="text" name="potongan_label[]" placeholder="Label (e.g. PPh21)"
                                            value="{{ $key }}"
                                            class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
                                        <input type="number" name="potongan_nominal[]" placeholder="Nominal"
                                            value="{{ $value }}"
                                            class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
                                        <button type="button" onclick="hapusPotongan(this)"
                                            class="text-red-500 hover:text-red-700 text-xl px-2 font-bold">&times;</button>
                                    </div>
                                @endforeach

                                @if (empty($potongan))
                                    <div class="flex gap-2 items-center potongan-item">
                                        <input type="text" name="potongan_label[]" placeholder="Label (e.g. PPh21)"
                                            class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
                                        <input type="number" name="potongan_nominal[]" placeholder="Nominal"
                                            class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
                                        <button type="button" onclick="hapusPotongan(this)"
                                            class="text-red-500 hover:text-red-700 text-xl px-2 font-bold">&times;</button>
                                    </div>
                                @endif
                            </div>

                            <button type="button" onclick="tambahPotongan()"
                                class="mt-2 text-sm text-pink-600 hover:underline focus:outline-none">
                                + Tambah Potongan
                            </button>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Bulan</label>
                            <select name="bulan"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                                @php
                                    $daftarBulan = [
                                        1 => 'Januari',
                                        2 => 'Februari',
                                        3 => 'Maret',
                                        4 => 'April',
                                        5 => 'Mei',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'Agustus',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Desember',
                                    ];
                                    $bulanTerpilih = old('bulan', $slip->bulan ?? '');
                                @endphp

                                @foreach ($daftarBulan as $angka => $nama)
                                    <option value="{{ $angka }}"
                                        {{ $bulanTerpilih == $angka ? 'selected' : '' }}>
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Tahun</label>
                            <input type="number" name="tahun"
                                value="{{ old('tahun', $slip->tahun ?? date('Y')) }}"
                                class="w-full px-4 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF] transition duration-300">
                        </div>
                    </div>
                    <div class="flex gap-5 mt-8">
                        <button type="submit"
                            class="w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            {{ isset($slip) ? 'Update' : 'Simpan' }}
                        </button>
                        <a href="{{ route('listslipgajipegawai', $user->id) }}"
                            class="w-1/5 bg-gradient-to-r from-[#FFA09B] to-[#FCC6FF] text-white text-center py-2 rounded-lg hover:from-[#FCC6FF] hover:to-[#FFA09B] transition duration-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function tambahRincian() {
            const container = document.getElementById('rincian-container');
            const div = document.createElement('div');
            div.classList.add('flex', 'gap-2', 'items-center', 'rincian-item');

            div.innerHTML = `
            <input type="text" name="rincian_label[]" placeholder="Label (e.g. Gaji Pokok)"
                class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
            <input type="number" name="rincian_nominal[]" placeholder="Nominal"
                class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
            <button type="button" onclick="hapusRincian(this)"
                class="text-red-500 hover:text-red-700 text-xl px-2 font-bold">&times;</button>
        `;

            container.appendChild(div);
        }

        function hapusRincian(button) {
            const item = button.closest('.rincian-item');
            item.remove();
        }

        function tambahPotongan() {
            const container = document.getElementById('potongan-container');
            const div = document.createElement('div');
            div.classList.add('flex', 'gap-2', 'items-center', 'potongan-item');

            div.innerHTML = `
            <input type="text" name="potongan_label[]" placeholder="Label (e.g. PPh21)"
                class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
            <input type="number" name="potongan_nominal[]" placeholder="Nominal"
                class="w-1/2 px-3 py-2 border border-[#FFA09B] rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FCC6FF]" />
            <button type="button" onclick="hapusPotongan(this)"
                class="text-red-500 hover:text-red-700 text-xl px-2 font-bold">&times;</button>
        `;

            container.appendChild(div);
        }

        function hapusPotongan(button) {
            const item = button.closest('.potongan-item');
            item.remove();
        }
    </script>

</body>

</html>
