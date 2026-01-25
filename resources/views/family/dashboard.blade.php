<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $family->name }}
            </h2>

            <a href="{{ route('dashboard') }}" class="text-sm underline text-indigo-700 hover:text-indigo-900">
                Trocar família
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-3">
                    <p class="text-gray-700">Você está dentro do contexto da família. Tudo daqui pra frente vive em <code>/f/{{ $family->id }}</code>.</p>

                    <div class="flex flex-wrap gap-2">
                        <a class="px-3 py-2 text-sm bg-gray-900 text-white rounded hover:bg-black"
                           href="{{ route('family.planpag', ['family' => $family->id]) }}">
                            Planpag
                        </a>

                        <a class="px-3 py-2 text-sm bg-gray-900 text-white rounded hover:bg-black"
                           href="{{ route('family.taxonomy', ['family' => $family->id]) }}">
                            Taxonomia
                        </a>

                        <a class="px-3 py-2 text-sm bg-gray-100 text-gray-900 rounded hover:bg-gray-200"
                           href="{{ url('/f/'.$family->id.'/ping') }}" target="_blank" rel="noreferrer">
                            Ping (healthcheck)
                        </a>
                    </div>

                    <p class="text-xs text-gray-500">Próximo passo: começar as telas reais (Planpag/Orçamentos) já dentro da família.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
