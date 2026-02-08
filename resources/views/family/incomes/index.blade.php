<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Receitas
            </h2>

            <div class="text-sm text-gray-600">
                Total: <span class="font-semibold">
                    R$ {{ number_format((float) $incomes->sum('amount'), 2, ',', '.') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Adicionar receita</h3>

                    <form method="POST" action="{{ route('incomes.store', ['family' => $family->id]) }}" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block text-sm text-gray-700">Descrição</label>
                            <input name="description" value="{{ old('description') }}"
                                   class="mt-1 w-full rounded border-gray-300" required>
                            @error('description')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-1">
                                <label class="block text-sm text-gray-700">Valor</label>
                                <input name="amount" type="number" step="0.01" min="0"
                                       value="{{ old('amount') }}"
                                       class="mt-1 w-full rounded border-gray-300" required>
                                @error('amount')
                                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm text-gray-700">Recebido em</label>
                                <input name="received_at" type="date"
                                       value="{{ old('received_at', now()->toDateString()) }}"
                                       class="mt-1 w-full rounded border-gray-300" required>
                                @error('received_at')
                                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                            Adicionar
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Lista</h3>

                    @if($incomes->isEmpty())
                        <div class="text-sm text-gray-600">Nenhuma receita cadastrada.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-600 border-b">
                                        <th class="py-2 pr-4">Descrição</th>
                                        <th class="py-2 pr-4 whitespace-nowrap">Data</th>
                                        <th class="py-2 pr-4 whitespace-nowrap">Valor</th>
                                        <th class="py-2 whitespace-nowrap">Ações</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y">
                                    @foreach($incomes as $income)
                                        @php($dateBr = \Illuminate\Support\Carbon::parse($income->received_at)->format('d/m/Y'))

                                        <tr class="align-top">
                                            <td class="py-3 pr-4">
                                                <div class="font-medium text-gray-900">
                                                    {{ $income->description }}
                                                </div>

                                                <details class="mt-2">
                                                    <summary class="cursor-pointer text-xs text-gray-600 hover:text-gray-900">
                                                        Editar
                                                    </summary>

                                                    <form
                                                        class="mt-3 space-y-2"
                                                        method="POST"
                                                        action="{{ route('incomes.update', ['family' => $family->id, 'income' => $income->id]) }}"
                                                    >
                                                        @csrf
                                                        @method('PUT')

                                                        <div>
                                                            <label class="block text-xs text-gray-600">Descrição</label>
                                                            <input name="description"
                                                                   value="{{ old('description', $income->description) }}"
                                                                   class="mt-1 w-full rounded border-gray-300" required>
                                                        </div>

                                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                                            <div class="sm:col-span-1">
                                                                <label class="block text-xs text-gray-600">Valor</label>
                                                                <input name="amount" type="number" step="0.01" min="0"
                                                                       value="{{ old('amount', $income->amount) }}"
                                                                       class="mt-1 w-full rounded border-gray-300" required>
                                                            </div>

                                                            <div class="sm:col-span-2">
                                                                <label class="block text-xs text-gray-600">Recebido em</label>
                                                                <input name="received_at" type="date"
                                                                       value="{{ old('received_at', \Illuminate\Support\Carbon::parse($income->received_at)->toDateString()) }}"
                                                                       class="mt-1 w-full rounded border-gray-300" required>
                                                            </div>
                                                        </div>

                                                        <button type="submit"
                                                                class="inline-flex items-center px-3 py-1.5 bg-gray-800 text-white rounded hover:bg-gray-700">
                                                            Salvar
                                                        </button>
                                                    </form>
                                                </details>
                                            </td>

                                            <td class="py-3 pr-4 whitespace-nowrap text-gray-700">
                                                {{ $dateBr }}
                                            </td>

                                            <td class="py-3 pr-4 whitespace-nowrap text-gray-900 font-medium">
                                                R$ {{ number_format((float) $income->amount, 2, ',', '.') }}
                                            </td>

                                            <td class="py-3 whitespace-nowrap">
                                                <form method="POST"
                                                      action="{{ route('incomes.destroy', ['family' => $family->id, 'income' => $income->id]) }}"
                                                      onsubmit="return confirm('Remover esta receita?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded hover:bg-red-500">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
