<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Minhas Mensagens
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($conversations as $convo)
                            <a href="{{ route('contact.show', $convo->product_id) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="flex justify-between items-center">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Conversa sobre: 
                                            <span class="font-semibold text-vale-primary">{{ $convo->product->name }}</span>
                                        </p>

                                        @php
                                            $otherUser = $convo->buyer_id == Auth::id() ? $convo->seller : $convo->buyer;
                                        @endphp
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            Com: {{ $otherUser->name }}
                                        </h3>
                                    </div>
                                    <div class="text-right text-sm text-gray-500 dark:text-gray-400">
                                        <p>Última msg:</p>
                                        <p>{{ $convo->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="p-4 text-center text-gray-500 dark:text-gray-400">
                                Você não tem nenhuma mensagem.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>