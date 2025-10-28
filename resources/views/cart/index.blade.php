<x-layouts.public>
    <x-slot name="title">Seu Carrinho - Conecta Vale</x-slot>

    <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Seu Carrinho de Compras</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th class="py-3 px-4 font-bold text-gray-700">Produto</th>
                        <th class="py-3 px-4 font-bold text-gray-700">Preço</th>
                        <th class="py-3 px-4 font-bold text-gray-700">Quantidade</th>
                        <th class="py-3 px-4 font-bold text-gray-700">Subtotal</th>
                        <th class="py-3 px-4 font-bold text-gray-700">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cart as $id => $details)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-4 font-semibold text-gray-800">
                                <a href="{{ route('products.show', $id) }}" class="hover:text-vale-primary">
                                    {{ $details['name'] }}
                                </a>
                            </td>
                            <td class="py-4 px-4">R$ {{ number_format($details['price'], 2, ',', '.') }}</td>
                            <td class="py-4 px-4">
                                {{ $details['quantity'] }}
                            </td>
                            <td class="py-4 px-4">
                                R$ {{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}
                            </td>
                            <td class="py-4 px-4">
                                <form action="{{ route('cart.destroy', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 px-4 text-center text-gray-600">
                                Seu carrinho está vazio.
                                <a href="{{ route('home') }}" class="text-vale-primary font-bold hover:underline ml-2">Comece a comprar!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($cart) > 0)
        <div class="mt-8 flex flex-col sm:flex-row justify-between items-center">
            <div class="text-2xl font-bold text-gray-900">
                Total: <span class="text-vale-primary">R$ {{ number_format($total, 2, ',', '.') }}</span>
            </div>

            <div class="mt-4 sm:mt-0">
                <a href="{{ route('checkout.index') }}" class="w-full sm:w-auto bg-vale-primary hover:bg-opacity-90 text-white font-bold py-3 px-8 rounded-lg text-lg transition-colors duration-300">
                    Finalizar Compra
                </a>
            </div>
        </div>
        @endif

    </div>
</x-layouts.public>