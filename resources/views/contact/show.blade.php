<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Conversa sobre: {{ $conversation->product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Message List -->
                    <div class="space-y-6 mb-6">
                        @foreach ($conversation->messages as $message)
                            <div class="flex {{ $message->user_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-lg px-4 py-2 rounded-lg {{ $message->user_id === Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                                    <p class="text-sm">{{ $message->body }}</p>
                                    <div class="text-xs text-right mt-1 {{ $message->user_id === Auth::id() ? 'text-blue-200' : 'text-gray-500' }}">
                                        {{ $message->created_at->format('d/m H:i') }}
                                        {{-- Show read status only for messages sent by the current user --}}
                                        @if($message->user_id === Auth::id())
                                            @if($message->is_read)
                                                {{-- Double check icon for "read" --}}
                                                <svg class="inline-block h-4 w-4 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path><path fill-rule="evenodd" d="M11.293 5.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-2-2a1 1 0 111.414-1.414L7 8.586l3.293-3.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            @else
                                                {{-- Single check icon for "sent" --}}
                                                <svg class="inline-block h-4 w-4 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Reply Form -->
                    <form action="{{ route('contact.send', $conversation) }}" method="POST">
                        @csrf
                        <div>
                            <x-input-label for="body" :value="__('Sua Mensagem')" />
                            <textarea id="body" name="body" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required></textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Enviar Mensagem') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
