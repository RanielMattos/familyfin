<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold">FamilyFin</h1>
                    <p class="mt-1 text-gray-600">Para continuar, escolha uma família ou crie uma nova.</p>

                    @if ($activeFamily)
                        <div class="mt-4">
                            <a class="text-sm text-indigo-700 hover:text-indigo-900 underline"
                               href="{{ route('family.dashboard', ['family' => $activeFamily->id]) }}">
                                Continuar na família ativa: <strong>{{ $activeFamily->name }}</strong>
                            </a>
                        </div>
                    @endif

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold">Minhas famílias</h3>

                            @if ($families->isEmpty())
                                <p class="text-gray-600 mt-2">Nenhuma família cadastrada ainda.</p>
                            @else
                                <ul class="mt-3 space-y-3">
                                    @foreach ($families as $family)
                                        <li class="flex items-center justify-between gap-4">
                                            <div>
                                                <div class="font-medium">{{ $family->name }}</div>
                                                <div class="text-xs text-gray-500">
                                                    role: {{ $family->pivot->role }}
                                                    @if ($family->pivot->is_active)
                                                        · <span class="font-semibold">ativa</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('family.dashboard', ['family' => $family->id]) }}"
                                                   class="px-3 py-2 text-sm bg-gray-900 text-white rounded hover:bg-black">
                                                    Entrar
                                                </a>

                                                @if (! $family->pivot->is_active)
                                                    <form method="POST" action="{{ route('families.activate', ['family' => $family->id]) }}">
                                                        @csrf
                                                        <x-secondary-button type="submit">
                                                            Tornar ativa
                                                        </x-secondary-button>
                                                    </form>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold">Criar nova família</h3>

                            <form method="POST" action="{{ route('families.store') }}" class="mt-3 space-y-3">
                                @csrf

                                <div>
                                    <x-input-label for="name" value="Nome da família" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                                  value="{{ old('name') }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <div>
                                    <x-primary-button type="submit">
                                        Criar família
                                    </x-primary-button>
                                </div>
                            </form>

                            <p class="mt-4 text-xs text-gray-500">
                                Status: tenancy via URL ✅
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
