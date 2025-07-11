@props(['id', 'action', 'title' => 'Konfirmasi', 'message' => 'Yakin?', 'method' => 'POST'])

<div id="{{ $id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg max-w-sm w-full">
        <h2 class="text-lg font-bold mb-4">{{ $title }}</h2>
        <p class="mb-6">{{ $message }}</p>
        <div class="flex justify-center items-center gap-3">
            <button onclick="closeModal('{{ $id }}')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
            <form method="POST" action="{{ $action }}">
                @csrf
                @method($method)
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Ya</button>
            </form>
        </div>
    </div>
</div>
