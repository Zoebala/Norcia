<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}
        @if(session("Annee"))
        <div >
            <h1 style="display: inline-block;">Année de Travail</h1>
            <p style="font-style:italic; display: inline-block; margin-left:35%;"></p>

        </div>
        <h3>{{ session("Annee")[0]}}</h3>
    @else
        <h1 style="color:rgb(136, 60, 60); font-style:italic; text-align:center;">Veuillez choisir une Année de Travail </h1>

    @endif
    </x-filament::section>
</x-filament-widgets::widget>
