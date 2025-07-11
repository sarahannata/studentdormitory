                            @forelse ($users as $user)
                                <tr class="border-b border-gray-200 transition duration-200 ease-in-out">
                                    <td class="py-3 px-4">
                                        @if ($user->foto)
                                            <img src="{{ asset($user->foto) }}" alt="Foto Profil"
                                                class="w-10 h-10 object-cover rounded-full mx-auto" />
                                        @else
                                            <span class="text-gray-400">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $user->username }}</td>
                                    {{-- <td class="py-3 px-4">******</td> Password disembunyikan --}}
                                    <td class="py-3 px-4">{{ $user->name ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $user->email ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $user->telepon ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $user->divisi->nama_divisi ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        {{ $user->role === 'pimpinan'
                                            ? 'Pimpinan'
                                            : ($user->role === 'admin'
                                                ? 'Admin'
                                                : ($user->role === 'pegawai'
                                                    ? 'Pegawai'
                                                    : '-')) }}
                                    </td>
                                    <td class="py-3 px-4">{{ $user->posisi }}</td>
                                    <td class="py-3 px-4">
                                        <button type="button" onclick="openModal('hapus-user-{{ $user->id }}')"
                                            class="text-red-500 hover:text-red-700 transition">
                                            @include('components.deletebutton')
                                        </button>

                                        <x-modal id="hapus-user-{{ $user->id }}" :action="route('user.destroy', $user->id)"
                                            title="Hapus Pengguna"
                                            message="Apakah Anda yakin ingin menghapus pengguna '{{ $user->name }}'?"
                                            method="DELETE" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-6 text-gray-400 italic">😔 Anda belum menambahkan akun
                                    </td>
                                </tr>
                            @endforelse
