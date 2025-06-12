<x-app-layout>
    <div class="flex h-screen bg-gray-800">
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.header')

            <!-- Dashboard Content -->
            <main class="p-6 h-full bg-gray-100">
                <!-- Cards de Resumo -->
                <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-3">
                    <!-- Card Receitas -->
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-normal text-gray-500">Receitas</h3>
                                <p class="text-2xl font-semibold text-green-600">R$ {{number_format($totalIncome, 2, ',','.')}}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Card Despesas -->
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-normal text-gray-500">Despesas</h3>
                                <p class="text-2xl font-semibold text-red-600">R$ {{number_format($totalExpense, 2, ',','.')}}</p>
                            </div>
                            <div class="p-3 bg-red-100 rounded-full">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Card Saldo -->
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-normal text-gray-500">Saldo</h3>
                                <p class="text-2xl font-semibold text-blue-600">R$ {{number_format($balance, 2, ',','.')}}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Evolução Mensal -->
                <div class="p-4 mb-6 bg-white rounded-lg shadow-sm">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Evolução Mensal</h3>
                    <div class="h-64">
                        <canvas id="evolucaoMensal"></canvas>
                    </div>
                </div>

                <!-- Cards Inferiores -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Principais Categorias de Despesas -->
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Principais Categorias de Despesas</h3>
                        <div class="text-gray-500">
                            Sem dados para exibir.
                        </div>
                    </div>

                    <!-- Fontes de Receita -->
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Fontes de Receita</h3>
                        <div class="text-gray-500">
                            Sem dados para exibir.
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        const labels = @json($labels);
        const incomeData = @json($incomes);
        const expenseData = @json($expenses);
    </script>
</x-app-layout>
