<!-- Tombol Toggle Sidebar -->
<button onclick="toggleSidebar()" class="md:hidden bg-white/80 backdrop-blur-md p-2 rounded-xl shadow-lg">
    <svg class="w-6 h-6 text-[#6B5DD3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<!-- Backdrop Sidebar -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-40 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

@once
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
@endonce
