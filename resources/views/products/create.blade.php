<x-layouts.public>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-6">
                        {{ __('Criar Novo Anúncio') }}
                    </h2>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome do Produto</label>
                            <input type="text" id="name" name="name"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700"
                                required autofocus>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Descrição</label>
                            <textarea id="description" name="description" rows="5"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700"
                                required></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Preço (R$)</label>
                            <input type="number" id="price" name="price" step="0.01" min="0"
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
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('categories')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="images" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Imagens (mínimo 1)</label>
                            <input type="file" id="images" name="images[]" multiple class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                            <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-vale-accent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Salvar Anúncio
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
