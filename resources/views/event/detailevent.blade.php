<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Detail Event</title>
</head>

<body class="bg-gradient-to-br from-pink-100 to-yellow-50 min-h-screen text-gray-800">

    <!-- 🔘 Toggle dan Avatar Header (Mobile Only) -->
    <div class="flex justify-between items-center md:hidden px-4 py-2">
        <x-toggle-sidebar />
        <h1 class="text-lg font-bold text-pink-600">📅 Detail Event</h1>
        <div>@include('components.ava')</div>
    </div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-4 sm:p-6 ml-0 container mx-auto">
            <!-- Header Desktop -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 sm:mb-8 gap-4">
                <h1 class="hidden sm:flex text-2xl font-bold text-pink-600 items-center gap-2">
                    📅 Detail Event
                </h1>
                <div class="hidden sm:flex">
                    @include('components.ava')
                </div>
            </div>

            <!-- Content Card -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">
                <div class="w-full md:w-3/4">
                    <!-- Header Event Name + Button -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-pink-500">
                            {{ $event->nama }}
                        </h2>
                        @can('admin')
                        <div class="flex gap-4">
                            <a href="{{ route('event.edit', $event->id) }}">
                                @include('components.editbutton')
                            </a>
                            <button onclick="openModal('modal-event-{{ $event->id }}')">
                                @include('components.deletebutton')
                            </button>
                        </div>
                        @endcan
                    </div>

                    <!-- Detail Info -->
                    <div class="bg-gray-50 p-4 sm:p-6 rounded-lg mb-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                            <div>
                                <div class="font-medium">Tanggal</div>
                                <div class="text-gray-500">{{ $event->tanggal }}</div>
                            </div>
                            <div>
                                <div class="font-medium">Kategori</div>
                                <div class="text-gray-500">{{ $event->kategori }}</div>
                            </div>
                            <div>
                                <div class="font-medium">Venue</div>
                                <div class="text-gray-500">{{ $event->venue }}</div>
                            </div>
                            <div>
                                <div class="font-medium">Jam Mulai</div>
                                <div class="text-gray-500">{{ $event->mulai }}</div>
                            </div>
                            <div>
                                <div class="font-medium">Jumlah Tamu</div>
                                <div class="text-gray-500">{{ $event->jumlah_tamu }}</div>
                            </div>
                            <div>
                                <div class="font-medium">Jam Selesai</div>
                                <div class="text-gray-500">{{ $event->selesai }}</div>
                            </div>
                            <div class="sm:col-span-2">
                                <div class="font-medium">Catatan</div>
                                <div class="text-gray-500">{{ $event->catatan }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }
    </script>

    <!-- Modal Delete -->
    @can('admin')
    <x-modal id="modal-event-{{ $event->id }}"
        action="{{ route('event.destroy', $event->id) }}"
        method="DELETE"
        title="Hapus Event"
        message="Apakah kamu yakin ingin menghapus event '{{ $event->nama }}'?">
    </x-modal>
    @endcan

</body>

</html>
