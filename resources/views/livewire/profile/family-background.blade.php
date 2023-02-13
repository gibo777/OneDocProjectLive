<x-jet-gilbert submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Family Background') }}
    </x-slot>

    <x-slot name="description">
        {{ __('') }}
    </x-slot>

    <x-slot name="form">

<div id="familyBgContainer" class="col-span-8 sm:col-span-8"> 
    <!-- SPOUSE -->
    
    <div class="beneficiary-form row form-group border bg-light">
        <div class="col-md-12">
            <div class="float-right d-flex justify-content-center col-md-1 p-3">
                <i id="addDependents" name="btnDependents[]" class="d-flex justify-content-center fa fa-solid fa-plus btn btn-success btn-success-3d" data-bs-toggle="tooltip" title="Add dependent"></i>
            </div>
            <div class="row py-2">
                <div class="col-md-6">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="last_name" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="last_name" placeholder="Name"/>
                        <x-jet-label for="last_name" value="{{ __('Name:') }}" />
                        <x-jet-input-error for="last_name" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="birthDate" type="text" class="form-control datepicker mt-1 block w-full" wire:model.defer="state.birthdate" placeholder="mm/dd/yyyy" autocomplete="off" />
                        <x-jet-label for="birthDate" value="{{ __('Birth Date:') }}" />
                        <x-jet-input-error for="birthDate" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-floating col-span-6 sm:col-span-2 w-full">
                        <select id="relationship" name="relationship" 
                            class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" 
                            placeholder="Relationship" style="width: 100%; height: 100%;">
                            <option id="relationshipOption" value="">-Select Relationship-</option>
                            <option >Spouse</option>
                            <option >Mother</option>
                            <option >Father</option>
                            <option >Guardian</option>
                        </select>
                        <x-jet-label for="relationship" value="{{ __('Relationship') }}" />
                        <x-jet-input-error for="relationship" class="mt-2" />
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <div class="col-span-8 sm:col-span-1">
                        <x-jet-label for="last_name" value="{{ __('Landline:') }}" />
                        <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="last_name" />
                        <x-jet-input-error for="last_name" class="mt-2" />
                    </div>
                </div> --}}
            </div>


            <div class="row pb-2">
                <div class="col-md-9">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="residence_address" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Residence Address" />
                        <x-jet-label for="residence_address" value="{{ __('Residence Address:') }}" />
                        <x-jet-input-error for="residence_address" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="contact_number" type="text" class="form-control t-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Contact Number"/>
                        <x-jet-label for="contact_number" value="{{ __('Contact Number:') }}" />
                        <x-jet-input-error for="contact_number" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="row pb-2">
                <div class="col-md-3">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="occupation" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Occupation"/>
                        <x-jet-label for="occupation" value="{{ __('Occupation:') }}" />
                        <x-jet-input-error for="occupation" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="company_name" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Company Name"/>
                        <x-jet-label for="company_name" value="{{ __('Company Name:') }}" />
                        <x-jet-input-error for="company_name" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="company_address" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Company Address" />
                        <x-jet-label for="company_address" value="{{ __('Company Address:') }}" />
                        <x-jet-input-error for="company_address" class="mt-2" />
                    </div>
                </div>
            </div>
            <!-- <hr/> -->
            <div class="row pb-2">
                <div class="col-md-2">
                    <div class="col-span-6 sm:col-span-1">
                        <x-jet-input name="spouse_tax_dependent" type="checkbox"/>{{ __('Tax Dependent') }}
                        <x-jet-input-error for="department" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="col-span-6 sm:col-span-1">
                        <x-jet-input name="spouse_sss_beneficiary" type="checkbox"/>{{ __('SSS Beneficiary') }}
                        <x-jet-input-error for="department" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-span-6 sm:col-span-1">
                        <x-jet-input name="spouse_phic_beneficiary" type="checkbox"/>{{ __('PHIC Beneficiary') }}
                        <x-jet-input-error for="department" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-span-6 sm:col-span-1">
                        <x-jet-input name="spouse_phic_beneficiary" type="checkbox"/>{{ __('Can be Notifiied in Case of Emergency') }}
                        <x-jet-input-error for="department" class="mt-2" />
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- <!-- PARENTS -->
    <div class="row form-group border bg-light">
        <div class="col-md-12">
            <div class="row py-2">
                <div class="col-md-4">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="last_name" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Father's Name" />
                        <x-jet-label for="last_name" value="Father's Name:" />
                        <x-jet-input-error for="last_name" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="last_name" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Mother's Name" />
                        <x-jet-label for="last_name" value="Mother's Name:" />
                        <x-jet-input-error for="last_name" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating col-span-8 sm:col-span-1">
                        <x-jet-input id="last_name" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="" />
                        <x-jet-label for="last_name" value="{{ __('Landline:') }}" />
                        <x-jet-input-error for="last_name" class="mt-2" />
                    </div>
                </div>
            </div>


            <div class="row pb-2">
                <div class="col-md-9">
                    <div class="col-span-8 sm:col-span-1">
                        <x-jet-label for="last_name" value="{{ __('Residence Address:') }}" />
                        <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="last_name" />
                        <x-jet-input-error for="last_name" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-span-8 sm:col-span-1">
                        <x-jet-label for="last_name" value="{{ __('Mobile Number:') }}" />
                        <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="last_name" />
                        <x-jet-input-error for="last_name" class="mt-2" />
                    </div>
                </div>
            </div>
            <!-- <hr/> -->
            <div class="row pb-2">
                <div class="col-md-2">
                    <div class="col-span-6 sm:col-span-1">
                        <x-jet-input name="spouse_tax_dependent" type="checkbox"/>{{ __('Tax Dependent') }}
                        <x-jet-input-error for="department" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="col-span-6 sm:col-span-1">
                        <x-jet-input name="spouse_sss_beneficiary" type="checkbox"/>{{ __('SSS Beneficiary') }}
                        <x-jet-input-error for="department" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-span-6 sm:col-span-1">
                        <x-jet-input name="spouse_phic_beneficiary" type="checkbox"/>{{ __('PHIC Beneficiary') }}
                        <x-jet-input-error for="department" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-span-6 sm:col-span-1">
                        <x-jet-input name="spouse_phic_beneficiary" type="checkbox"/>{{ __('Can be Notifiied in Case of Emergency') }}
                        <x-jet-input-error for="department" class="mt-2" />
                    </div>
                </div>
            </div>

        </div>
    </div> --}}


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

