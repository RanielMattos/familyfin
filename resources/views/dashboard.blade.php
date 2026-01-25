<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('FamilyFin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold">Bem-vindo 👋</h3>
                        <p class="text-sm text-gray-600">
                            Para continuar, escolha uma família ou crie uma nova.
                        </p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="border rounded-lg p-4">
                            <h4 class="font-semibold mb-2">Minhas famílias</h4>
                            <p class="text-sm text-gray-600 mb-4">
                                (Próximo passo: listar as famílias do usuário aqui.)
                            </p>

                            <div class="text-sm text-gray-500">
                                Ainda não carregamos nada do banco nesta tela.
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h4 class="font-semibold mb-2">Criar nova família</h4>
                            <p class="text-sm text-gray-600 mb-4">
                                (Próximo passo: formulário para criar a família.)
                            </p>

                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Criar família
                            </button>
                        </div>
                    </div>

                    <div class="text-xs text-gray-400">
                        Status: UI skeleton ✅ | Data + rotas virão no próximo passo.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
