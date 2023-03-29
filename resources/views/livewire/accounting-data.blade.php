<x-jet-gilbert submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Accounting Data') }}
    </x-slot>

    <x-slot name="description">
        {{ __('') }}
    </x-slot>

    <x-slot name="form">

<div class="col-span-8 sm:col-span-8"> 
<div class="row">

    <div class="col-md-10">
        <div class="row pb-2">
            <div class="col-md-3">
                <div class="col-span-8 sm:col-span-1">
                    <x-jet-label for="last_name" value="{{ __('Last Name') }}" />
                    <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="last_name" />
                    <x-jet-input-error for="last_name" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-span-8 sm:col-span-1">
                    <x-jet-label for="first_name" value="{{ __('First Name') }}" />
                    <x-jet-input id="first_name" type="text" class="mt-1 block w-full" wire:model.defer="state.first_name" autocomplete="first_name" />
                    <x-jet-input-error for="first_name" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-span-8 sm:col-span-1">
                    <x-jet-label for="middle_name" value="{{ __('Middle Name') }}" />
                    <x-jet-input id="middle_name" type="text" class="mt-1 block w-full" wire:model.defer="state.middle_name" autocomplete="middle_name" />
                    <x-jet-input-error for="last_name" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row pb-2">
            <div class="col-md-3">
                <!-- Employee ID -->
                <div class="col-span-8 sm:col-span-1">
                    <x-jet-label for="employee_id" value="{{ __('Employee ID') }}" />
                    <x-jet-input id="employee_id" type="text" class="mt-1 block w-full" wire:model.defer="state.employee_id" />
                    <x-jet-input-error for="employee_id" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3">
                <!-- Department -->
                <div class="col-span-6 sm:col-span-1">
                    <x-jet-label for="department" value="{{ __('Department') }}" />
                        <select name="department" id="department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                            <option value="">Select Department</option>
                            @foreach($departments as $key=>$department)
                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                    <x-jet-input-error for="department" class="mt-2" />
                    <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
                </div>
            </div>
            <div class="col-md-4">
                <!-- Email -->
                <div class="col-span-8 sm:col-span-1">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
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
