<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gerenciar Todos os Anúncios') }}
        </h2>
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
                                    <th class="py-3 px-4 font-bold">Anúncio</th>
                                    <th class="py-3 px-4 font-bold">Vendedor</th>
                                    <th class="py-3 px-4 font-bold">Preço</th>
                                    <th class="py-3 px-4 font-bold">Data</th>
                                    <th class="py-3 px-4 font-bold text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-4 px-4">
                                            <a href="{{ route('products.show', $product) }}" target="_blank" class="hover:underline text-vale-primary font-medium" title="Ver anúncio">
                                                {{ $product->name }}
                                            </a>
                                        </td>
                                        <td class="py-4 px-4">{{ $product->seller->name ?? 'Usuário Desconhecido' }}</td>
                                        <td class="py-4 px-4">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                        <td class="py-4 px-4">{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-4 px-4 text-right">
                                            {{-- <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Editar</a> --}}

                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('ADMIN: Tem certeza que deseja excluir PERMANENTEMENTE este anúncio?');">
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
                                        <td colspan="5" class="py-6 px-4 text-center">Nenhum anúncio encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
