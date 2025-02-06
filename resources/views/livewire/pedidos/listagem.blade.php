<div>
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Cria duas colunas uma para o texto e outra para o botao de adicionar -->
    <div class="flex justify-between">
        <div class="mb-4">
            <h3>Lista de todos os pedidos</h3>
        </div>

        @if (auth()->user()->isSolicitante())
            <a href="{{ route('pedidos.create') }}"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500">Adicionar</a>
        @endif
    </div>
    <br />
    <div>
        <div class="not-prose isolate">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
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
                                    <div class="text-sm text-gray-900">{{ $pedido->solicitante->name }}</div>
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
                                    <div class="text-sm text-gray-900">
                                        @if ($pedido->status->value == 'novo')
                                            <span
                                                class="bg-gray-500 text-white text-xs font-semibold px-2 py-1 rounded-full">novo</span>
                                        @elseif ($pedido->status->value === 'aprovado')
                                            <span
                                                class="bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full">aprovado</span>
                                        @elseif ($pedido->status->value === 'rejeitado')
                                            <span
                                                class="bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">rejeitado</span>
                                        @elseif ($pedido->status->value === 'alteracoes_solicitadas')
                                            <span
                                                class="bg-yellow-500 text-black text-xs font-semibold px-2 py-1 rounded-full">solicitando
                                                alteração</span>
                                        @else
                                            <span
                                                class="bg-gray-300 text-black text-xs font-semibold px-2 py-1 rounded-full">status
                                                indefinido</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap flex flex-row">
                                    @if (auth()->user()->isAprovador())
                                        @if ($pedido->status->value !== 'aprovado')
                                            @livewire('pedidos.aprovar-pedido-modal', ['pedido' => $pedido], key($pedido->id))
                                        @endif
                                        @if ($pedido->status->value !== 'rejeitado')
                                            @livewire('pedidos.rejeitar-pedido-modal', ['pedido' => $pedido], key($pedido->id))
                                        @endif
                                        @if ($pedido->status->value !== 'alteracoes_solicitadas')
                                            @livewire('pedidos.solicitar-alteracao-pedido-modal', ['pedido' => $pedido], key($pedido->id))
                                        @endif
                                    @elseif (auth()->user()->isSolicitante())
                                        @if ($pedido->status->value === 'alteracoes_solicitadas')
                                            <x-primary-button class="ms-3" wire:click="editar({{ $pedido->id }})">
                                                {{ __('Editar') }}
                                            </x-primary-button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap" colspan="7" align="center">
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
