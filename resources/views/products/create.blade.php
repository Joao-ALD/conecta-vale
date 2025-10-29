<x-layouts.public>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <header class="mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">
                            Criar Novo Anúncio
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Preencha os detalhes abaixo para adicionar um novo produto.
                        </p>
                    </header>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Nome do Produto</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-vale-accent focus:ring focus:ring-vale-accent focus:ring-opacity-50"
                                   required autofocus>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Descrição</label>
                            <textarea id="description" name="description" rows="5"
                                      class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-vale-accent focus:ring focus:ring-vale-accent focus:ring-opacity-50"
                                      required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="price" class="block font-medium text-sm text-gray-700">Preço (R$)</label>
                                <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0"
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
                                        <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('categories')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="images" class="block font-medium text-sm text-gray-700">Imagens (mínimo 1, máximo 5)</label>
                            <input type="file" id="images" name="images[]" multiple required
                                   class="block w-full text-sm text-gray-500 mt-1
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-vale-primary/10 file:text-vale-primary
                                          hover:file:bg-vale-primary/20">
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                            <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                             <a href="{{ route('products.my') }}" class="text-sm text-gray-600 hover:underline mr-4">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-sm text-white hover:bg-vale-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-vale-primary transition ease-in-out duration-150">
                                Salvar Anúncio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
