<x-layouts.public>
    <x-slot name="title">
        Conecta Vale - O seu marketplace do Vale do Ribeira
    </x-slot>

    <div class="mb-6 bg-gradient-to-r from-vale-secondary to-vale-primary text-white p-8 rounded-lg shadow-lg text-center">
        @guest
            <h2 class="text-3xl font-bold mb-2">Anuncie Grátis no Conecta Vale!</h2>
            <p class="mb-4">A plataforma que conecta compradores e vendedores do Vale do Ribeira.</p>
            <a href="{{ route('register') }}" class="inline-block px-6 py-2 rounded-md bg-vale-accent text-black font-semibold hover:bg-yellow-600">Quero Anunciar</a>
        @else {{-- Usuário logado --}}
            @if(auth()->user()->role === 'admin')
                <h2 class="text-3xl font-bold mb-2">Painel do Administrador</h2>
                <p class="mb-4">Bem-vindo, admin! Gerencie a plataforma.</p>
                <a href="{{ route('admin.dashboard') }}" class="inline-block px-6 py-2 rounded-md bg-vale-accent text-black font-semibold hover:bg-yellow-600">Ir para o Dashboard</a>
            @elseif(auth()->user()->role === 'vendedor')
                <h2 class="text-3xl font-bold mb-2">Gerencie seus Anúncios</h2>
                <p class="mb-4">Acesse sua área de vendedor para ver seus planos e produtos.</p>
                <a href="{{ route('seller.plans.show') }}" class="inline-block px-6 py-2 rounded-md bg-vale-accent text-black font-semibold hover:bg-yellow-600">Ver Planos</a>
            @else {{-- Usuário comum --}}
                <h2 class="text-3xl font-bold mb-2">Torne-se um Vendedor de Sucesso!</h2>
                <p class="mb-4">Comece a vender na maior plataforma do Vale do Ribeira.</p>
                <form action="{{ route('user.becomeSeller') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="inline-block px-6 py-2 rounded-md bg-vale-accent text-black font-semibold hover:bg-yellow-600">Quero ser Vendedor</button>
                </form>
            @endif
        @endguest
    </div>

    <section class="w-full">
        <h1 class="font-bold text-2xl mb-6 text-gray-900">Anúncios Recentes</h1>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="text-gray-600 col-span-full">Nenhum produto encontrado.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>

</x-layouts.public>
