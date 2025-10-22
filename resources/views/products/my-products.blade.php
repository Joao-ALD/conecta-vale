<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Meus Anúncios') }}
            </h2>

            <a href="{{ route('products.create') }}"
                class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Adicionar Novo Anúncio
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b-2 border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 font-bold">Produto</th>
                                    <th class="py-3 px-4 font-bold">Preço</th>
                                    <th class="py-3 px-4 font-bold">Data</th>
                                    <th class="py-3 px-4 font-bold">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr
                                        class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-4 px-4">{{ $product->name }}</td>
                                        <td class="py-4 px-4">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                        <td class="py-4 px-4">{{ $product->created_at->format('d/m/Y') }}</td>
                                        <td class="py-4 px-4">
                                            <a href="#"
                                                class="text-indigo-600 dark:text-indigo-400 hover:underline">Editar</a>
                                            <a href="#"
                                                class="text-red-600 dark:text-red-400 hover:underline ml-4">Excluir</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 px-4 text-center">
                                            Você ainda não tem nenhum anúncio.
                                        </td>
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