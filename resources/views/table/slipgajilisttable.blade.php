                            @forelse ($users as $user)
                                @php
                                    $lastSlip = $user->slipGaji->first(); // slip gaji terbaru atau null
                                    $bulanMap = [
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
                                @endphp
                                <tr class="border-b border-gray-200 transition duration-200 ease-in-out cursor-pointer hover:bg-gray-100"
                                    onclick='window.location="{{ route('listslipgajipegawai', ['id' => $user->id]) }}"'>
                                    <td class="py-3 px-4">{{ $user->name }}</td>
                                    <td class="py-3 px-4">
                                        {{ $lastSlip ? $bulanMap[$lastSlip->bulan] : '-' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ $lastSlip ? $lastSlip->tahun : '-' }}
                                    </td>
                                </tr>
                                 @empty
                                <tr>
                                    <td colspan="9" class="py-6 text-gray-400 italic">😔 Tidak ada data pegawai
                                    </td>
                                </tr>
                            @endforelse
