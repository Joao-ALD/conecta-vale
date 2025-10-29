<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Categoria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome da
                                Categoria</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700"
                                required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="icon_svg"
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300">Ícone SVG</label>
                            <textarea id="icon_svg" name="icon_svg" rows="4"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700 font-mono text-sm">{{ old('icon_svg', $category->icon_svg) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Cole o código SVG completo do ícone.</p>
                            <x-input-error :messages="$errors->get('icon_svg')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('admin.listCategory') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                Cancelar
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 transition ease-in-out duration-150">
                                Atualizar Categoria
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>