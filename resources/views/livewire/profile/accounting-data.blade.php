<x-jet-personnel-component>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<form id="accountingDataForm">
@csrf

<div class="col-span-12 sm:col-span-12 mx-2"> 
        <div class="row py-2">
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="sss_number" name="sss_number" type="text" 
                    class="form-control block w-full" 
                    placeholder="SSS Number" 
                    autocomplete="off" />
                    <x-jet-label for="sss_number" value="{{ __('SSS Number') }}" />
                    <x-jet-input-error for="sss_number" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="phic_number" name="phic_number" type="text" 
                    class="form-control block w-full" 
                    placeholder="PHIC Number" 
                    autocomplete="off" />
                    <x-jet-label for="phic_number" value="{{ __('PHIC Number') }}" />
                    <x-jet-input-error for="phic_number" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="pagibig_number" name="pagibig_number" type="text" 
                    class="form-control block w-full" 
                    placeholder="PAG-IBIG Number" 
                    autocomplete="off" />
                    <x-jet-label for="pagibig_number" value="{{ __('PAG-IBIG Number') }}" />
                    <x-jet-input-error for="pagibig_number" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="tin_number" name="tin_number" type="text" class="form-control block w-full" placeholder="TIN Number" autocomplete="off" />
                    <x-jet-label for="tin_number" value="{{ __('TIN Number') }}" />
                    <x-jet-input-error for="tin_number" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row pb-2">
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                <!-- Tax Status -->
                    <select name="tax_status" id="tax_status" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full"
                    >
                        <option value="">Select Tax Status</option>
                        @foreach ($tax_statuses as  $tax_status)
                        <option value="{{ $tax_status->tax_status_code }}">{{ $tax_status->tax_status_description }}</option>
                        @endforeach
                    </select>
                    <x-jet-label for="tax_status" value="{{ __('Tax Status') }}" />
                    <x-jet-input-error for="tax_status" class="mt-2" />
                </div>
            </div>

            <div class="col-md-9 dependents" id="dependents">
                <div class="row dependents">
                    <div class="col-md-8 p-1">
                        <div class="form-floating col-span-8 sm:col-span-1">
                            <x-jet-input id="dependent_name1" type="text" class="form-control block w-full" autocomplete="off" placeholder="Dependent"/>
                            <x-jet-label for="dependent_name1" value="{{ __('Dependent 1') }}" />
                            <x-jet-input-error for="dependent_name1" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-3 p-1">
                        <div class="form-floating col-span-8 sm:col-span-1">
                            <x-jet-input id="dependent_birthdate1" type="text" class="form-control datepicker block w-full" placeholder="mm/dd/yyyy"/>
                            <x-jet-label for="dependent_birthdate1" value="{{ __('Birthdate') }}" />
                            <x-jet-input-error for="dependent_birthdate1" class="mt-2" />
                        </div>
                    </div>
                    <div class="d-flex justify-content-center col-md-1 p-3">
                        <i name="btnDependents[]" class="btnDependents d-flex justify-content-center fa fa-solid fa-plus btn btn-success btn-success-3d" data-bs-toggle="tooltip" title="Add dependent"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-md-6 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="health_card_number" type="text" class="form-control block w-full" placeholder="Health Card Number" autocomplete="off" />
                    <x-jet-label for="health_card_number" value="{{ __('Health Card Number') }}" />
                    <x-jet-input-error for="health_card_number" class="mt-2" />
                </div>
            </div>
            <div class="col-md-6 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="drivers_license" type="text" class="form-control block w-full" placeholder="Driver's License" autocomplete="off" />
                    <x-jet-label for="drivers_license" value="Driver's License" />
                    <x-jet-input-error for="drivers_license" class="mt-2" />
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-md-5 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="passport_number" type="text" class="form-control block w-full" placeholder="Passport Number" autocomplete="off" />
                    <x-jet-label for="passport_number" value="{{ __('Passport Number') }}" />
                    <x-jet-input-error for="passport_number" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="drivers_license" type="text" class="form-control datepicker block w-full" placeholder="mm/dd/yyyy" autocomplete="drivers_license" />
                    <x-jet-label for="drivers_license" value="{{ __('Expiration Date:') }}" />
                    <x-jet-input-error for="drivers_license" class="mt-2" />
                </div>
            </div>
            <div class="col-md-4 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="drivers_license" type="text" class="form-control block w-full" placeholder="PRC" autocomplete="drivers_license" />
                    <x-jet-label for="drivers_license" value="{{ __('PRC') }}" />
                    <x-jet-input-error for="drivers_license" class="mt-2" />
                </div>
            </div>
        </div>

    <div class="flex items-center justify-center px-2 py-2 text-right sm:px-3  sm:rounded-bl-md sm:rounded-br-md">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button id="submitAccountingData">
            {{ __('Save') }}
        </x-jet-button>
    </div>

</div>


</form>
</x-jet-personnel-component>
