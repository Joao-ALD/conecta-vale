<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Painel do Administrador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Card de Usuários -->
                <a href="{{ route('admin.users.index') }}" class="block p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Usuários</h3>
                    <p class="mt-2 text-3xl font-bold text-vale-primary">{{ $stats['users'] }}</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Total de usuários registrados.</p>
                </a>

                <!-- Card de Produtos -->
                <a href="{{ route('admin.products.index') }}" class="block p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Produtos</h3>
                    <p class="mt-2 text-3xl font-bold text-vale-primary">{{ $stats['products'] }}</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Total de produtos cadastrados.</p>
                </a>

                <!-- Card de Categorias -->
                <a href="{{ route('admin.categories.index') }}" class="block p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Categorias</h3>
                    <p class="mt-2 text-3xl font-bold text-vale-primary">{{ $stats['categories'] }}</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gerenciar categorias.</p>
                </a>

                <!-- Card de Planos -->
                <a href="{{ route('admin.plans.index') }}" class="block p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Planos</h3>
                    <p class="mt-2 text-3xl font-bold text-vale-primary">{{ $stats['plans'] }}</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gerenciar planos de assinatura.</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
