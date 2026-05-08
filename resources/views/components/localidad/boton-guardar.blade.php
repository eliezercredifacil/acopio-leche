<div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->

    @props([
        'target', // nombre del método livewire
        'texto' => 'Guardar',
        'loadingTexto' => 'Guardando...',
    ])

    <button type="submit"
        {{ $attributes->merge([
            'class' => 'btn btn-sm bg-sky-800 hover:bg-sky-900 text-white w-fit px-3 transition-all duration-200',
        ]) }}
        wire:loading.attr="disabled" wire:loading.class="bg-gray-400 hover:bg-gray-400 cursor-not-allowed"
        wire:loading.class.remove="bg-sky-800 hover:bg-sky-900" wire:target="{{ $target }}">

        <span wire:loading.remove wire:target="{{ $target }}">
            <i class="fa-solid fa-floppy-disk"></i>
            {{ $texto }}
        </span>

        <span wire:loading wire:target="{{ $target }}">
            <span class="loading loading-spinner loading-sm"></span>
            {{ $loadingTexto }}
        </span>

    </button>
</div>
