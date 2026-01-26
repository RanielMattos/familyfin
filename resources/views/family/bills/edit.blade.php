<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Conta
        </h2>
        <p class="text-sm text-gray-600">
            Atualize os dados da conta desta família.
        </p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if (session('success'))
                        <div class="mb-4 rounded border border-green-200 bg-green-50 p-3 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-red-800">
                            <p class="font-semibold mb-2">Corrija os erros abaixo:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('family.bills.update', ['family' => $family, 'bill' => $bill]) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $bill->name) }}"
                                class="mt-1 block w-full rounded border-gray-300"
                                maxlength="120"
                                required
                                autofocus
                            />
                        </div>

                        <div>
                            <label for="direction" class="block text-sm font-medium text-gray-700">Tipo</label>
                            <select
                                id="direction"
                                name="direction"
                                class="mt-1 block w-full rounded border-gray-300"
                                required
                            >
                                @php
                                    $selected = old('direction', $bill->direction);
                                @endphp
                                <option value="PAYABLE" @selected($selected === 'PAYABLE')>A pagar</option>
                                <option value="RECEIVABLE" @selected($selected === 'RECEIVABLE')>A receber</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="inline-flex items-center rounded bg-gray-900 px-4 py-2 text-white">
                                Salvar
                            </button>

                            <a href="{{ route('family.bills.index', $family) }}" class="inline-flex items-center rounded border border-gray-300 px-4 py-2 text-gray-700">
                                Cancelar
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
