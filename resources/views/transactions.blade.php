<x-app-layout>
    <div class="flex h-screen bg-gray-800">
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.header')

            <!-- Transactions Content -->
            <main class="p-6 bg-gray-100">
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Adicionar Transação</h2>
                    
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <!-- Tipo de Transação -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <button class="flex items-center justify-center py-3 px-4 rounded-lg bg-red-500 text-white hover:bg-red-600 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                                Despesa
                            </button>
                            <button class="flex items-center justify-center py-3 px-4 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Receita
                            </button>
                        </div>

                        <!-- Formulário -->
                        <form class="space-y-4">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                                <input type="text" id="description" name="description" placeholder="Ex: Supermercado, Salário, etc." 
                                    class="w-full px-3 py-2 mb-6 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Valor (R$)</label>
                                <input type="number" step="0.01" id="amount" name="amount" placeholder="0.00"
                                    class="w-full px-3 py-2 mb-6 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Data</label>
                                <input type="date" id="date" name="date"
                                    class="w-full px-3 py-2 mb-6 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                                <div class="flex">
                                    <select id="category" name="category"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Selecione uma categoria</option>
                                    </select>
                                    <button type="button" class="ms-3 text-indigo-600 hover:text-indigo-700">
                                        + Nova categoria
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-3 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                Adicionar Despesa
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Histórico de Transações -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Histórico de Transações</h2>
                    
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <!-- Barra de Pesquisa e Filtros -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex-1 max-w-md">
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </span>
                                    <input type="text" placeholder="    Buscar transações..." 
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4 ml-4">
                                <select class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option>Todos</option>
                                    <option>Receitas</option>
                                    <option>Despesas</option>
                                </select>
                                
                                <select class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option>Data (mais recente)</option>
                                    <option>Data (mais antiga)</option>
                                    <option>Valor (maior)</option>
                                    <option>Valor (menor)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Lista de Transações -->
                        <div class="text-gray-500 text-center py-8">
                            Nenhuma transação encontrada.
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout> 