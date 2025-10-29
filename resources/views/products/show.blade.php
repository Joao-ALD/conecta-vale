<x-layouts.public>
    <x-slot name="title">
        {{ $product->name }} - Conecta Vale
    </x-slot>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden lg:grid lg:grid-cols-3 lg:gap-x-8">

        <div class="lg:col-span-2" x-data="{
            images: {{ json_encode($product->images->sortBy('order')->pluck('path')->map(fn($path) => Storage::url($path))) }},
            currentIndex: 0,
            isModalOpen: false,
            modalImageUrl: '',
            next() {
                if (this.currentIndex < this.images.length - 1) {
                    this.currentIndex++;
                } else {
                    this.currentIndex = 0; // Loop
                }
            },
            prev() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                } else {
                    this.currentIndex = this.images.length - 1; // Loop
                }
            },
            openModal(imageUrl) {
                this.modalImageUrl = imageUrl;
                this.isModalOpen = true;
            },
            closeModal() {
                this.isModalOpen = false;
            },
            get mainImage() {
                return this.images.length > 0 ? this.images[this.currentIndex] : '{{ $product->first_image_url }}';
            }
        }">
            <!-- Main Image Display -->
            <div class="relative bg-gray-200 dark:bg-gray-700 rounded-lg mb-4">
                <img @click="openModal(mainImage)" :src="mainImage" alt="{{ $product->name }}" class="h-96 w-full object-cover rounded-lg cursor-pointer">

                <!-- Carousel Buttons -->
                <template x-if="images.length > 1">
                    <div class="absolute inset-0 flex items-center justify-between px-4">
                        <button @click="prev()" class="bg-black/50 text-white rounded-full p-2 hover:bg-black/75 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button @click="next()" class="bg-black/50 text-white rounded-full p-2 hover:bg-black/75 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Thumbnails -->
            <div class="flex space-x-2 overflow-x-auto pb-2">
                @forelse($product->images->sortBy('order') as $index => $image)
                    <button @click="currentIndex = {{ $index }}; openModal('{{ Storage::url($image->path) }}')" class="w-24 h-24 flex-shrink-0 rounded-md overflow-hidden border-2 cursor-pointer" :class="{ 'border-vale-primary': currentIndex === {{ $index }} }">
                        <img src="{{ Storage::url($image->path) }}" alt="Miniatura" class="w-full h-full object-cover">
                    </button>
                @empty
                    <!-- Show a placeholder if no images -->
                    <div class="w-24 h-24 flex-shrink-0 rounded-md overflow-hidden border-2 bg-gray-100 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 14m6-6l.01.01"></path></svg>
                    </div>
                @endforelse
            </div>

            <!-- Full-screen Modal -->
            <div
                x-show="isModalOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click.self="closeModal()"
                @keydown.escape.window="closeModal()"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
                x-cloak
            >
                <img :src="modalImageUrl" alt="Visualização em tela cheia" class="max-w-full max-h-full object-contain p-4">
                
                <button @click="closeModal()" class="absolute top-4 right-4 text-white text-4xl leading-none hover:text-gray-300">&times;</button>
            </div>
        </div>
        <div class="p-6 lg:col-span-1 flex flex-col justify-between">
            <div>
                <div class="mb-2">
                    @foreach($product->categories as $category)
                        <span
                            class="inline-block bg-gray-200 text-gray-700 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
                    {!! highlight($product->name, $query ?? null) !!}
                </h1>

                <p class="text-4xl font-bold text-vale-primary mb-6">
                    R$ {{ number_format($product->price, 2, ',', '.') }}
                </p>

                <div class="mb-6">
                    <h2 class="text-lg font-bold mb-2">Descrição</h2>
                    <p class="text-gray-700 whitespace-pre-line">
                        {!! highlight($product->description, $query ?? null) !!}
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <div class="flex items-center gap-x-4 mb-4">
                    <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="flex-grow">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-x-2 border-2 border-gray-300 hover:border-red-400 hover:bg-red-50 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition-colors duration-300">
                            @auth
                                @if(Auth::user()->favorites->contains($product))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Remover dos Favoritos</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.682l1.318-1.364a4.5 4.5 0 016.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                                    </svg>
                                    <span>Adicionar aos Favoritos</span>
                                @endif
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.682l1.318-1.364a4.5 4.5 0 016.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                                </svg>
                                <span>Adicionar aos Favoritos</span>
                            @endauth
                        </button>
                    </form>
                </div>

                <form action="{{ route('cart.store', $product) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-vale-accent hover:bg-yellow-600 text-black font-bold py-3 px-6 rounded-lg text-lg transition-colors duration-300">
                        Adicionar ao Carrinho
                    </button>
                </form>

                <a href="{{ route('contact.initiate', $product) }}"
                    class="mt-4 w-full block text-center bg-vale-primary hover:bg-opacity-90 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors duration-300">
                    Entrar em Contato com Vendedor
                </a>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="mt-4"
                            onsubmit="return confirm('ADMIN: Tem certeza que deseja excluir PERMANENTEMENTE este anúncio?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors duration-300">
                                Excluir Anúncio (Admin)
                            </button>
                        </form>
                    @endif
                @endauth

            </div>
        </div>

        <div class="lg:col-span-3 border-t border-gray-200 p-6">
            <h2 class="text-xl font-bold mb-4">Informações do Vendedor</h2>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-lg font-semibold">
                    {{ $product->seller->sellerProfile->store_name ?? $product->seller->name }}</p>
                <p class="text-gray-600">Vendedor desde: {{ $product->seller->created_at->format('M Y') }}</p>
                <p class="text-gray-600">Telefone: {{ $product->seller->sellerProfile->phone ?? 'Não informado' }}</p>
            </div>
        </div>
    </div>
</x-layouts.public>