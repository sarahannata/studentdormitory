                            @if ($slips->count() > 0)
                                @foreach ($slips as $slip)
                                    <tr class="border-b border-gray-200 transition duration-200 ease-in-out">
                                        <td class="py-3 px-4">
                                            {{ ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$slip->bulan - 1] }}
                                        </td>
                                        <td class="py-3 px-4">{{ $slip->tahun }}</td>
                                        <td class="py-3 px-4">{{ $slip->creator->name ?? 'Unknown' }}</td>
                                        <td class="py-3 px-4">
                                            <div class="flex justify-center gap-4">
                                                <a href="{{ route('slipgaji.download', $slip->id) }}"
                                                    title="Download Slip Gaji">
                                                    @include('components.downloadbutton')
                                                </a>
                                                <a href="{{ route('slipgaji.show', $slip->id) }}"
                                                    title="Lihat Detail Slip Gaji">
                                                    @include('components.seebutton')
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-500 italic">
                                        Belum ada slip gaji untuk pegawai ini.
                                    </td>
                                </tr>
                            @endif
