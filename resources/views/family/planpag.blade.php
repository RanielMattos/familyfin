<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PlanPag · {{ $family->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" class="flex flex-col md:flex-row gap-3 items-end">
                        <div class="w-full md:w-56">
                            <x-input-label for="from" value="De" />
                            <x-text-input id="from" name="from" type="date" class="mt-1 block w-full" value="{{ $from }}" required />
                        </div>

                        <div class="w-full md:w-56">
                            <x-input-label for="to" value="Até" />
                            <x-text-input id="to" name="to" type="date" class="mt-1 block w-full" value="{{ $to }}" required />
                        </div>

                        <div>
                            <x-primary-button type="submit">Filtrar</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-600">
                                <tr>
                                    <th class="py-2 pr-4">Vencimento</th>
                                    <th class="py-2 pr-4">Conta</th>
                                    <th class="py-2 pr-4">Status</th>
                                    <th class="py-2 pr-4">Previsto</th>
                                    <th class="py-2 pr-4">Pago</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse ($occurrences as $occ)
                                    <tr>
                                        <td class="py-2 pr-4">
                                            {{ \Illuminate\Support\Carbon::parse($occ->due_date)->toDateString() }}
                                        </td>
                                        <td class="py-2 pr-4">{{ $occ->bill?->name }}</td>
                                        <td class="py-2 pr-4">{{ $occ->status }}</td>
                                        <td class="py-2 pr-4">{{ $occ->planned_amount_cents }}</td>
                                        <td class="py-2 pr-4">{{ $occ->paid_amount_cents }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-3 text-gray-500" colspan="5">Nenhuma ocorrência no período.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
