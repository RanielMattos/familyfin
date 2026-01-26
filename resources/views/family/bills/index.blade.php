<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Contas · {{ $family->name }}
            </h2>

            <a href="{{ route('family.bills.create', $family) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Nova conta
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-600">
                            <tr>
                                <th class="py-2 pr-4">Nome</th>
                                <th class="py-2 pr-4">Tipo</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4">Slug</th>
                                <th class="py-2 pr-4">Criada em</th>
                                <th class="py-2 pr-4 text-right">Ações</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($bills as $b)
                                @php
                                    $typeLabel = $b->direction === 'RECEIVABLE' ? 'A receber' : 'A pagar';
                                    $hasOccurrences = (int) ($b->occurrences_count ?? 0) > 0;
                                    $isActive = (bool) ($b->is_active ?? true);
                                @endphp

                                <tr class="hover:bg-gray-50 {{ $isActive ? '' : 'opacity-60' }}">
                                    <td class="py-3 pr-4 font-medium text-gray-900">{{ $b->name }}</td>
                                    <td class="py-3 pr-4 text-gray-700">{{ $typeLabel }}</td>

                                    <td class="py-3 pr-4">
                                        @if ($isActive)
                                            <span class="inline-flex items-center rounded-full bg-green-50 border border-green-200 px-2 py-0.5 text-green-800 text-xs">
                                                Ativa
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-50 border border-gray-200 px-2 py-0.5 text-gray-700 text-xs">
                                                Inativa
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-3 pr-4 text-gray-500 font-mono">{{ $b->slug }}</td>
                                    <td class="py-3 pr-4 text-gray-500 whitespace-nowrap">{{ $b->created_at?->toDateString() }}</td>

                                    <td class="py-3 pr-4">
                                        <div class="flex items-center justify-end gap-3">

                                            <form method="POST" action="{{ route('family.bills.toggleActive', ['family' => $family, 'bill' => $b]) }}">
                                                @csrf
                                                <button type="submit" class="text-gray-800 hover:text-gray-900 underline">
                                                    {{ $isActive ? 'Inativar' : 'Ativar' }}
                                                </button>
                                            </form>

                                            <a href="{{ route('family.bills.edit', ['family' => $family, 'bill' => $b]) }}"
                                               class="text-gray-800 hover:text-gray-900 underline">
                                                Editar
                                            </a>

                                            @if ($hasOccurrences)
                                                <span class="text-gray-400 cursor-not-allowed" title="Esta conta possui ocorrências vinculadas">
                                                    Excluir
                                                </span>
                                            @else
                                                <form method="POST" action="{{ route('family.bills.destroy', ['family' => $family, 'bill' => $b]) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="text-red-700 hover:text-red-800 underline"
                                                        onclick="return confirm('Remover esta conta?')"
                                                    >
                                                        Excluir
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-3 text-gray-500" colspan="6">Nenhuma conta cadastrada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <p class="mt-4 text-xs text-gray-500">
                        Observação: contas com ocorrências (lançamentos) vinculadas não podem ser removidas.
                        Use “Inativar” para parar de usar sem apagar histórico.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
