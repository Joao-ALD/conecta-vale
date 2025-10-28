<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Planos de Assinatura') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Escolha o Plano Ideal para Você</h3>
                <p class="text-gray-600 dark:text-gray-400">Aumente a visibilidade dos seus anúncios e venda mais rápido!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($plans as $plan)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col border {{ $currentSubscription && $currentSubscription->plan_id == $plan->id ? 'border-vale-primary' : 'border-transparent' }}">
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-gray-100 text-center mb-2">{{ $plan->name }}</h4>
                        <p class="text-4xl font-extrabold text-vale-primary text-center mb-4">
                            R$ {{ number_format($plan->price, 2, ',', '.') }} <span class="text-base font-normal text-gray-500 dark:text-gray-400">/mês</span>
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 text-center mb-6 h-16">{{ $plan->description }}</p>

                        <ul class="space-y-2 mb-8 flex-grow">
                            @if($plan->features)
                                @foreach(explode(';', $plan->features) as $feature)
                                    <li class="flex items-center">
                                        <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <span class="text-gray-700 dark:text-gray-300">{{ trim($feature) }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-gray-500 dark:text-gray-400">Nenhuma funcionalidade extra.</li>
                            @endif
                        </ul>

                        {{-- Lógica de Botão (Assinar/Plano Atual) --}}
                        <div class="mt-auto">
                            @if($currentSubscription && $currentSubscription->plan_id == $plan->id)
                                <span class="block w-full text-center px-6 py-3 border border-transparent rounded-md text-base font-medium text-white bg-gray-400 dark:bg-gray-600 cursor-not-allowed">Seu Plano Atual</span>
                            @else
                                {{-- Ação de assinar será implementada depois --}}
                                <a href="#" class="block w-full text-center px-6 py-3 border border-transparent rounded-md text-base font-medium text-white bg-vale-primary hover:bg-opacity-90 transition">
                                    Assinar Plano
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-600 dark:text-gray-400 md:col-span-2 lg:col-span-3">Nenhum plano disponível no momento.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>