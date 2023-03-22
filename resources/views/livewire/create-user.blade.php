<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            {{ __('Usuario') }}
        </x-slot>

        <x-slot name="description">
            {{ __('--') }}
        </x-slot>

        <x-slot name="form">
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="name" value="{{ __('Nombre') }}" />
                <small>Nombre completo de la cuenta</small>
                <x-jet-input id="name" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="user.name" />
                <x-jet-input-error for="user.name" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="user.email" />
                <x-jet-input-error for="user.email" class="mt-2" />
            </div>

            @if ($action == "createUser")
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <small>Minimo 8 Carácteres</small>
                <x-jet-input id="password" type="password" class="mt-1 block w-full form-control shadow-none" wire:model.defer="user.password" />
                <x-jet-input-error for="user.password" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="password_confirmation" value="{{ __('Konfirmasi Password') }}" />
                <small>Minimo 8 Carácteres</small>
                <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full form-control shadow-none" wire:model.defer="user.password_confirmation" />
                <x-jet-input-error for="user.password_confirmation" class="mt-2" />
            </div>
            @endif
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __($button['submit_text']) }}
            </x-jet-button>
            <button  onclick="window.location.href='/user'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
        </x-slot>
    </x-jet-form-section>
    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
