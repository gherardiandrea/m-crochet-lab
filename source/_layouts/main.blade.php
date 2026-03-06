<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page->title }}</title>
        
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-stone-50 text-stone-800 font-sans antialiased flex flex-col min-h-screen">
        
        <header class="bg-[#e6ccb2] py-12 text-center shadow-sm px-4">
            <h1 class="text-4xl md:text-5xl font-serif text-[#7f5539] mb-2 font-bold">{{ $page->title }}</h1>
            <p class="text-[#9c6644] text-lg">{{ $page->description }}</p>
        </header>

        <main class="container mx-auto px-4 py-12 max-w-6xl flex-grow">
            @yield('body')
        </main>

        <footer class="bg-[#7f5539] text-[#e6ccb2] text-center py-8 px-4 mt-auto">
            <p>&copy; {{ date('Y') }} {{ $page->title }}. Fatto a mano in Italia con ❤️.</p>
        </footer>
    </body>
</html>