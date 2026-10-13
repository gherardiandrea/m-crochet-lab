@extends('_layouts.main')

@section('body')
@php
    // L'indice si costruisce dai titoli h2 del documento: ogni titolo riceve un id da usare come ancora
    $indice = [];
    $documento = preg_replace_callback('#<h2([^>]*)>(.*?)</h2>#s', function ($titolo) use (&$indice) {
        $testo = trim(strip_tags($titolo[2]));
        $id = \Illuminate\Support\Str::slug($testo);
        $indice[] = [$id, $testo];

        return '<h2 id="' . $id . '"' . $titolo[1] . '>' . $titolo[2] . '</h2>';
    }, trim($__env->yieldContent('documento')));
@endphp

<div class="lg:grid lg:grid-cols-12 lg:gap-14 items-start">
    <aside class="lg:col-span-4 lg:sticky lg:top-28">
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-[#7f5539]">{{ $page->title }}</h1>
        @if ($page->aggiornamento)
            <p class="mt-3 text-sm text-stone-500">Ultimo aggiornamento: {{ $page->aggiornamento }}</p>
        @endif

        @if (count($indice) > 1)
            <nav aria-label="Indice" class="hidden lg:block mt-8">
                <p class="text-sm font-semibold text-stone-800 mb-3">In questa pagina</p>
                <ol class="space-y-2 text-sm text-stone-600">
                    @foreach ($indice as [$id, $testo])
                        <li><a href="#{{ $id }}" class="hover:text-[#7f5539] hover:underline">{{ $testo }}</a></li>
                    @endforeach
                </ol>
            </nav>

            {{-- Su mobile l'indice si apre con un tocco (details: funziona anche senza JavaScript) --}}
            <details class="lg:hidden mt-6 rounded-2xl bg-[#f4e7db] px-4 py-3">
                <summary class="cursor-pointer font-semibold text-[#7f5539]">Indice: {{ count($indice) }} sezioni</summary>
                <ol class="mt-3 space-y-2 text-sm text-stone-700">
                    @foreach ($indice as [$id, $testo])
                        <li><a href="#{{ $id }}" class="hover:text-[#7f5539] hover:underline">{{ $testo }}</a></li>
                    @endforeach
                </ol>
            </details>
        @endif
    </aside>

    <article class="lg:col-span-8 mt-8 lg:mt-0 max-w-[68ch] text-stone-700 leading-relaxed">
        {!! $documento !!}
    </article>
</div>
@endsection
