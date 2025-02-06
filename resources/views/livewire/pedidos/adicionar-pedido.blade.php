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

    {{-- Lista de materiais --}}
    <div class="flex justify-between">
        <div class="mb-4">
            {{-- Dropdown para selecionar um grupo --}}
            <x-input-label for="grupo_id" :value="__('Selecione o grupo')" />
            <select wire:model="grupo_id" id="grupo_id" name="grupo_id"
                class="w-48 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecione um grupo</option>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('grupo_id')" />
        </div>

        <div class="flex space-x-4">
            <button wire:click="adicionarPedido"
                class="px-4 py-2 text-sm h-11 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500">Adicionar</button>

            {{-- Botão de contagem de itens --}}
            <button wire:click="abrirModal"
                class="px-4 py-2 text-sm h-11 font-medium text-white bg-gray-600 rounded-md hover:bg-gray-500">
                <span class="font-bold">Total de itens <b>[ {{ $totalItens }} ]</b> </span>
            </button>
        </div>
    </div>
    <br />
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Material
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantidade
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($materiais as $material)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $material->nome }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" wire:model="quantidades.{{ $material->id }}"
                                            class="w-20 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="adicionarMaterial({{ $material->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">Adicionar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($mostrarModal)
        <!-- Modal -->
        <div class="fixed inset-0 z-40 bg-black bg-opacity-50"></div> <!-- Backdrop escuro -->
        <div
            class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
            <div class="relative w-auto max-w-3xl mx-auto my-6">
                <!--content-->
                <div
                    class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none">
                    <!--header-->
                    <div
                        class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200">
                        <h3 class="text-xl">
                            Itens adicionados ao Pedido
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
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($materiaisAdicionados as $item)
                                <div class="p-4 bg-white border border-gray-200 shadow-md rounded-xl">
                                    <h2 class="text-lg font-semibold text-gray-800">
                                        {{ $materiais[$item['material_id']]->nome }}</h2>
                                    <p class="text-sm text-gray-600">Quantidade: <span
                                            class="font-bold">{{ $item['quantidade'] }}</span></p>
                                    <p class="text-sm text-gray-600">Preço Unitário: <span class="font-bold">Kz
                                            {{ number_format($item['preco'], 2) }}</span></p>
                                    <p class="text-sm text-gray-700 mt-2 border-t pt-2">
                                        <span class="font-semibold">Preço Total: </span>
                                        <span class="text-blue-600 font-bold">Kz
                                            {{ number_format($item['quantidade'] * $item['preco'], 2) }}</span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items *:start justify-end p-6 border-t border-solid rounded-b border-blueGray-200">
                        <button wire:click="fecharModal"
                            class="text-black-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1"
                            type="button">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
