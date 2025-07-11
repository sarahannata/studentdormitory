<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 30px;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            margin: 0;
        }

        .alamat {
            text-align: center;
            font-size: 10px;
            margin-bottom: 10px;
        }

        .line {
            border-top: 1px solid #000;
            margin: 15px 0;
        }

        .section-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info {
            margin-bottom: 10px;
        }

        .info table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            padding: 4px 0;
        }

        .column {
            border: 1px solid #000;
            padding: 10px;
        }

        .column-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
            border-bottom: 1px solid #000;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .total {
            font-weight: bold;
            border-top: 1px solid #000;
            margin-top: 8px;
            padding-top: 5px;
        }

        .footer {
            margin-top: 30px;
        }

        .footer .left {
            float: left;
        }

        .footer .right {
            float: right;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        .terbilang {
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>STUDENT DORMITORY UMY</h2>
        <p class="alamat">Geblagan, Tamantirto, Kasihan, Bantul, Yogyakarta</p>
        <div class="line"></div>

        <h3 class="mb-5">SLIP GAJI PEGAWAI</h3>

        <div class="info">
            <table class="w-full border-collapse">
                <tr>
                    <td class="w-1/3 align-top">Nomor Slip</td>
                    <td class="w-4 px-1 text-center align-top">:</td>
                    <td class="align-top">{{ $nomorSlip }}</td>
                </tr>
                <tr>
                    <td class="pr-2 align-top">Periode</td>
                    <td class="w-4 px-1 text-center align-top">:</td>
                    <td class="align-top">
                        {{ ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$slip->bulan - 1] }}
                        {{ $slip->tahun }}
                    </td>
                </tr>
                <tr>
                    <td class="pr-2 align-top">Nama Penerima</td>
                    <td class="w-4 px-1 text-center align-top">:</td>
                    <td class="align-top">{{ $slip->user->name }}</td>
                </tr>
                <tr>
                    <td class="pr-2 align-top">Jabatan</td>
                    <td class="w-4 px-1 text-center align-top">:</td>
                    <td class="align-top">{{ $slip->user->posisi ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="pr-2 align-top">Metode Pembayaran</td>
                    <td class="w-4 px-1 text-center align-top">:</td>
                    <td class="align-top">
                        {{ $slip->metode_pembayaran === 'norek' ? 'Transfer' : ucfirst($slip->metode_pembayaran) }}</td>
                </tr>
                @if ($slip->metode_pembayaran === 'norek')
                    <tr>
                        <td class="pr-2 align-top">Nomor Rekening</td>
                        <td class="w-4 px-1 text-center align-top">:</td>
                        <td class="align-top">{{ $slip->nomor_rekening ?? '-' }}</td>
                    </tr>
                @endif
                <tr>
                    <td class="pr-2 align-top">Pemberi</td>
                    <td class="w-4 px-1 text-center align-top">:</td>
                    <td class="align-top">{{ $slip->creator->name ?? 'Unknown' }}</td>
                </tr>
            </table>

        </div>

        <table style="width:100%; margin-top: 10px;" cellspacing="0" cellpadding="0">
            <tr>
                <!-- Kolom Penghasilan -->
                <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                    <div class="column">
                        <div class="column-title">PENGHASILAN</div>
                        @php
                            $rincian = json_decode($slip->rincian_gaji, true);
                            $totalGaji = array_sum($rincian);
                        @endphp
                        @foreach ($rincian as $label => $nominal)
                            <div class="detail-row">
                                <span>{{ $label }}</span>
                                <span>{{ number_format($nominal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="detail-row total">
                            <span>TOTAL</span>
                            <span>{{ number_format($totalGaji, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </td>

                <!-- Kolom Potongan -->
                <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                    <div class="column">
                        <div class="column-title">POTONGAN</div>
                        @php
                            $potongan = json_decode($slip->potongan_pajak, true);
                            $totalPotongan = array_sum($potongan);
                        @endphp
                        @foreach ($potongan as $label => $nominal)
                            <div class="detail-row">
                                <span>{{ $label }}</span>
                                <span>{{ number_format($nominal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="detail-row total">
                            <span>TOTAL</span>
                            <span>{{ number_format($totalPotongan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        @php
            $totalBersih = $totalGaji - $totalPotongan;
        @endphp

        <div class="terbilang">
            <strong>Total Gaji:</strong> Rp {{ number_format($totalBersih, 0, ',', '.') }}<br>
            <strong>Terbilang:</strong> {{ angkaKeTerbilang($totalBersih) }} Rupiah
        </div>

        <div class="footer">
            <div class="right">
                <p>Yogyakarta, {{ \Carbon\Carbon::parse($tanggalSekarang)->translatedFormat('d F Y') }}</p>
                <br><br>
                <p><strong>{{ $slip->creator->name ?? 'Unknown' }}</strong></p>
                <p style="font-size: 10px;">Pemberi</p>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</body>

</html>
