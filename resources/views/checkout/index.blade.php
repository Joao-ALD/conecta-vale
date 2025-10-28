<x-layouts.public>
    <x-slot name="title">Finalizar Compra - Conecta Vale</x-slot>

    <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Finalizar Compra</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Confirmar Pedido</h2>
                <div class="prose max-w-none text-gray-600">
                    <p>
                        Ao clicar em "Confirmar Pedido", a sua encomenda será registada no nosso sistema
                        com o estado "Pendente".
                    </p>
                    <p>
                        Esta funcionalidade é um passo inicial. A integração com um gateway de pagamento
                        real (como Stripe ou PagSeguro) será implementada no futuro para processar
                        pagamentos de forma segura.
                    </p>
                    <p class="font-semibold">
                        Nenhum dado de pagamento é necessário nesta fase.
                    </p>
                </div>

                <form action="{{ route('checkout.store') }}" method="POST" class="mt-8">
                    @csrf
                    <button type="submit" class="w-full bg-vale-primary hover:bg-opacity-90 text-white font-bold py-3 px-8 rounded-lg text-lg transition-colors duration-300">
                        Confirmar Pedido
                    </button>
                </form>
            </div>
            <div class="lg:col-span-1">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Resumo do Pedido</h2>
                <div class="space-y-4">
                    @foreach($cart as $id => $details)
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold">{{ $details['name'] }}</p>
                                <p class="text-sm text-gray-600">Quantidade: {{ $details['quantity'] }}</p>
                            </div>
                            <p class="font-semibold">R$ {{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center">
                    <p class="text-lg font-bold">Total</p>
                    <p class="text-lg font-bold text-vale-primary">R$ {{ number_format($total, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
