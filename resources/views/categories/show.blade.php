<x-layouts.public>
    <x-slot name="title">
        {{ $category->name }} - Conecta Vale
    </x-slot>

    <div>
        <section class="w-full">
            <h1 class="font-bold text-2xl mb-6 text-gray-900">
                Mostrando produtos em: <span class="text-vale-primary">{{ $category->name }}</span>
            </h1>

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @forelse ($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <p class="text-gray-600 col-span-full">Nenhum produto encontrado nesta categoria.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </section>

    </div>
</x-layouts.public>