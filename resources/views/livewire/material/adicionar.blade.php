<div>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Informacoes do material') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Adicione um novo material') }}
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
                <x-input-label for="preco" :value="__('Preco')" />
                <x-text-input wire:model="preco" id="preco" name="preco" type="number" class="mt-1 block w-full"
                    required autofocus autocomplete="preco" />
                <x-input-error class="mt-2" :messages="$errors->get('preco')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                <x-secondary-button wire:click="irParaListagem">{{ __('Ir para a Listagem') }}</x-secondary-button>
            </div>
        </form>
    </section>
</div>
