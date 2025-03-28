<div id='delete_{{ $link->id }}' 
     class='hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center'
     role='dialog' 
     aria-hidden='true'>
    <div class='bg-gray-800 rounded-lg max-w-md w-full mx-4' role='document'>
        <div class='border-b border-gray-700 p-4 flex justify-between items-center'>
            <h5 class='text-xl font-semibold text-white'>Potwierdzenie usunięcia</h5>
            <button type='button' 
                    class='text-gray-400 hover:text-white'
                    onclick="document.getElementById('delete_{{ $link->id }}').classList.add('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class='p-4'>
            <p class="text-white">Czy na pewno chcesz usunąć ten link?</p>
            <p class="text-gray-400 mt-2">{{ route('get', $link->short_link) }}</p>
        </div>
        <div class='border-t border-gray-700 p-4 flex justify-end space-x-2'>
            <a href="{{ route('link.delete', $link->id) }}">
                <button type='button' 
                        class='bg-red-500 hover:bg-red-600 text-white rounded px-4 py-2 transition-colors duration-300'>
                    Usuń
                </button>
            </a>
            <button type='button' 
                    class='bg-gray-500 hover:bg-gray-600 text-white rounded px-4 py-2 transition-colors duration-300'
                    onclick="document.getElementById('delete_{{ $link->id }}').classList.add('hidden')">
                Anuluj
            </button>
        </div>
    </div>
</div>

<script>
    document.querySelector('[data-target="#delete_{{ $link->id }}"]').addEventListener('click', function() {
        document.getElementById('delete_{{ $link->id }}').classList.remove('hidden');
    });
</script>
