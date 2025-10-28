<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Conversa sobre: {{ $conversation->product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Produto: <a href="{{ route('products.show', $conversation->product) }}" class="text-vale-primary hover:underline">{{ $conversation->product->name }}</a>
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Vendedor: {{ $conversation->seller->name }}
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="space-y-4 max-h-96 overflow-y-auto mb-6 pr-4">
                    @forelse($conversation->messages as $message)
                        @if($message->user_id == Auth::id())
                            <div class="flex justify-end">
                                <div class="bg-vale-primary text-white p-3 rounded-lg max-w-xs lg:max-w-md">
                                    <p class="text-sm">{{ $message->body }}</p>
                                    <span class="text-xs text-blue-100 opacity-75 mt-1 block text-right">{{ $message->created_at->format('d/m H:i') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="flex justify-start">
                                <div class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 p-3 rounded-lg max-w-xs lg:max-w-md">
                                    <p class="text-sm">{{ $message->body }}</p>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block text-right">{{ $message->created_at->format('d/m H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center">Nenhuma mensagem ainda. Seja o primeiro a enviar!</p>
                    @endforelse
                </div>

                <form action="{{ route('contact.send', $conversation->product_id) }}" method="POST">
                    @csrf
                    <div class="flex gap-4">
                        <textarea name="body" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Escreva sua mensagem..." required></textarea>
                        <button type="submit" class="mt-1 inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 h-fit">
                            Enviar
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('body')" class="mt-2" />
                </form>
            </div>
        </div>
    </div>
</x-app-layout>