<script>
    let count = 1;
    $('#addDependents').click(function(){
        if(count < 3){
            $('#familyBgContainer').append(`
                <div class="beneficiary-form row form-group border bg-light">
                <div class="col-md-12">
                    <div class="row py-2">
                        <div class="col-md-6">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input id="last_name${count}" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="last_name" placeholder="Name"/>
                                <x-jet-label for="last_name${count}" value="{{ __('Name:') }}" />
                                <x-jet-input-error for="last_name${count}" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input id="birthDate${count}" type="text" class="form-control datepicker mt-1 block w-full" wire:model.defer="state.birthdate" placeholder="mm/dd/yyyy" autocomplete="off" />
                                <x-jet-label for="birthDate${count}" value="{{ __('Birth Date:') }}" />
                                <x-jet-input-error for="birthDate${count}" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating col-span-6 sm:col-span-2 w-full">
                                <select id="relationship" name="relationship" 
                                    class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" 
                                    placeholder="Relationship" style="width: 100%; height: 100%;">
                                    <option id="relationshipOption${count}" value="">-Select Relationship-</option>
                                    <option >Spouse</option>
                                    <option >Mother</option>
                                    <option >Father</option>
                                    <option >Guardian</option>
                                </select>
                                <x-jet-label for="relationship${count}" value="{{ __('Relationship') }}" />
                                <x-jet-input-error for="relationship${count}" class="mt-2" />
                            </div>
                        </div>
                    </div>


                    <div class="row pb-2">
                        <div class="col-md-9">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input id="residence_address${count}" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Residence Address" />
                                <x-jet-label for="residence_address${count}" value="{{ __('Residence Address:') }}" />
                                <x-jet-input-error for="residence_address${count}" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input id="contact_number${count}" type="text" class="form-control t-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Contact Number"/>
                                <x-jet-label for="contact_number${count}" value="{{ __('Contact Number:') }}" />
                                <x-jet-input-error for="contact_number${count}" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="row pb-2">
                        <div class="col-md-3">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input id="occupation${count}" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Occupation"/>
                                <x-jet-label for="occupation${count}" value="{{ __('Occupation:') }}" />
                                <x-jet-input-error for="occupation${count}" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input id="company_name${count}" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Company Name"/>
                                <x-jet-label for="company_name${count}" value="{{ __('Company Name:') }}" />
                                <x-jet-input-error for="company_name${count}" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input id="company_address${count}" type="text" class="form-control mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="off" placeholder="Company Address" />
                                <x-jet-label for="company_address${count}" value="{{ __('Company Address:') }}" />
                                <x-jet-input-error for="company_address${count}" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="row pb-2">
                        <div class="col-md-2">
                            <div class="col-span-6 sm:col-span-1">
                                <x-jet-input name="spouse_tax_dependent${count}" type="checkbox"/>{{ __('Tax Dependent') }}
                                <x-jet-input-error for="department${count}" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="col-span-6 sm:col-span-1">
                                <x-jet-input name="spouse_sss_beneficiary${count}" type="checkbox"/>{{ __('SSS Beneficiary') }}
                                <x-jet-input-error for="department${count}" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="col-span-6 sm:col-span-1">
                                <x-jet-input name="spouse_phic_beneficiary${count}" type="checkbox"/>{{ __('PHIC Beneficiary') }}
                                <x-jet-input-error for="department${count}" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-span-6 sm:col-span-1">
                                <x-jet-input name="spouse_phic_beneficiary${count}" type="checkbox"/>{{ __('Can be Notifiied in Case of Emergency') }}
                                <x-jet-input-error for="department${count}" class="mt-2" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        `);
        }
        
        count++;
    })
</script>
