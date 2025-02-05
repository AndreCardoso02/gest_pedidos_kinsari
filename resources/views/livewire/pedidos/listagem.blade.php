<div>
    <!-- Cria duas colunas uma para o texto e outra para o botao de adicionar -->
    <div class="flex justify-between">
        <div class="mb-4">
            <h2 class="text-2xl font-semibold leading-tight">Pedidos</h2>
            <h3>Lista de todos os pedidos</h3>
        </div>

        @if (auth()->user()->hasRole('solicitante'))
            <a href="{{ route('pedidos.create') }}"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500">Adicionar</a>
        @endif
    </div>
    <div>
        <div class="not-prose isolate">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Solicitante
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Grupo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pedidos as $pedido)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $pedido->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $pedido->solicitante->nome }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $pedido->grupo->nome }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $pedido->total }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $pedido->data_criacao }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $pedido->status }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (auth()->user()->hasRole('aprovador'))
                                        @livewire('pedidos.aprovar-pedido-modal', ['pedido' => $pedido], key($pedido->id))
                                        @livewire('pedidos.rejeitar-pedido-modal', ['pedido' => $pedido], key($pedido->id))
                                        @livewire('pedidos.solicitar-alteracao-pedido-modal', ['pedido' => $pedido], key($pedido->id))
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap" colspan="6">
                                    {{ __('Sem pedidos encontrados') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
