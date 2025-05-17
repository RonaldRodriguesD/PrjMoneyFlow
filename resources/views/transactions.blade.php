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
                            <button id="incomeBtn" onclick="setTransactionType('income')" class="flex items-center justify-center py-3 px-4 rounded-lg bg-gray-200 text-gray-700 hover:bg-green-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Receita
                            </button>
                        </div>

                        <!-- Formulário -->
                        <form class="space-y-4" action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('POST')
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
                                <div class="flex items-center mb-4">
                                    <select id="category" name="category"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Selecione uma categoria...</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->desc}}</option>
                                        @endforeach
                                    </select>
                                    <a type="button" href="#" onclick="openCategoryModal()" class="ms-3 text-indigo-600 hover:text-indigo-700">
                                        + Nova categoria
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="{{true}}" name="recurrent" id="recurrentCheck" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-700">Recorrente</span>
                                </label>

                                <select id="recurrenceMonths" name="recurrenceMonths" disabled class="w-48 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Selecione os meses...</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'mês' : 'meses' }}</option>
                                    @endfor
                                </select>
                            </div>

                            <input type="hidden" id="transactionType" name="transactionType" value="expense">

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
                                @php
                                    $currentMonth = request('month', now()->format('m'));
                                    $currentYear = request('year', now()->format('Y'));

                                    $meses = [
                                        '01' => 'Janeiro',
                                        '02' => 'Fevereiro',
                                        '03' => 'Março',
                                        '04' => 'Abril',
                                        '05' => 'Maio',
                                        '06' => 'Junho',
                                        '07' => 'Julho',
                                        '08' => 'Agosto',
                                        '09' => 'Setembro',
                                        '10' => 'Outubro',
                                        '11' => 'Novembro',
                                        '12' => 'Dezembro',
                                    ];
                                @endphp
                                <form method="GET" action="{{ route('transactions.create') }}" class="flex items-center space-x-4 ml-4">
                                    <select name="month" onchange="this.form.submit()" class="px-3 py-2 border rounded-md">
                                        @foreach ($meses as $numero => $nome)
                                            <option value="{{ $numero }}" {{ $currentMonth == $numero ? 'selected' : '' }}>
                                                {{ $nome }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="year" onchange="this.form.submit()" class="px-3 py-2 border rounded-md">
                                        @for ($y = now()->year + 5; $y >= now()->year - 5; $y--)
                                            <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>

                                    <select name="type" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Todos</option>
                                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Receitas</option>
                                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Despesas</option>
                                    </select>

                                    <select name="sort" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Data (mais antiga)</option>
                                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Data (mais recente)</option>
                                        <option value="higher" {{ request('sort') == 'higher' ? 'selected' : '' }}>Valor (maior)</option>
                                        <option value="lower" {{ request('sort') == 'lower' ? 'selected' : '' }}>Valor (menor)</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <!-- Lista de Transações -->
                        <div class="text-gray-500 text-center py-8">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Descrição
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Categoria
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Valor
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Data
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ação
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($transactions as $transaction)
                                    <tr>
                                        @if($transaction->type == "expense")
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-500">
                                                {{$transaction->desc}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-500">
                                                {{$transaction->category->desc ?? 'Não encontrada'}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-500">
                                                {{$transaction->value}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-500">
                                                {{$transaction->date}}
                                            </td>
                                            <td class="flex flex-row justify-center px-6 py-4 whitespace-nowrap text-sm text-red-500">
                                                <form action="/transactions/{{$transaction->id}}" id="deleteTransaction-{{$transaction->id}}" method="POST">
                                                    @csrf
                                                    @method("delete")
                                                    <button form="deleteTransaction-{{$transaction->id}}" class="text-red-600 mr-2 hover:text-red-900" type="submit" onclick="if(confirm('Deseja realmente excluir esta transação?')){ }else{return false;}">
                                                        <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>

                                                <form action="{{ route('transactions.edit', $transaction->id)}}" id="updateTransaction-{{$transaction->id}}">
                                                    @csrf
                                                    <button form="updateTransaction-{{$transaction->id}}" class="text-indigo-600 ml-2 hover:text-indigo-900" type="submit">
                                                        <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        @else
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{$transaction->desc}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{$transaction->category->desc ?? 'Não encontrada'}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{$transaction->value}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{$transaction->date}}
                                        </td>
                                        <td class="flex flex-row justify-center px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <form action="/transactions/{{$transaction->id}}" id="deleteTransaction-{{$transaction->id}}" method="POST">
                                                @csrf
                                                @method("delete")
                                                <button form="deleteTransaction-{{$transaction->id}}" class="text-red-600 mr-2 hover:text-red-900" type="submit" onclick="if(confirm('Deseja realmente excluir esta transação?')){ }else{return false;}">
                                                    <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>

                                            <form action="{{ route('transactions.edit', $transaction->id)}}" id="updateTransaction-{{$transaction->id}}">
                                                @csrf
                                                <button form="updateTransaction-{{$transaction->id}}" class="text-indigo-600 ml-2 hover:text-indigo-900" type="submit">
                                                    <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                <form id="categoryForm" action="{{isset($editCategory) ? route('categories.update', $editCategory->id) : route('categories.store')}}" method="POST" class="space-y-4">
                    @csrf
                    @if(isset($editCategory))
                        @method('PUT')
                    @endif
                    <div>
                        <label for="categoryDesc" class="block text-base font-medium text-gray-700 mb-1">Nome da Categoria</label>
                        <input type="text" id="categoryDesc" name="categoryDesc" value="{{ $editCategory->desc ?? '' }}" required
                            class="mt-1 block w-full px-3 py-2 text-base rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex justify-end space-x-6 mt-4">
                        <button type="button" onclick="closeCategoryModal()" 
                            class="px-4 py-2 text-base bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                            Cancelar
                        </button>
                        <input type="submit" class="px-4 py-2 text-base bg-indigo-600 text-white rounded-md hover:bg-indigo-700" value="Salvar">
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
                                @foreach($categories as $category)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{$category->desc}}
                                    </td>
                                    <td class="flex flex-row justify-end px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">

                                        <form action="/categories/{{$category->id}}" id="deleteCategory-{{$category->id}}" method="POST">
                                            @csrf
                                            @method("delete")
                                            <button form="deleteCategory-{{$category->id}}" class="text-red-600 hover:text-red-900" type="submit" onclick="if(confirm('Deseja realmente excluir esta categoria?')){ }else{return false;}">
                                                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>

                                        <form action="{{ route('categories.edit', $category->id)}}" id="updateCategory-{{$category->id}}">
                                            @csrf
                                            <button form="updateCategory-{{$category->id}}" class="text-indigo-600 hover:text-indigo-900" type="submit">
                                                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @if(session('openCategoryModal') || isset($editCategory))
    <script>
        window.onload = function() {
            document.getElementById('categoryModal').classList.remove('hidden');
        };
    </script>
    @endif

    <script>
        let currentTransactionType = 'expense';

        // Adiciona o evento para controlar a visibilidade do combobox de recorrência
        document.getElementById('recurrentCheck').addEventListener('change', function() {
            const recurrenceSelect = document.getElementById('recurrenceMonths');
            recurrenceSelect.disabled = !this.checked;
            if (!this.checked) {
                recurrenceSelect.value = '';
            }
        });

        function setTransactionType(type) {
            currentTransactionType = type;
            document.getElementById('transactionType').value = type;
            const expenseBtn = document.getElementById('expenseBtn');
            const incomeBtn = document.getElementById('incomeBtn');
            const submitBtn = document.getElementById('submitBtn');

            if (type === 'expense') {                
                incomeBtn.classList.remove('bg-green-500', 'text-white');
                
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
            document.getElementById('categoryDesc').value = '';
        }


        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            // e.preventDefault();
            const categoryName = document.getElementById('categoryName').value;
            console.log('Salvando categoria:', { name: categoryName });
            closeCategoryModal();
        });
    </script>
    @endpush
</x-app-layout> 