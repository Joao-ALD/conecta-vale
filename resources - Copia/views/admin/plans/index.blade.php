<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gerenciar Planos de Assinatura') }}
            </h2>
            <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 transition ease-in-out duration-150">
                + Criar Novo Plano
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
             @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b-2 border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 font-bold">Nome</th>
                                    <th class="py-3 px-4 font-bold">Preço (R$)</th>
                                    <th class="py-3 px-4 font-bold">Descrição</th>
                                    <th class="py-3 px-4 font-bold">Ativo</th>
                                    <th class="py-3 px-4 font-bold text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($plans as $plan)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-4 px-4 font-medium">{{ $plan->name }}</td>
                                        <td class="py-4 px-4">R$ {{ number_format($plan->price, 2, ',', '.') }}</td>
                                        <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($plan->description, 50) }}</td>
                                        <td class="py-4 px-4">
                                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $plan->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                {{ $plan->is_active ? 'Sim' : 'Não' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <a href="{{ route('admin.plans.edit', $plan->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Editar</a>
                                            <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Tem certeza que deseja excluir este plano?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">
                                                    Excluir
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 px-4 text-center">Nenhum plano cadastrado.</td>
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