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
                            <button id="expenseBtn" onclick="setTransactionType('expense')" class="flex items-center justify-center py-3 px-4 rounded-lg bg-red-500 text-white hover:bg-red-600 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                                Despesa
                            </button>
                            <button id="incomeBtn" onclick="setTransactionType('income')" class="flex items-center justify-center py-3 px-4 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors">
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
                                <div class="flex items-center">
                                    <select id="category" name="category"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Selecione uma categoria</option>
                                    </select>
                                    <a type="button" href="#" onclick="openCategoryModal()" class="ms-3 text-indigo-600 hover:text-indigo-700">
                                        + Nova categoria
                                    </a>
                                </div>
                            </div>

                            <button type="submit" id="submitBtn" class="w-full py-3 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
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

    <!-- Modal de Nova Categoria -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full flex items-center justify-center">
        <div class="relative p-6 border w-[500px] max-w-[90vw] shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-xl font-medium text-gray-900 mb-4">Nova Categoria</h3>
                <form id="categoryForm" class="space-y-4">
                    <div>
                        <label for="categoryName" class="block text-base font-medium text-gray-700 mb-1">Nome da Categoria</label>
                        <input type="text" id="categoryName" name="categoryName" 
                            class="mt-1 block w-full px-3 py-2 text-base rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex justify-end space-x-6 mt-4">
                        <button type="button" onclick="closeCategoryModal()" 
                            class="px-4 py-2 text-base bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                            Cancelar
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 text-base bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Salvar
                        </button>
                    </div>
                </form>

                <!-- Tabela de Categorias Existentes -->
                <div class="mt-8">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Categorias Existentes</h4>
                    <div class="overflow-x-auto" style="max-height: 300px; overflow-y: auto;">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nome da Categoria
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Exemplo de linha - Substitua por dados reais -->
                                
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Transporte
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <button onclick="editCategory(2)" class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button onclick="deleteCategory(2)" class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentTransactionType = 'expense';

        function setTransactionType(type) {
            currentTransactionType = type;
            const expenseBtn = document.getElementById('expenseBtn');
            const incomeBtn = document.getElementById('incomeBtn');
            const submitBtn = document.getElementById('submitBtn');

            if (type === 'expense') {
                expenseBtn.classList.remove('bg-gray-200', 'text-gray-700');
                expenseBtn.classList.add('bg-red-500', 'text-white');
                incomeBtn.classList.remove('bg-red-500', 'text-white');
                incomeBtn.classList.add('bg-gray-200', 'text-gray-700');
                submitBtn.textContent = 'Adicionar Despesa';
                submitBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
                submitBtn.classList.add('bg-red-500', 'hover:bg-red-600');
            } else {
                expenseBtn.classList.remove('bg-red-500', 'text-white');
                expenseBtn.classList.add('bg-gray-200', 'text-gray-700');
                incomeBtn.classList.remove('bg-gray-200', 'text-gray-700');
                incomeBtn.classList.add('bg-green-500', 'text-white');
                submitBtn.textContent = 'Adicionar Receita';
                submitBtn.classList.remove('bg-red-500', 'hover:bg-red-600');
                submitBtn.classList.add('bg-green-500', 'hover:bg-green-600');
            }
        }

        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        function editCategory(id) {
            // TODO: Implementar lógica de edição
            console.log('Editando categoria:', id);
        }

        function deleteCategory(id) {
            // TODO: Implementar lógica de exclusão
            if (confirm('Tem certeza que deseja excluir esta categoria?')) {
                console.log('Excluindo categoria:', id);
            }
        }

        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const categoryName = document.getElementById('categoryName').value;
            console.log('Salvando categoria:', { name: categoryName });
            closeCategoryModal();
        });
    </script>
    @endpush
</x-app-layout> 