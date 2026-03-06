<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page->title }}</title>
        
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-stone-50 text-stone-800 font-sans antialiased flex flex-col min-h-screen scroll-smooth">
        
        <header class="bg-[#e6ccb2] py-12 text-center shadow-sm px-4">
            <h1 class="text-4xl md:text-5xl font-serif text-[#7f5539] mb-2 font-bold">{{ $page->title }}</h1>
            <p class="text-[#9c6644] text-lg">{{ $page->description }}</p>
        </header>

        <nav class="sticky top-0 z-20 bg-stone-50/95 backdrop-blur border-b border-stone-200" aria-label="Navigazione principale">
            <div class="container mx-auto px-4 max-w-6xl">
                <div class="flex gap-2 sm:gap-3 overflow-x-auto py-3 text-sm sm:text-base whitespace-nowrap">
                    <a href="/#home-section" class="px-4 py-2 rounded-full font-semibold text-[#7f5539] hover:bg-[#e6ccb2] transition">Home</a>
                    <a href="/#modelli" class="px-4 py-2 rounded-full font-semibold text-[#7f5539] hover:bg-[#e6ccb2] transition">Modelli</a>
                    <a href="/#chi-sono" class="px-4 py-2 rounded-full font-semibold text-[#7f5539] hover:bg-[#e6ccb2] transition">Chi sono</a>
                    <a href="/#contatti" class="px-4 py-2 rounded-full font-semibold text-[#7f5539] hover:bg-[#e6ccb2] transition">Contatti</a>
                </div>
            </div>
        </nav>

        <main class="container mx-auto px-4 py-12 max-w-6xl flex-grow">
            @yield('body')
        </main>

        <footer class="bg-[#7f5539] text-[#e6ccb2] text-center py-10 px-4 mt-auto">
            <div class="mb-6">
                <a href="https://www.instagram.com/m_crochet_lab/" 
                target="_blank" 
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 hover:text-white transition-colors duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-instagram transform group-hover:scale-110 transition-transform" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.269.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.003 1.44c2.147 0 2.4.008 3.248.047.78.036 1.203.166 1.485.276.374.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.847.047 1.097.047 3.247s-.008 2.399-.047 3.248c-.036.78-.166 1.203-.276 1.485-.145.374-.319.64-.599.92-.28.28-.546.453-.92.598-.281.11-.705.24-1.485.276-.847.039-1.097.047-3.247.047s-2.399-.008-3.248-.047c-.78-.036-1.203-.166-1.485-.276a2.47 2.47 0 0 1-.92-.598 2.47 2.47 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.847-.046-1.097-.046-3.247s.008-2.399.046-3.248c.035-.78.166-1.203.276-1.485.145-.374.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                    </svg>
                    <span class="font-medium">Seguimi su Instagram</span>
                </a>
            </div>

            <p class="text-sm opacity-80">&copy; {{ date('Y') }} {{ $page->title }}. Fatte a mano con il ❤️.</p>
        </footer>
    </body>
</html>