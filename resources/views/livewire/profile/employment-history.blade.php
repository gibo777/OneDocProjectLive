<x-jet-gilbert submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Accounting Data') }}
    </x-slot>

    <x-slot name="description">
        {{ __('') }}
    </x-slot>

    <x-slot name="form">

<div class="col-span-12 sm:col-span-8"> 
        <div class="row pb-2">
                <div class="col-md-8 p-1">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="dependent_name1" type="text" class="form-control block w-full" wire:model.defer="state.dependent1" autocomplete="off" placeholder="Dependent"/>
                        <x-jet-label for="dependent_name1" value="{{ __('Dependent 1') }}" />
                        <x-jet-input-error for="dependent_name1" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-3 p-1">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="dependent_birthdate1" type="text" class="form-control datepicker block w-full" wire:model.defer="state.dependent_birthdate1" placeholder="mm/dd/yyyy"/>
                        <x-jet-label for="dependent_birthdate1" value="{{ __('Birthdate') }}" />
                        <x-jet-input-error for="dependent_birthdate1" class="mt-2" />
                    </div>
                </div>
                <div class="d-flex justify-content-center col-md-1 p-3">
                    <i name="btnDependents[]" class="btnDependents d-flex justify-content-center fa fa-solid fa-plus btn btn-success btn-success-3d" data-bs-toggle="tooltip" title="Add dependent"></i>
                </div>
        </div>
</div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-gilbert>
