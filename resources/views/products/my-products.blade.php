<x-layouts.public>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800 leading-tight mb-4 md:mb-0">
                            Meus Anúncios
                        </h1>
                        <a href="{{ route('products.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-sm text-white hover:bg-vale-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-vale-primary transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Adicionar Novo Anúncio
                        </a>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="py-3 px-6 font-semibold text-sm text-gray-600 uppercase tracking-wider">Produto</th>
                                    <th class="py-3 px-6 font-semibold text-sm text-gray-600 uppercase tracking-wider">Preço</th>
                                    <th class="py-3 px-6 font-semibold text-sm text-gray-600 uppercase tracking-wider">Data</th>
                                    <th class="py-3 px-6 font-semibold text-sm text-gray-600 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-4 px-6">
                                            <a href="{{ route('products.show', $product) }}" class="font-medium text-gray-800 hover:text-vale-primary">
                                                {{ $product->name }}
                                            </a>
                                        </td>
                                        <td class="py-4 px-6 text-gray-700">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                        <td class="py-4 px-6 text-gray-700">{{ $product->created_at->format('d/m/Y') }}</td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-4">
                                                <a href="{{ route('products.edit', $product->id) }}" class="font-medium text-vale-primary hover:text-vale-accent">Editar</a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este anúncio?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 hover:text-red-800">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-10 px-6 text-center text-gray-500">
                                            Você ainda não tem nenhum anúncio.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($products->hasPages())
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
