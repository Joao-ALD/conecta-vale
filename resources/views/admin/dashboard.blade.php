<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Painel do Administrador - Gerenciar Categorias') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showDeleteModal: false, categoryName: '', deleteAction: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-6">

                <div class="w-full lg:w-1/3">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-medium mb-4">Criar Nova Categoria</h3>

                            <form action="{{ route('admin.categories.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="name"
                                        class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome da
                                        Categoria</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700"
                                        required>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <label for="icon_svg"
                                        class="block font-medium text-sm text-gray-700 dark:text-gray-300">Ícone SVG</label>
                                    <textarea id="icon_svg" name="icon_svg" rows="4"
                                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700 font-mono text-sm">{{ old('icon_svg') }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">Cole o código SVG completo do ícone.</p>
                                    <x-input-error :messages="$errors->get('icon_svg')" class="mt-2" />
                                </div>

                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 transition ease-in-out duration-150">
                                    Salvar Categoria
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-2/3">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-medium mb-4">Gerenciar Categorias</h3>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="border-b-2 border-gray-200 dark:border-gray-700">
                                            <th class="py-3 px-4 font-bold">Nome</th>
                                            <th class="py-3 px-4 font-bold">Slug</th>
                                            <th class="py-3 px-4 font-bold text-right">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $category)
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <td class="py-4 px-4">{{ $category->name }}</td>
                                                <td class="py-4 px-4 font-mono text-sm">{{ $category->slug }}</td>
                                                <td class="py-4 px-4 text-right">

                                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                        class="text-indigo-600 dark:text-indigo-400 hover:underline">Editar</a>

                                                    <button type="button" @click.prevent="
                                                                showDeleteModal = true; 
                                                                categoryName = '{{ $category->name }}'; 
                                                                deleteAction = '{{ route('admin.categories.destroy', $category->id) }}'
                                                            " class="text-red-600 dark:text-red-400 hover:underline ml-4">
                                                        Excluir
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="py-6 px-4 text-center">
                                                    Nenhuma categoria cadastrada.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div x-show="showDeleteModal" style="display: none;" @keydown.escape.window="showDeleteModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="modal-title">

            <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" @click="showDeleteModal = false"
                class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity">
            </div>

            <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative z-10 w-full max-w-lg overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow-xl transform transition-all">

                <div class="p-6">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100"
                                id="modal-title">
                                Excluir Categoria
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Tem certeza que deseja excluir a categoria <strong x-text="categoryName"></strong>?
                                </p>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    Os produtos que pertencem *apenas* a esta categoria serão movidos para "Sem
                                    Categoria".
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form :action="deleteAction" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3">
                            Sim, Excluir
                        </button>
                    </form>
                    <button type="button" @click="showDeleteModal = false"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-900 sm:mt-0">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>