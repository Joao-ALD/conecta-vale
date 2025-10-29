<x-layouts.public>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-6">
                        {{ __('Editar Anúncio: ') . $product->name }}
                    </h2>

                    <form action="{{ route('products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome do Produto</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700"
                                required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Descrição</label>
                            <textarea id="description" name="description" rows="5"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700"
                                required>{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Preço (R$)</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                                step="0.01" min="0"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700"
                                required>
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="categories" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Categorias (Segure Ctrl/Cmd para selecionar várias)</label>
                            <select name="categories[]" id="categories" multiple
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700"
                                required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->categories->contains($category) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('categories')" class="mt-2" />
                        </div>

                        <div class="mb-4" x-data="{ 
                                 imageOrder: {{ $product->images->pluck('id')->toJson() }}
                             }" x-init=" 
                                 Sortable.create($refs.imageGrid, {
                                     animation: 150,
                                     ghostClass: 'opacity-50',
                                     onEnd: (evt) => {
                                         let items = Array.from(evt.to.children).map(el => el.dataset.id);
                                         imageOrder = items.map(Number);
                                     }
                                 });
                             ">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Imagens Atuais (Arraste para reordenar)</label>

                            <template x-for="id in imageOrder" :key="id">
                                <input type="hidden" name="image_order[]" :value="id">
                            </template>

                            <div x-ref="imageGrid" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
                                @forelse($product->images as $image)
                                    <div class="relative cursor-move group" key="{{ $image->id }}"
                                        data-id="{{ $image->id }}">
                                        <img src="{{ Storage::url($image->path) }}" alt="Imagem"
                                            class="w-full h-24 object-cover rounded-md">
                                        <div class="absolute top-1 left-1 bg-white dark:bg-gray-800 rounded p-1 flex items-center opacity-80 group-hover:opacity-100 transition-opacity"
                                            title="Marcar para excluir">
                                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"
                                                id="delete_image_{{ $image->id }}"
                                                class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                            <label for="delete_image_{{ $image->id }}"
                                                class="ml-1 text-xs text-red-600 font-semibold cursor-pointer">Excluir</label>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 col-span-full">Nenhuma imagem cadastrada.</p>
                                @endforelse
                            </div>
                            <x-input-error :messages="$errors->get('delete_images.*')" class="mt-2" />
                            <x-input-error :messages="$errors->get('image_order')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="new_images" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Adicionar Novas Imagens (Opcional)</label>
                            <input type="file" id="new_images" name="new_images[]" multiple
                                class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <x-input-error :messages="$errors->get('new_images.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('products.my') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:underline mr-4">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-vale-accent transition ease-in-out duration-150">
                                Atualizar Anúncio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    @endpush
</x-layouts.public>
