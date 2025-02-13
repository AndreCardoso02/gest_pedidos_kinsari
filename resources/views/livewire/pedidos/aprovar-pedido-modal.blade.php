<div>
    <!-- Botao para abrir o modal -->
    <x-primary-button class="ms-3" wire:click="abrirModal">
        {{ __('Aprovar') }}
    </x-primary-button>

    <!-- Modal -->
    @if ($mostarModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
            <div class="relative w-auto max-w-3xl mx-auto my-6">
                <!--content-->
                <div
                    class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none">
                    <!--header-->
                    <div
                        class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200">
                        <h3 class="text-3xl font-semibold">
                            Aprovar Pedido
                        </h3>
                        <button wire:click="fecharModal"
                            class="p-1 ml-auto bg-transparent border-0 text-black float-right text-3xl leading-none font-semibold outline-none focus:outline-none">
                            <span
                                class="bg-transparent text-black h-6 w-6 text-2xl block outline-none focus:outline-none">
                                ×
                            </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="relative p-6 flex-auto">
                        <p class="my-4 text-blueGray-500 text-lg leading-relaxed">
                            Deseja realmente aprovar o pedido no valor de <b>{{ $pedido->total }}</b>?
                        </p>
                        <small class="text-red-500">O grupo tem um saldo limite de
                            <b>{{ $pedido->grupo->saldo_permitido }}</b>.</small>
                    </div>
                    <!--footer-->
                    <div class="flex items *:start justify-end p-6 border-t border-solid rounded-b border-blueGray-200">
                        <button wire:click="fecharModal"
                            class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1"
                            type="button">
                            Cancelar
                        </button>
                        <button wire:click="aprovarPedido"
                            class="bg-green-500 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1"
                            type="button">
                            Aprovar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed inset-0 z-40 bg-black opacity-25"></div>
    @endif
    <!-- Fechar a modal -->
</div>
