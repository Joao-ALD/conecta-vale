<x-layouts.public title="Meus Favoritos">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Meus Favoritos</h1>

        @if ($favorites->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($favorites as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-12">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="text-center bg-white p-12 rounded-lg shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum favorito ainda</h3>
                <p class="mt-1 text-sm text-gray-500">Comece a explorar e adicione produtos que você ama!</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-vale-primary hover:bg-vale-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Ver Produtos
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.public>
