<div id='qrcode_{{ $link->id }}' 
     class='hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center'
     role='dialog' 
     aria-hidden='true'>
    <div class='bg-gray-800 rounded-lg max-w-md w-full mx-4' role='document'>
        <div class='border-b border-gray-700 p-4 flex justify-between items-center'>
            <h5 class='text-xl font-semibold text-white'>QrCode, id: {{ $link->short_link }}</h5>
            <button type='button' 
                    class='text-gray-400 hover:text-white'
                    onclick="document.getElementById('qrcode_{{ $link->id }}').classList.add('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class='p-4 flex justify-center'>
            {!! QrCode::size(300)->generate( route('get', $link->short_link) ); !!}
        </div>
        <div class='border-t border-gray-700 p-4 flex justify-end space-x-2'>
            <a href="{{ route('link.qrcode', $link->id) }}">
                <button type='button' 
                        class='bg-blue-500 hover:bg-blue-600 text-white rounded px-4 py-2 transition-colors duration-300'>
                    Pobierz
                </button>
            </a>
            <button type='button' 
                    class='bg-cyan-500 hover:bg-cyan-600 text-white rounded px-4 py-2 transition-colors duration-300'
                    onclick="document.getElementById('qrcode_{{ $link->id }}').classList.add('hidden')">
                Zamknij
            </button>
        </div>
    </div>
</div>

<script>
    // Aktualizacja obsługi modalu dla przycisku QR code
    document.querySelector('[data-target="#qrcode_{{ $link->id }}"]').addEventListener('click', function() {
        document.getElementById('qrcode_{{ $link->id }}').classList.remove('hidden');
    });
</script>
