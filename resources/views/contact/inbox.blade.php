<x-layouts.public>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ __('Caixa de Entrada') }}
                    </h2>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Suas Conversas</h3>

                    @if ($conversations->isEmpty())
                        <p>Você não tem nenhuma conversa ainda.</p>
                    @else
                        <div class="space-y-4">
                            @foreach ($conversations as $conversation)
                                <a href="{{ route('contact.show', $conversation) }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                    <div class="flex justify-between">
                                        <div class="font-bold">{{ $conversation->product->name }}</div>
                                        <div class="text-sm text-gray-500">
                                            Última mensagem: {{ $conversation->updated_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        Conversa com: 
                                        @if (Auth::id() === $conversation->buyer_id)
                                            {{ $conversation->seller->name }} (Vendedor)
                                        @else
                                            {{ $conversation->buyer->name }} (Comprador)
                                        @endif
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
