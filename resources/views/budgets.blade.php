<x-app-layout>
    <div class="flex h-screen bg-gray-800">
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.header')

            <!-- Budgets Content -->
            <main class="p-6 bg-gray-100">
                <!-- Header com Seletor de Mês -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Orçamentos Mensais</h2>
                    <form action="{{ route('budgets.index') }}" method="GET">
                        <select name="month_year" onchange="this.form.submit()"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach ($availableMonths as $monthYear => $monthName)
                                <option value="{{ $monthYear }}" {{ ($monthYear == $selectedMonthYear) ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Cards de Resumo -->
                <div class="grid grid-cols-1 gap-6 mb-12 lg:grid-cols-3">
                    <!-- Orçamento Total -->
                    <div class="p-6 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Orçamento Total</h3>
                                <p class="text-2xl font-bold text-blue-600">R$ {{ number_format($totalBudgetAmount, 2, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst(Carbon\Carbon::parse($selectedMonthYear)->isoFormat('MMMM [de] YYYY')) }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Gasto Atual -->
                    <div class="p-6 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Gasto Atual</h3>
                                <p class="text-2xl font-bold text-purple-600">R$ {{ number_format($currentSpendAmount, 2, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">
                                    @if($totalBudgetAmount > 0)
                                        {{ number_format(($currentSpendAmount / $totalBudgetAmount) * 100, 2) }}%
                                    @else
                                        0%
                                    @endif
                                    do orçamento utilizado
                                </p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-full">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Categorias Excedidas -->
                    <div class="p-6 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Categorias Excedidas</h3>
                                <p class="text-2xl font-bold text-green-600">{{ $exceededCategoriesCount }}</p>
                                <p class="text-sm text-gray-500">
                                    @if($exceededCategoriesCount === 0)
                                        Todos os orçamentos estão dentro do limite
                                    @else
                                        Categoria(s) excedida(s): {{ implode(', ', $exceededCategoriesNames) }}
                                    @endif
                                </p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Definir Novo Orçamento -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Definir Novo Orçamento</h3>
                        <form action="{{ route('budgets.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="budget_category" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                                <select id="budget_category" name="category"
                                    class="w-full px-3 py-2 mb-6 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Selecione uma categoria</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->desc}}</option>
                                        @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="budget_limit" class="block text-sm font-medium text-gray-700 mb-1">Valor Limite (R$)</label>
                                <input type="number" step="0.01" id="budget_limit" name="limit" placeholder="0.00"
                                    class="w-full px-3 py-2 mb-6 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="budget_month" class="block text-sm font-medium text-gray-700 mb-1">Mês</label>
                                <input type="month" id="budget_month" name="month"
                                    class="w-full px-3 py-2 mb-6 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="budget_notes" class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                                <textarea id="budget_notes" name="notes" rows="3" placeholder="Observações sobre este orçamento (opcional)"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>

                            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Definir Orçamento
                            </button>
                        </form>
                    </div>

                    <!-- Orçamentos Atuais -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Orçamentos Atuais</h3>
                        @if($budgets->isEmpty())
                            <div class="text-gray-500 text-center py-8">
                                Nenhum orçamento definido para este mês.
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Categoria
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Limite
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Observações
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($budgets as $budget)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $budget->category->desc }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    R$ {{ number_format($budget->limit, 2, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900">
                                                    {{ $budget->obs }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir este orçamento?')">
                                                            Excluir
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout> 