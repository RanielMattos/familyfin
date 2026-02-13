<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Membros da Família: {{ $family->name ?? $family->id }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded space-y-1">
                    <div class="font-semibold">Corrija:</div>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!$canManage)
                <div class="bg-gray-50 border border-gray-200 text-gray-700 px-4 py-3 rounded">
                    Você tem acesso somente leitura. Apenas Owner/Admin pode gerenciar membros.
                </div>
            @endif

            @if ($canManage)
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Adicionar membro</h3>

                        <form method="POST" action="{{ route('family.members.store', ['family' => $family->id]) }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @csrf

                            <div class="md:col-span-2">
                                <label class="block text-sm text-gray-700">Email do usuário (já cadastrado)</label>
                                <input name="email" type="email" value="{{ old('email') }}"
                                       class="mt-1 w-full rounded border-gray-300" required>
                            </div>

                            <div>
                                <label class="block text-sm text-gray-700">Permissão</label>
                                <select name="role" class="mt-1 w-full rounded border-gray-300" required>
                                    @foreach($roles as $value => $label)
                                        <option value="{{ $value }}" @selected(old('role', \App\Models\FamilyMember::ROLE_MEMBER) === $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-3">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                                    Adicionar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Lista</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left border-b">
                                    <th class="py-2 pr-4">Nome</th>
                                    <th class="py-2 pr-4">Email</th>
                                    <th class="py-2 pr-4">Role</th>
                                    <th class="py-2 pr-4">Ativo</th>
                                    <th class="py-2 pr-4">Entrou em</th>
                                    @if ($canManage)
                                        <th class="py-2 pr-4">Ações</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($members as $m)
                                    <tr class="border-b">
                                        <td class="py-2 pr-4">{{ $m->user?->name ?? '-' }}</td>
                                        <td class="py-2 pr-4">{{ $m->user?->email ?? '-' }}</td>
                                        <td class="py-2 pr-4">
                                            {{ $roles[strtoupper($m->role)] ?? strtoupper($m->role) }}
                                        </td>
                                        <td class="py-2 pr-4">
                                            {{ $m->is_active ? 'Sim' : 'Não' }}
                                        </td>
                                        <td class="py-2 pr-4">
                                            {{ optional($m->joined_at)->format('d/m/Y H:i') ?? '-' }}
                                        </td>

                                        @if ($canManage)
                                            <td class="py-2 pr-4">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <form method="POST" action="{{ route('family.members.update', ['family' => $family->id, 'member' => $m->id]) }}" class="flex items-center gap-2">
                                                        @csrf
                                                        @method('PUT')

                                                        <select name="role" class="rounded border-gray-300 text-sm">
                                                            @foreach($roles as $value => $label)
                                                                <option value="{{ $value }}" @selected(strtoupper($m->role) === $value)>
                                                                    {{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <button class="px-3 py-1 rounded bg-gray-800 text-white hover:bg-gray-700">
                                                            Salvar
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('family.members.destroy', ['family' => $family->id, 'member' => $m->id]) }}"
                                                          onsubmit="return confirm('Remover este membro?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-500">
                                                            Remover
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $canManage ? 6 : 5 }}" class="py-4 text-gray-600">
                                            Nenhum membro.
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
