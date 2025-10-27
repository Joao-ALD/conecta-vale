<x-layouts.public>
    <x-slot name="title">
        {{ $category->name }} - Conecta Vale
    </x-slot>

    <div class="flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-1/4">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <h2 class="font-bold text-xl mb-4 text-gray-800">Categorias</h2>
                <ul class="space-y-2">
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('categories.show', $cat) }}" 
                               class="block px-3 py-2 rounded-md 
                                      {{ $cat->id == $category->id ? 'bg-vale-primary text-white font-bold' : 'text-gray-700 hover:bg-gray-200 hover:text-vale-primary' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <section class="w-full lg:w-3/4">
            <h1 class="font-bold text-2xl mb-6 text-gray-900">
                Mostrando produtos em: <span class="text-vale-primary">{{ $category->name }}</span>
            </h1>

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
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