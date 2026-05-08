<div>
    {{-- Do your work, then step back. --}}
    <form wire:submit.prevent="EditarProductorSuccess">

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4">
            <legend class="fieldset-legend">Editar Productor</legend>

            <x-productor.alerts type="success" :message="session('status')" />

            <x-productor.alerts type="info" :message="session('info')" />

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div>
                    <label class="label">Nombre</label>
                    <input type="text" class="input bg-base-100" placeholder="Nombre" wire:model="nombre" />
                    @error('nombre')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label">Cédula</label>
                    <input type="text" class="input bg-base-100" placeholder="Cédula" wire:model="cedula" />
                    @error('cedula')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label">Telefono</label>
                    <input type="number" class="input bg-base-100" placeholder="Telefono" wire:model="telefono" />
                    @error('telefono')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label">Comarca</label>
                    <select class="select bg-base-100 appearance-none" wire:model="localidad_id">
                        <option value="">Seleccionar Comarca</option>
                        @foreach ($this->localidades as $localidad)
                            <option value="{{ $localidad->id }}">{{ $localidad->nombre }}</option>
                        @endforeach
                    </select>
                    @error('localidad_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label">Seleccione semana de entrega</label>
                    <select class="select bg-base-100 appearance-none" wire:model="semana">
                        <option value="">Seleccione semana</option>
                        <option value="A">Domingo a Sábado</option>
                        <option value="B">Viernes a Jueves</option>
                    </select>
                    @error('semana')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label">Dirección</label>
                    <textarea class="textarea bg-base-100" placeholder="direccion" wire:model="direccion" rows="4"></textarea>
                    @error('direccion')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div>
                <div class="divider"></div>
                <x-localidad.boton-guardar target="EditarProductorSuccess" texto="Actualizar" />
            </div>

        </fieldset>

    </form>

</div>
