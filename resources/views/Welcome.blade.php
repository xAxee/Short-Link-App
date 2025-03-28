@extends('layouts.app')


@section('content')

<div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
    @if(!isset($ShortLink))
    <div class="bg-gray-800 text-white rounded-lg shadow-lg w-96">
        <div class="border-b border-gray-700 p-4">
            <h3 class="text-xl font-semibold">Skróć link</h3>
        </div>
        <div class="p-4">
            <form action="{{ route('link.post') }}" >
                @csrf
                <div class="flex space-x-2">
                    <input type="text" 
                           name="orginal_link" 
                           class="flex-1 bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Wprowadz link">
                    <button type="submit" 
                            class="bg-transparent hover:bg-green-500 text-green-500 hover:text-white border border-green-500 hover:border-transparent rounded px-4 py-2 transition-colors duration-300">
                        Generuj
                    </button>
                    @csrf
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="bg-gray-800 text-white rounded-lg shadow-lg w-96">
        <div class="border-b border-gray-700 p-4">
            <h3 class="text-xl font-semibold">Twój skrócony link</h3>
        </div>
        <div class="p-4 space-y-4">
            <div class="flex space-x-2">
                <input type="text" 
                       autofocus 
                       onfocus="this.select()" 
                       class="flex-1 bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       id="short_link" 
                       value="{{ config('app.url').$ShortLink->short_link }}">
                <button onclick="copyLink()" 
                        class="bg-transparent hover:bg-blue-500 text-blue-500 hover:text-white border border-blue-500 hover:border-transparent rounded px-4 py-2 transition-colors duration-300">
                    Kopiuj
                </button>
            </div>
            <form action="{{ route('index') }}" class="text-center">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white rounded px-6 py-2 transition-colors duration-300">
                    Generuj kolejny link
                </button>
            </form>
        </div>
    </div>
    @endif
</div>

@endsection
@section('script')
<script>
    function copyLink() {
      var copyText = document.getElementById("short_link");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      navigator.clipboard.writeText(copyText.value);
    }
    </script>
@endsection
