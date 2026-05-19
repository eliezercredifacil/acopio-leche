<div>
    {{-- Because she competes with no one, no one can compete with her. --}}

    <div class="mb-3 relative max-w-sm">
        <input type="date" class="input bg-base-100" wire:model.lazy="fechaReporte" />

        {{-- Spinner global --}}
        <div wire:loading.delay wire:target="fechaReporte">
            <span class="loading loading-spinner loading-md"></span>
        </div>
    </div>



</div>