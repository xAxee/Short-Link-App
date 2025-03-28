<nav class="bg-gray-800 rounded-lg p-4 mb-6">
  <div class="flex items-center justify-between">
    <a class="text-white text-xl font-bold" href="{{ route('index') }}">AxShortLink</a>
    
    <div class="hidden md:flex items-center space-x-8">
      <ul class="flex space-x-4">
        @if(Route::currentRouteName() != "index" && Route::currentRouteName() != "link.post")
        <li>
          <a class="text-gray-300 hover:text-white" href="{{ route('index') }}">Stwórz linki</a>
        </li>
        @else
          @auth
            <li>
              <a class="text-gray-300 hover:text-white" href="{{ route('link.list') }}">Zobacz swoje linki</a>
            </li>
            <li>
              <a class="text-gray-300 hover:text-white" href="{{ route('api.docs') }}">API</a>
            </li>
          @endauth
        @endif
      </ul>
      
      <div>
        @auth
          <form action="{{ route('api.logout') }}">
            <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-500 hover:text-white border border-blue-500 hover:border-transparent rounded px-4 py-2 transition-colors duration-300">Wyloguj sie</button>
          </form>
        @else
          <form action="{{ route('api.login') }}">
            @csrf
            <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-500 hover:text-white border border-blue-500 hover:border-transparent rounded px-4 py-2 transition-colors duration-300">Zaloguj sie</button>
          </form>
        @endauth
      </div>
    </div>

    <!-- Mobile menu button -->
    <button class="md:hidden text-gray-300 hover:text-white">
      <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </div>
</nav>
