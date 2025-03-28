@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-gray-900 shadow-xl rounded-lg p-8 text-gray-100">
        <h1 class="text-3xl font-bold mb-8 text-blue-400">API Documentation</h1>
        
        @auth
        <div class="mb-8 bg-gray-800 p-6 rounded-lg border border-gray-700">
            <h2 class="text-xl font-semibold mb-4 text-blue-300">Your API Key</h2>
            <div class="flex items-center gap-2">
                <div class="bg-gray-950 p-4 rounded flex-1">
                    <code id="apiKey" class="text-sm text-green-400">{{ Auth::user()->api_key ?? 'Not generated yet' }}</code>
                </div>
                <button onclick="copyApiKey()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/>
                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"/>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-400 mt-2">Keep this key secret! Use it in the request body for all API requests.</p>

            @if(isset($debug))
            <div class="mt-4 p-4 bg-gray-950 rounded">
                <h3 class="text-sm font-semibold text-blue-400 mb-2">Debug Info</h3>
                <pre class="text-xs text-gray-400">{{ json_encode($debug, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
        </div>
        @endauth

        <div class="space-y-8">
            <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                <h2 class="text-xl font-semibold mb-6 text-blue-300">Endpoints</h2>
                
                <div class="space-y-8">
                    <!-- GET Links -->
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="bg-green-600 text-white px-2 py-1 rounded text-sm">GET</span>
                            <h3 class="font-mono text-lg text-gray-300">/api/v1/links</h3>
                        </div>
                        <p class="text-gray-400 mb-4">Get all your shortened links</p>
                        
                        <div class="space-y-4">
                            <!-- Request -->
                            <div>
                                <h4 class="text-sm font-semibold text-blue-400 mb-2">Request</h4>
                                <div class="bg-gray-950 p-4 rounded text-left">
                                    <pre class="text-sm"><code class="language-text text-gray-300">GET /api/v1/links?key=your-api-key</code></pre>
                                </div>
                            </div>

                            <!-- Response -->
                            <div>
                                <h4 class="text-sm font-semibold text-blue-400 mb-2">Response</h4>
                                <div class="bg-gray-950 p-4 rounded text-left">
                                    <pre class="text-sm"><code class="language-json text-gray-300">[
    {
        "id": 1,
        "orginal_link": "https://example.com",
        "short_link": "abc123",
        "clicks": 0,
        "created_at": "2024-01-23T12:00:00Z"
    }
]</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- POST Link -->
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm">POST</span>
                            <h3 class="font-mono text-lg text-gray-300">/api/v1/links</h3>
                        </div>
                        <p class="text-gray-400 mb-4">Create a new shortened link</p>
                        
                        <div class="space-y-4">
                            <!-- Request -->
                            <div>
                                <h4 class="text-sm font-semibold text-blue-400 mb-2">Request</h4>
                                <div class="bg-gray-950 p-4 rounded text-left">
                                    <pre class="text-sm"><code class="language-json text-gray-300">{
    "key": "your-api-key",
    "orginal_link": "https://example.com"
}</code></pre>
                                </div>
                            </div>

                            <!-- Response -->
                            <div>
                                <h4 class="text-sm font-semibold text-blue-400 mb-2">Response</h4>
                                <div class="bg-gray-950 p-4 rounded text-left">
                                    <pre class="text-sm"><code class="language-json text-gray-300">{
    "id": 1,
    "orginal_link": "https://example.com",
    "short_link": "abc123",
    "clicks": 0,
    "created_at": "2024-01-23T12:00:00Z"
}</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Responses -->
            <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                <h2 class="text-xl font-semibold mb-4 text-blue-300">Error Responses</h2>
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-semibold text-blue-400 mb-2">Invalid API Key (401)</h4>
                        <div class="bg-gray-950 p-4 rounded text-left">
                            <pre class="text-sm"><code class="language-json text-gray-300">{
    "error": "Invalid API key"
}</code></pre>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-blue-400 mb-2">Invalid URL (400)</h4>
                        <div class="bg-gray-950 p-4 rounded text-left">
                            <pre class="text-sm"><code class="language-json text-gray-300">{
    "error": "Invalid URL"
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="copyNotification" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg transform translate-y-full opacity-0 transition-all duration-300">
    Skopiowano klucz API!
</div>

<script>
function copyApiKey() {
    const apiKey = document.getElementById('apiKey').textContent;
    navigator.clipboard.writeText(apiKey).then(() => {
        const notification = document.getElementById('copyNotification');
        notification.classList.remove('translate-y-full', 'opacity-0');
        setTimeout(() => {
            notification.classList.add('translate-y-full', 'opacity-0');
        }, 2000);
    });
}
</script>
@endsection
