<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Receitas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="/f/{{ $family->id }}/incomes" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block text-sm text-gray-700">Descrição</label>
                            <input name="description" value="{{ old('description') }}"
                                   class="mt-1 w-full rounded border-gray-300" required>
                            @error('description')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700">Valor</label>
                            <input name="amount" type="number" step="0.01" min="0"
                                   value="{{ old('amount') }}"
                                   class="mt-1 w-full rounded border-gray-300" required>
                            @error('amount')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700">Recebido em</label>
                            <input name="received_at" type="date"
                                   value="{{ old('received_at', now()->toDateString()) }}"
                                   class="mt-1 w-full rounded border-gray-300" required>
                            @error('received_at')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
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
                    <h3 class="font-semibold text-gray-900 mb-3">Lista</h3>

                    <ul class="list-disc pl-5 space-y-1">
                        @forelse($incomes as $income)
                            <li>{{ $income->description }}</li>
                        @empty
                            <li>Nenhuma receita cadastrada.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
