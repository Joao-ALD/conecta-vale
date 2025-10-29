<x-layouts.public>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-6 text-gray-800">
                        Minhas Conversas
                    </h1>

                    @forelse ($conversations as $conversation)
                        <a href="{{ route('contact.show', $conversation) }}"
                           class="flex items-center p-4 border-b border-gray-200 hover:bg-gray-50 last:border-b-0">

                            <!-- Informações Principais -->
                            <div class="flex-grow">
                                <div class="font-semibold text-gray-900">
                                    @if (Auth::id() === $conversation->buyer_id)
                                        {{ $conversation->seller->store_name ?? $conversation->seller->name }}
                                    @else
                                        {{ $conversation->buyer->name }}
                                    @endif
                                    <span class="font-normal text-gray-500">
                                        sobre o produto: {{ $conversation->product->name }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 truncate mt-1">
                                    {{ $conversation->latestMessage ? $conversation->latestMessage->body : 'Nenhuma mensagem ainda.' }}
                                </p>
                            </div>

                            <!-- Data e Indicador de Não Lidas -->
                            <div class="flex-shrink-0 ml-4 text-right">
                                <div class="text-xs text-gray-400">
                                    {{ $conversation->latestMessage ? $conversation->latestMessage->created_at->diffForHumans() : '' }}
                                </div>
                                @if ($conversation->unread_messages_count > 0)
                                    <span class="inline-block w-3 h-3 bg-vale-primary rounded-full ml-2 mt-1" title="{{ $conversation->unread_messages_count }} mensagens não lidas"></span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            <p>Você não tem nenhuma conversa ainda.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
