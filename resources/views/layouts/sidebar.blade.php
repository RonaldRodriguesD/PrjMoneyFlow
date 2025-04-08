<!-- Sidebar -->
<div class="w-64 bg-gray-900 text-white flex flex-col h-full">
    <!-- Título -->
    <div class="p-4">
        <div class="flex items-center justify-center">
            <span class="text-xl font-bold">MoneyFlow</span>
        </div>
    </div>

    <!-- Menu de Navegação -->
    <nav class="flex-1">
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('transactions') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('transactions') ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Transações
        </a>
        <a href="{{ route('budgets') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('budgets') ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Orçamentos
        </a>
    </nav>

    <!-- Logo na parte inferior -->
    <div class="p-4">
        <div class="flex items-center justify-center">
            <x-application-logo class="block h-7 w-auto" />
        </div>
    </div>
</div> 