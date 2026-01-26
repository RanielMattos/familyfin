<x-app-layout>
    @php
        /** @var \App\Models\Family|null $family */
        $familyName = $family?->name ?? '';
        $fromValue  = old('from', $from ?? '');
        $toValue    = old('to', $to ?? '');
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('PlanPag') }} · {{ $familyName }}
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
                            <x-text-input
                                id="from"
                                name="from"
                                type="date"
                                class="mt-1 block w-full"
                                value="{{ $fromValue }}"
                                required
                            />
                        </div>

                        <div class="w-full md:w-56">
                            <x-input-label for="to" value="Até" />
                            <x-text-input
                                id="to"
                                name="to"
                                type="date"
                                class="mt-1 block w-full"
                                value="{{ $toValue }}"
                                required
                            />
                        </div>

                        <div>
                            <x-primary-button type="submit">
                                Filtrar
                            </x-primary-button>
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
                                    <th class="py-2 pr-6 whitespace-nowrap">Vencimento</th>
                                    <th class="py-2 pr-6">Conta</th>
                                    <th class="py-2 pr-6">Status</th>
                                    <th class="py-2 pr-6 text-right">Previsto</th>
                                    <th class="py-2 pr-6 text-right">Pago</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @forelse(($items ?? collect()) as $o)
                                    @php
                                        $status = strtoupper((string) ($o->status ?? 'OPEN'));
                                        $isPaid = $status === 'PAID';

                                        $planned = (int) ($o->planned_amount_cents ?? 0);
                                        $paid    = (int) ($o->paid_amount_cents ?? 0);
                                    @endphp

                                    <tr>
                                        <td class="py-3 pr-6 text-gray-700 whitespace-nowrap">
                                            {{ $o->due_date?->toDateString() ?? '-' }}
                                        </td>

                                        <td class="py-3 pr-6 font-medium text-gray-900">
                                            {{ $o->bill?->name ?? '-' }}
                                        </td>

                                        <td class="py-3 pr-6">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                                {{ $isPaid ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $status }}
                                            </span>
                                        </td>

                                        <td class="py-3 pr-6 text-right tabular-nums text-gray-700">
                                            R$ {{ number_format($planned / 100, 2, ',', '.') }}
                                        </td>

                                        <td class="py-3 pr-6 text-right tabular-nums text-gray-700">
                                            R$ {{ number_format($paid / 100, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-3 text-gray-500" colspan="5">
                                            Nenhuma ocorrência no período.
                                        </td>
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
