<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (Auth::user()->role === 'usuario')
                        <div class="bg-vale-primary text-white p-6 rounded-lg text-center">
                            <h2 class="text-2xl font-bold mb-2">Quer vender seus produtos no Conecta Vale?</h2>
                            <p class="mb-4">Anuncie seus produtos, alcance mais clientes e impulsione suas vendas em nossa plataforma.</p>
                            <form method="POST" action="{{ route('user.becomeSeller') }}" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-vale-accent text-black font-bold py-2 px-4 rounded-lg hover:bg-yellow-500 transition-colors duration-300">
                                    Tornar-se Vendedor Agora
                                </button>
                            </form>
                        </div>
                    @else
                        <p>Bem-vindo ao seu painel!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
