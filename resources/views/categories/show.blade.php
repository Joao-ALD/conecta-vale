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
                                class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors
                                    {{ $cat->id == $category->id ? 'bg-vale-primary text-white font-bold' : 'text-gray-700 hover:bg-gray-200 hover:text-vale-primary' }}">
                                <span class="w-6 h-6">
                                    @if($cat->icon_svg)
                                        {!! $cat->icon_svg !!}
                                    @else
                                        <!-- Placeholder Icon -->
                                        <svg xmlns="http://www.w.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.43 2.43c-1.105 0-2.02-.915-2.02-2.02v-2.02a2.25 2.25 0 012.43-2.43 3 3 0 001.128-5.78 3 3 0 015.78-1.128zM18.75 5.25a2.25 2.25 0 012.43 2.43c0 1.105-.915 2.02-2.02 2.02v2.02a2.25 2.25 0 01-2.43 2.43 3 3 0 00-1.128 5.78 3 3 0 01-5.78 1.128zM18 3a3 3 0 00-3 3v.165a2.25 2.25 0 01-2.43 2.43h-2.02a2.25 2.25 0 01-2.43-2.43V6a3 3 0 00-3-3h-.165a2.25 2.25 0 01-2.43-2.43V3.41c0-1.105.915-2.02 2.02-2.02h2.02a2.25 2.25 0 012.43 2.43V6a3 3 0 003 3h.165a2.25 2.25 0 012.43 2.43v.165c0 1.105-.915 2.02-2.02 2.02h-2.02a2.25 2.25 0 01-2.43-2.43V9a3 3 0 00-3-3h-.165a2.25 2.25 0 01-2.43-2.43" />
                                        </svg>
                                    @endif
                                </span>
                                <span>
                                    {{ $cat->name }}
                                </span>
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