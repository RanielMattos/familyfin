<x-app-layout>
    @php
        // Família (o controller normalmente envia $family)
        $familyName = $family->name ?? null;

        // Datas (prioridade: old -> controller -> querystring)
        $fromValue = old('from', $from ?? request('from') ?? '');
        $toValue   = old('to',   $to   ?? request('to')   ?? '');

        // Linhas (compatível com $occurrences e $items)
        $rows = $occurrences ?? $items ?? [];
        $rows = is_iterable($rows) ? $rows : [];
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('PlanPag') }} · {{ $familyName ?? 'Minha Família' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="GET" action="{{ url()->current() }}" class="flex flex-col md:flex-row gap-3 items-end">
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
                                    <th class="py-2 pr-6 whitespace-nowrap">Vencimento</th>
                                    <th class="py-2 pr-6">Conta</th>
                                    <th class="py-2 pr-6">Status</th>
                                    <th class="py-2 pr-6 text-right">Previsto</th>
                                    <th class="py-2 pr-6 text-right">Pago</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @forelse($rows as $o)
                                    @php
                                        $status = strtoupper((string)($o->status ?? 'OPEN'));

                                        $badgeClass = match ($status) {
                                            'PAID' => 'bg-emerald-100 text-emerald-800',
                                            'CANCELLED', 'CANCELED' => 'bg-gray-100 text-gray-700',
                                            'OVERDUE' => 'bg-red-100 text-red-800',
                                            default => 'bg-amber-100 text-amber-800',
                                        };

                                        $plannedCents = (int) ($o->planned_amount_cents ?? 0);
                                        $paidCents    = (int) ($o->paid_amount_cents ?? 0);
                                    @endphp

                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pr-6 text-gray-700 whitespace-nowrap">
                                            {{ $o->due_date?->toDateString() ?? '-' }}
                                        </td>

                                        <td class="py-3 pr-6 font-medium text-gray-900">
                                            {{ $o->bill?->name ?? '-' }}
                                        </td>

                                        <td class="py-3 pr-6">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold {{ $badgeClass }}">
                                                {{ $status }}
                                            </span>
                                        </td>

                                        <td class="py-3 pr-6 text-right tabular-nums text-gray-700 whitespace-nowrap">
                                            R$ {{ number_format($plannedCents / 100, 2, ',', '.') }}
                                        </td>

                                        <td class="py-3 pr-6 text-right tabular-nums text-gray-700 whitespace-nowrap">
                                            R$ {{ number_format($paidCents / 100, 2, ',', '.') }}
                                        </td>
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
