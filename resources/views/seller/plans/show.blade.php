<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Escolha seu Plano de Assinatura') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 border border-green-400 p-3 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($plans as $plan)
                            <div class="border rounded-lg p-6 flex flex-col justify-between @if($currentSubscription && $currentSubscription->plan_id == $plan->id) border-green-500 @endif">
                                <div>
                                    <h3 class="text-lg font-bold">{{ $plan->name }}</h3>
                                    <p class="text-2xl font-semibold my-4">R$ {{ number_format($plan->price, 2, ',', '.') }} / mês</p>
                                    <p class="text-gray-600">{{ $plan->description }}</p>
                                    <ul class="mt-4 space-y-2">
                                        <li>Anúncios: {{ $plan->max_products == -1 ? 'Ilimitados' : $plan->max_products }}</li>
                                        <li>Fotos por Anúncio: {{ $plan->max_photos_per_product }}</li>
                                        <li>Destaque: {{ $plan->can_highlight_products ? 'Sim' : 'Não' }}</li>
                                    </ul>
                                </div>

                                <div class="mt-6">
                                    @if($currentSubscription && $currentSubscription->plan_id == $plan->id)
                                        <p class="text-green-600 font-bold text-center">Seu Plano Atual</p>
                                        @if($currentSubscription->expires_at)
                                            <p class="text-sm text-gray-500 text-center">
                                                Expira em: {{ $currentSubscription->expires_at->format('d/m/Y') }}
                                            </p>
                                        @endif
                                    @else
                                        <form action="{{ route('seller.plans.subscribe') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                                {{ $currentSubscription ? 'Mudar para este Plano' : 'Assinar Plano' }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p>Nenhum plano disponível no momento.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
