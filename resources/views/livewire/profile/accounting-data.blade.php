<x-jet-personnel-component>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<form id="accountingDataForm">
@csrf

<div class="col-span-12 sm:col-span-12 mx-4"> 
        <div class="row pt-2">
            <div class="col-md-2 form-floating px-1">
                <x-jet-input id="vacation_leaves" type="text" class="leaves form-control text-center block w-full"  autocomplete="off" value="{{$leaves->VL!=null?$leaves->VL:0}}" readonly/>
                <x-jet-label for="vacation_leaves" value="{{ __('Vacation Leaves') }}" class="text-black-50 w-full" />
                <x-jet-input-error for="vacation_leaves" class="mt-2" />
            </div>
            <div class="col-md-2 form-floating px-1">
                <x-jet-input id="sick_leaves" type="text" class="leaves form-control text-center block w-full"  autocomplete="off" value="{{$leaves->SL!=null?$leaves->SL:0}}" readonly/>
                <x-jet-label for="sick_leaves" value="{{ __('Sick Leaves') }}" class="text-black-50 w-full" />
                <x-jet-input-error for="sick_leaves" class="mt-2" />
            </div>
            <div class="col-md-2 form-floating px-1">
                <x-jet-input id="maternity_leaves" type="text" class="leaves form-control text-center block w-full"  autocomplete="off" value="{{$leaves->ML!=null?$leaves->ML:0}}" readonly/>
                <x-jet-label for="maternity_leaves" value="{{ __('Maternity Leaves') }}" class="text-black-50 w-full" />
                <x-jet-input-error for="civil_status" class="mt-2" />
            </div>
            <div class="col-md-2 form-floating px-1">
                <x-jet-input id="paternity_leaves" type="text" class="leaves form-control text-center block w-full"  autocomplete="off" value="{{$leaves->PL!=null?$leaves->PL:0}}" readonly/>
                <x-jet-label for="paternity_leaves" value="{{ __('Paternity Leaves') }}" class="text-black-50 w-full" />
                <x-jet-input-error for="paternity_leaves" class="mt-2" />
            </div>
            <div class="col-md-2 form-floating px-1">
                <x-jet-input id="emergency_leaves" type="text" class="leaves form-control text-center block w-full"  autocomplete="off" value="{{$leaves->EL!=null?$leaves->EL:0}}" readonly/>
                <x-jet-label for="emergency_leaves" value="{{ __('Emergency Leaves') }}" class="text-black-50 w-full" />
                <x-jet-input-error for="emergency_leaves" class="mt-2" />
            </div>
            <div class="col-md-2 form-floating px-1">
                <x-jet-input id="others" type="text" class="leaves form-control text-center block w-full" autocomplete="off" value="{{$leaves->others!=null?$leaves->others:0}}" readonly/>
                <x-jet-label for="others" value="{{ __('Other Leaves') }}" class="text-black-50 w-full" />
                <x-jet-input-error for="others" class="mt-2" />
            </div>
        </div>
        <div class="row py-2">
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="sss_number" name="sss_number" type="text" 
                    class="accounting form-control block w-full" 
                    placeholder="SSS Number" 
                    autocomplete="off"
                    value="{{$accData->sss_number}}" />
                    <x-jet-label for="sss_number" value="{{ __('SSS Number') }}" />
                    <x-jet-input-error for="sss_number" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="phic_number" name="phic_number" type="text" 
                    class="accounting form-control block w-full" 
                    placeholder="PHIC Number" 
                    autocomplete="off" 
                    value="{{$accData->phic_number}}"/>
                    <x-jet-label for="phic_number" value="{{ __('PHIC Number') }}" />
                    <x-jet-input-error for="phic_number" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="pagibig_number" name="pagibig_number" type="text" 
                    class="accounting form-control block w-full" 
                    placeholder="PAG-IBIG Number" 
                    autocomplete="off" 
                    value="{{$accData->pagibig_number}}"/>
                    <x-jet-label for="pagibig_number" value="{{ __('PAG-IBIG Number') }}" />
                    <x-jet-input-error for="pagibig_number" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="tin_number" name="tin_number" type="text" class="accounting form-control block w-full" placeholder="TIN Number" autocomplete="off" value="{{$accData->tin_number}}"/>
                    <label>TIN Number <span class="text-danger">*</span></label>
                    <x-jet-input-error for="tin_number" class="mt-2" />
                </div>
               
            </div>
        </div>

        <div class="row pb-2">
            {{-- <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                <!-- Tax Status -->
                    <select name="tax_status" id="tax_status" class="accounting form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full"
                    >
                        @if($accData!='' && $accData->tax_status)
                            <option value="{{$accData->tax_status}}">{{$taxStatusDesc}}</option>
                            @foreach ($tax_statuses as  $tax_status)
                            <option value="{{ $tax_status->tax_status_code }}">{{ $tax_status->tax_status_description }}</option>
                            <option value="">Select Tax Status</option>
                            @endforeach
                        @else
                            <option value="">Select Tax Status</option>
                            @foreach ($tax_statuses as  $tax_status)
                            <option value="{{ $tax_status->tax_status_code }}">{{ $tax_status->tax_status_description }}</option>
                            @endforeach
                        @endif
                        
                    </select>
                    <label>Tax Status <span class="text-danger">*</span></label>
                    <x-jet-input-error for="tax_status" class="mt-2" />
                </div>
            </div> --}}

            <div class="col-md-9 dependents" id="dependents">
               @if(sizeof($dependents) > 0)
               @foreach($dependents as $dependent)
                <div class="row dependentsRow">
                        <div class="col-md-8 p-1">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input record_id="{{$dependent->id}}" name="dependent_name" id="dependent_name{{$loop->iteration}}" type="text" class="dependentsName form-control block w-full" autocomplete="off" placeholder="Dependent" value="{{$dependent->dependent_name}}"/>
                                <x-jet-label for="dependent_name{{$loop->iteration}}" value="{{ __('Dependent ')}} {{$loop->iteration }}" />
                                <x-jet-input-error for="dependent_name{{$loop->iteration}}" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-3 p-1">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input record_id="{{$dependent->id}}" name="dependent_birthdate" id="dependent_birthdate{{$loop->iteration}}" type="text" class="dependentsBday form-control datepicker block w-full" placeholder="mm/dd/yyyy" value="{{$dependent->dependent_birthdate}}"/>
                                <x-jet-label for="dependent_birthdate{{$loop->iteration}}" value="{{ __('Birthdate') }}" />
                                <x-jet-input-error for="dependent_birthdate{{$loop->iteration}}" class="mt-2" />
                            </div>
                        </div>
                        @if($loop->iteration ==1 )
                            <div class="d-flex justify-content-center col-md-1 p-3">
                                <i name="btnDependents[]" class="btnDependents d-flex justify-content-center fa fa-solid fa-plus btn btn-success btn-success-3d" data-bs-toggle="tooltip" title="Add dependent"></i>
                            </div>
                        @endif
                </div>
                @endforeach
               @else
                <div class="row dependentsRow">
                        <div class="col-md-8 p-1">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input name="dependent_name" id="dependent_name1" type="text" class="dependentsName form-control block w-full" autocomplete="off" placeholder="Dependent"/>
                                <x-jet-label for="dependent_name1" value="{{ __('Dependent 1') }}" />
                                <x-jet-input-error for="dependent_name1" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-3 p-1">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input name="dependent_birthdate" id="dependent_birthdate1" type="text" class="dependentsBday form-control datepicker block w-full" placeholder="mm/dd/yyyy"/>
                                <x-jet-label for="dependent_birthdate1" value="{{ __('Birthdate') }}" />
                                <x-jet-input-error for="dependent_birthdate1" class="mt-2" />
                            </div>
                        </div>
                        <div class="d-flex justify-content-center col-md-1 p-3">
                            <i name="btnDependents[]" class="btnDependents d-flex justify-content-center fa fa-solid fa-plus btn btn-success btn-success-3d" data-bs-toggle="tooltip" title="Add dependent"></i>
                        </div>
                    </div>
               @endif
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-md-3 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="health_card_number" type="text" class="accounting form-control block w-full" placeholder="Health Card Number" autocomplete="off" value="{{$accData->health_card_number}}"/>
                    <x-jet-label for="health_card_number" value="{{ __('Health Card Number') }}" />
                    <x-jet-input-error for="health_card_number" class="mt-2" />
                </div>
            </div>
            <div class="col-md-2.5 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="drivers_license" type="text" class="accounting form-control block w-full" placeholder="Driver's License" autocomplete="off" value="{{$accData->drivers_license}}"/>
                    <x-jet-label for="drivers_license" value="Driver's License" />
                    <x-jet-input-error for="drivers_license" class="mt-2" />
                </div>
            </div>
            <div class="col-md-2.5 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="passport_number" type="text" class="accounting form-control block w-full" placeholder="Passport Number" autocomplete="off" value="{{$accData->passport_number}}"/>
                    <x-jet-label for="passport_number" value="{{ __('Passport Number') }}" />
                    <x-jet-input-error for="passport_number" class="mt-2" />
                </div>
            </div>
            <div class="col-md-2 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="passport_expiry" type="text" class="accounting form-control datepicker block w-full" placeholder="mm/dd/yyyy" value="{{$accData->passport_expiry}}" />
                    <x-jet-label for="passport_expiry" value="{{ __('Expiration Date:') }}" />
                    <x-jet-input-error for="passport_expiry" class="mt-2" />
                </div>
            </div>
            <div class="col-md-2 p-1">
                <div class="form-floating col-span-8 sm:col-span-1">
                    <x-jet-input id="prc" type="text" class="accounting form-control block w-full" placeholder="PRC" value="{{$accData->prc}}" />
                    <x-jet-label for="prc" value="{{ __('PRC') }}" />
                    <x-jet-input-error for="prc" class="mt-2" />
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
<script>
    $(document).ready(function(){
       
          /* SUBMIT ACCOUNTING DATA start - Gilbert Retiro */
        $('#submitAccountingData').on('click', function(e){
            try{
                e.preventDefault();
                let dependentDataName = [];
                let dependentDataBday = [];
                let accountingData = {};
                let filteredDN = [];
                let filteredDB = [];
                
                // const leaveData = {
                //     VL: $("#vacation_leaves").val(),
                //     SL: $('#sick_leaves').val(),
                //     ML: $('#maternity_leaves').val(),
                //     PL: $('#paternity_leaves').val(),
                //     EL: $('#emergency_leaves').val(),
                //     others: $('#others').val(),
                // };
                $("#accountingDataForm .dependentsName").each(function(){
                    dependentDataName.push({[$(this).attr('name')]:$(this).val(),id:$(this).attr('record_id')});
                });
                $("#accountingDataForm .dependentsBday").each(function(){
                    dependentDataBday.push({[$(this).attr('name')]:$(this).val(),id:$(this).attr('record_id')});
                });

                $('#accountingDataForm .accounting').each(function(){
                    const name = this.id;
                    accountingData = {
                        ...accountingData,
                        [name] : $(this).val(),
                    }
                    
                });
                
                dependentDataName.map((dn,index)=>{
                    let toRemoveIndex;
                    if(dn.dependent_name != ''){
                        filteredDN.push(dn);
                    }
                })
                dependentDataBday.map((db,index)=>{
                    if(db.dependent_birthdate != ''){
                        filteredDB.push(db);
                    }
                })
                dependentDataName = filteredDN;
                dependentDataBday = filteredDB;
                
                /*if(!$('#tax_status').val() || !$('#tin_number').val()){
                    let taxStatusMessage = !$('#tax_status').val() ? 'Tax Status is Required' : '';
                    let tinNumberMessage = !$('#tin_number').val() ? 'Tin Number is Required' : '';
                    Swal.fire({
                        icon:'error',
                        title:'Error',
                        text:taxStatusMessage || tinNumberMessage,
                    })
                    return;
                }*/
                if(!$('#tin_number').val()){
                    let tinNumberMessage = !$('#tin_number').val() ? 'Tin Number is Required' : '';
                    Swal.fire({
                        icon:'error',
                        title:'Error',
                        text:tinNumberMessage,
                    })
                    return;
                }

                for(let i = 0; i < $('.dependentsRow').length; i++){
                    if($(`#dependent_name${i+1}`).val() && !$(`#dependent_birthdate${i+1}`).val()){
                        Swal.fire({
                            icon:'error',
                            title:'Error',
                            text:`A Dependent Name is present in Dependent Name field #${i+1} so a Dependent Birthdate is required`
                        })
                        return;
                   }

                   if(!$(`#dependent_name${i+1}`).val() && $(`#dependent_birthdate${i+1}`).val()){
                        Swal.fire({
                            icon:'error',
                            title:'Error',
                            text:`A Dependent Name is required becase a Dependent Birthdate is present in Dependent Birthdate field #${i+1}`
                        })
                        return;
                   }
                }
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/update-accounting-data',
                    method: 'post',
                    data: {accountingData,dependentDataName,dependentDataBday},
                    success:function(data){
                        console.log(data);
                        const {isSuccess,message} = data;
                        isSuccess ?
                            (Livewire.emit('refetchAcc'),
                            Swal.fire({
                                icon:'success',
                                title:'Success',
                                text:message
                            }))
                        :
                            Swal.fire({
                                icon:'error',
                                title:'Error',
                                text:JSON.stringify(message)
                            })
                    }
                });

            }catch(error){
                console.log(error);
            }
            
        });
    })

</script>


