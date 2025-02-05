<div>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Informacoes do grupo') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Actualize as informacoes do grupo') }}
            </p>
        </header>

        <form wire:submit="salvar" class="mt-6 space-y-6">
            <div>
                <x-input-label for="nome" :value="__('Nome')" />
                <x-text-input wire:model="nome" id="nome" name="nome" type="text" class="mt-1 block w-full"
                    required autofocus autocomplete="nome" />
                <x-input-error class="mt-2" :messages="$errors->get('nome')" />
            </div>

            <div>
                <x-input-label for="saldo_permitido" :value="__('Saldo permitido')" />
                <x-text-input wire:model="saldo_permitido" id="saldo_permitido" name="saldo_permitido" type="number"
                    class="mt-1 block w-full" required autofocus autocomplete="saldo_permitido" />
                <x-input-error class="mt-2" :messages="$errors->get('saldo_permitido')" />
            </div>

            <div>
                <x-input-label for="aprovador_id" :value="__('Selecione o aprovador')" />
                <select wire:model="aprovador_id" id="aprovador_id" name="aprovador_id"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                    <option value="">Selecione um aprovador</option>
                    @foreach ($aprovadores as $aprovador)
                        <option value="{{ $aprovador->id }}">{{ $aprovador->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('aprovador_id')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                <x-secondary-button wire:click="irParaListagem">{{ __('Ir para a Listagem') }}</x-secondary-button>
            </div>
        </form>
    </section>
</div>
