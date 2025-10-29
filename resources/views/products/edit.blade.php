<x-layouts.public>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <header class="mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">
                            Editar Anúncio
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                           Atualize os detalhes do seu produto.
                        </p>
                    </header>

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Nome do Produto</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-vale-accent focus:ring focus:ring-vale-accent focus:ring-opacity-50"
                                   required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Descrição</label>
                            <textarea id="description" name="description" rows="5"
                                      class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-vale-accent focus:ring focus:ring-vale-accent focus:ring-opacity-50"
                                      required>{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="price" class="block font-medium text-sm text-gray-700">Preço (R$)</label>
                                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0"
                                       class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-vale-accent focus:ring focus:ring-vale-accent focus:ring-opacity-50"
                                       required>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div>
                                <label for="categories" class="block font-medium text-sm text-gray-700">Categorias</label>
                                <select name="categories[]" id="categories" multiple
                                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-vale-accent focus:ring focus:ring-vale-accent focus:ring-opacity-50"
                                        required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('categories')" class="mt-2" />
                            </div>
                        </div>

                        <div class="space-y-2" x-data="{ imageOrder: {{ $product->images->pluck('id')->toJson() }} }" x-init="Sortable.create($refs.imageGrid, { animation: 150, ghostClass: 'opacity-50', onEnd: (evt) => { imageOrder = Array.from(evt.to.children).map(el => el.dataset.id) } });">
                            <label class="block font-medium text-sm text-gray-700">Imagens Atuais (Arraste para reordenar)</label>

                            <template x-for="id in imageOrder" :key="id">
                                <input type="hidden" name="image_order[]" :value="id">
                            </template>

                            <div x-ref="imageGrid" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                                @forelse($product->images as $image)
                                    <div class="relative group cursor-move" data-id="{{ $image->id }}">
                                        <img src="{{ Storage::url($image->path) }}" alt="Imagem do produto" class="w-full h-24 object-cover rounded-md border border-gray-200">
                                        <div class="absolute top-1 right-1" title="Marcar para excluir">
                                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_image_{{ $image->id }}" class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500 cursor-pointer">
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 col-span-full">Nenhuma imagem cadastrada.</p>
                                @endforelse
                            </div>
                            <x-input-error :messages="$errors->get('delete_images.*')" class="mt-2" />
                            <x-input-error :messages="$errors->get('image_order')" class="mt-2" />
                        </div>

                        <div>
                            <label for="new_images" class="block font-medium text-sm text-gray-700">Adicionar Novas Imagens (Opcional)</label>
                             <input type="file" id="new_images" name="new_images[]" multiple
                                   class="block w-full text-sm text-gray-500 mt-1
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-vale-primary/10 file:text-vale-primary
                                          hover:file:bg-vale-primary/20">
                            <x-input-error :messages="$errors->get('new_images.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                            <a href="{{ route('products.my') }}" class="text-sm text-gray-600 hover:underline mr-4">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-sm text-white hover:bg-vale-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-vale-primary transition ease-in-out duration-150">
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
