<x-app-layout>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> -->

    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight"> -->
        {{-- <h2 class="font-semibold leading-tight text-center"> --}}
            {{ __('PERSONNEL DATA') }}
        {{-- </h2> --}}
    </x-slot>

    {{-- <div class="max-w-8xl mx-auto py-2 sm:px-6 lg:px-8"> --}}
<div class="max-w-7xl mx-auto mt-1">
    <div class="">
        
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
            {{-- tab 1 | Personal Data --}}
            <li class="nav-item" role="presentation">
                <button id="pills-pd-tab" class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-pd" type="button" role="tab" aria-controls="pills-pd" aria-selected="true">
                Personal Data
                </button>
            </li>
            {{-- tab 2 | Accounting Data --}}
            <li class="nav-item" role="presentation">
                <button id="pills-ad-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-ad" type="button" role="tab" aria-controls="pills-ad" aria-selected="false">
                Accounting Data
                </button>
            </li>
            @if (Auth::user()->id==1)
            {{-- tab 3 | Family Background --}}
            <li class="nav-item" role="presentation">
                <button id="pills-fb-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-fb" type="button" role="tab" aria-controls="pills-fb" aria-selected="false">
                Family Background
                </button>
            </li>
            {{-- tab 4 | Educational Background --}}
            <li class="nav-item" role="presentation">
                <button id="pills-eb-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-eb" type="button" role="tab" aria-controls="pills-eb" aria-selected="false">
                Educational Background
                </button>
            </li>
            {{-- tab 5 | Employment History --}}
            <li class="nav-item" role="presentation">
                <button id="pills-eh-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-eh" type="button" role="tab" aria-controls="pills-eh" aria-selected="false">
                Employment History
                </button>
            </li>
            @endif
            {{-- tab 6 | Account Securitya --}}
            <li class="nav-item" role="presentation">
                <button id="pills-as-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-as" type="button" role="tab" aria-controls="pills-as" aria-selected="false">
                Account Security
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-pd" role="tabpanel" aria-labelledby="pills-pd-tab">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.update-profile-information-form')
                    {{-- <x-jet-section-border /> --}}
                @endif
            </div>
            <div class="tab-pane fade" id="pills-ad" role="tabpanel" aria-labelledby="pills-ad-tab">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.accounting-data')
                @endif
            </div>
            <div class="tab-pane fade" id="pills-fb" role="tabpanel" aria-labelledby="pills-fb-tab">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.family-background')
                @endif
            </div>
            <div class="tab-pane fade" id="pills-eb" role="tabpanel" aria-labelledby="pills-eb-tab">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.educational-background')
                @endif
            </div>
            <div class="tab-pane fade" id="pills-eh" role="tabpanel" aria-labelledby="pills-eh-tab">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.employment-history')
                @endif
            </div>
            <div class="tab-pane fade" id="pills-as" role="tabpanel" aria-labelledby="pills-as-tab">
                {{-- <div class="container w-full"> --}}
                  <div class="row mt-2">
                    <div class="col-md-4">
                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                    @livewire('profile.update-password-form')
                            @endif
                    </div>
                    <div class="col-md-4">
                            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                                    @livewire('profile.two-factor-authentication-form')
                            @endif
                    </div>
                    <div class="col-md-4">
                            @livewire('profile.logout-other-browser-sessions-form')
                    </div>
                  {{-- </div> --}}
            </div>
        </div>


              {{-- <ul class="nav nav-tabs">
                <li class="nav-link active"><a data-bs-toggle="tab" href="#profile_info">Personal Data</a></li>
                <li class="nav-link"><a data-bs-toggle="tab" href="#accounting_data">Accounting Data</a></li>
                <li class="nav-link"><a data-bs-toggle="tab" href="#family_background">Family Background</a></li>
                <li class="nav-link"><a data-bs-toggle="tab" href="#educational_background">Educational Background</a></li>
                <li class="nav-link"><a data-bs-toggle="tab" href="#employment_history">Employment History</a></li>
                <li class="nav-link"><a data-bs-toggle="tab" href="#account_security">Account Security</a></li>
              </ul>

              <div class="tab-content">
                <div id="profile_info" class="tab-pane fade-in active">
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            @livewire('profile.update-profile-information-form')
                            <!-- <x-jet-section-border /> -->
                        @endif
                </div>
                <div id="accounting_data" class="tab-pane fade">
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            @livewire('profile.accounting-data')
                            <x-jet-section-border />
                        @endif
                </div>
                <div id="family_background" class="tab-pane fade">
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            @livewire('profile.family-background')
                            <!-- <x-jet-section-border /> -->
                        @endif
                </div>
                <div id="educational_background" class="tab-pane fade">
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            @livewire('profile.educational-background')
                            <!-- <x-jet-section-border /> -->
                        @endif
                </div>
                <div id="employment_history" class="tab-pane fade">
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            @livewire('profile.employment-history')
                            <!-- <x-jet-section-border /> -->
                        @endif
                </div>
                <div id="e-signature" class="tab-pane fade">
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            @livewire('profile.e-signature')
                            <!-- <x-jet-section-border /> -->
                        @endif
                </div> --}}
                

                <?php
                 /*<div id="account_security" class="tab-pane fade max-w-75 ">

                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                            <div class="mt-10 sm:mt-0">
                                @livewire('profile.update-password-form')
                            </div>
                        @endif

                        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                            <div class="mt-10 sm:mt-0">
                                @livewire('profile.two-factor-authentication-form')
                            </div>
                        @endif

                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.logout-other-browser-sessions-form')
                        </div>
                        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                            <x-jet-section-border />

                            <div class="mt-3 sm:mt-0">
                                @livewire('profile.delete-user-form')
                            </div>
                        @endif
                       
                </div>*/
                ?>

                {{-- <div id="account_security" class="container tab-pane fade ">
                    <div class="container w-full">
                      <div class="row">
                        <div class="col-sm pt-2">
                                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                    <div class="mt-10 sm:mt-0">
                                        @livewire('profile.update-password-form')
                                    </div>
                                @endif
                        </div>
                        <div class="col-sm pt-2">
                                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                                    <div class="mt-10 sm:mt-0">
                                        @livewire('profile.two-factor-authentication-form')
                                    </div>
                                @endif
                        </div>
                        <div class="col-sm pt-2">
                                <div class="mt-10 sm:mt-0">
                                    @livewire('profile.logout-other-browser-sessions-form')
                                </div>
                        </div>
                      </div>
                    </div>

                </div> --}}
      {{-- </div> --}}
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function() {

    // $("#country").select2();
    // $("#province").select2();
    // $("#municipality").select2();

    $(function () {
        $('[data-bs-toggle="collapse"]').tooltip()
    })

    
    /*$("input").on('keyup keydown change paste',function () {
        if ($.trim($(this).val())=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }
    });*/

    
    $("#hidden_profile_photo").change(function() {
        // var photoName = $refs.photo.files[0].name;
        // const reader = new FileReader();
        // reader.onload = (e) => {
        //     photoPreview = e.target.result;
        // };
        // reader.readAsDataURL($refs.photo.files[0]);
        // alert('Gibs'); return false;
    });

    /*$("#country").on('change', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/provinces',
            method: 'get',
            data: {
                'country_code': $(this).val()
            },
            success:function(data){
                $("#province").empty();
                $("#province").append('<option value="">-Select Province-</option>');
                for (var n=0; n<data.length; n++) {
                    $("#province").append("<option>"+data[n]['province']+"</option>");
                }
                $("#municipality").empty();
                $("#municipality").append('<option value="">-Select City/Municipality-</option>');
                $("#barangay").empty();
                $("#barangay").append('<option value="">-Select Barangay-</option>');
                $("#zip_code").val('');
            }
        });
    });*/

    /*$("#province").on('change', function() {
        // alert('Country: '+$("#country").val()+'\nProvince: '+$(this).val()); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/cities',
            method: 'get',
            data: {
                'country_code': $("#country").val(),
                'province': $(this).val()
            },
            success:function(data){
                // prompt('',data); return false;
                $("#municipality").empty();
                $("#municipality").append('<option value="">-Select City/Municipality-</option>');
                for (var n=0; n<data.length; n++) {
                    $("#municipality").append("<option>"+data[n]['municipality']+"</option>");
                }
                $("#barangay").empty();
                $("#barangay").append('<option value="">-Select Barangay-</option>');
                $("#zip_code").val('');
                
            }
        });
    });*/

    /*$("#municipality").on('change', function() {
        // alert('municipality'); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/barangays',
            method: 'get',
            data: {
                'country_code'  : $("#country").val(),
                'province'      : $("#province").val(),
                'municipality'  : $(this).val()
            },
            success:function(data){
                // prompt('',data); return false;
                $("#barangay").empty();
                $("#barangay").append('<option value="">-Select Barangay-</option>');
                for (var n=0; n<data.length; n++) {
                    $("#barangay").append("<option>"+data[n]['barangay']+"</option>");
                }
                $("#zip_code").val('');
                
            }
        });
    });*/

    /*$("#barangay").on('change', function() {
        // alert('barangay and zip'); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/zipcodes',
            method: 'get',
            data: {
                'country_code'  : $("#country").val(),
                'province'      : $("#province").val(),
                'municipality'  : $("#municipality").val(),
                'barangay'      : $(this).val(),
            },
            success:function(data){
                $("#zip_code").val(data['zip_code']);
            }
        });
    });*/




    $("#capturePhoto").click(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/webcam',
            method: 'get',
            success:function(data){
                // prompt('',data);
                // $(".modal-body").html(data);
                $("#modalWebCam").modal("show");
            }
        });
    });
    
    /*$("#capturePhoto").click(function() {
        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        
        Webcam.attach( '#my_camera' );
        
    });
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            $('#results').removeClass('hidden')
            $('#results').html('<img src="'+data_uri+'"/>');
        } );
    }
    $("#closeWebCamModal").click(function() {
        alert('RNG s');
        Webcam.reset( '#my_camera' );
    });*/

    /* ACCOUNTING DATA - DEPENDENTS */

    $(".btnDependents").each(function(){
        $(this).click(function() {
            var dCounter = $('.dependentsRow').length;
            // console.log(dCounter);
            $(function () {
                // $('#date_applied').datepicker({ dateFormat: 'mm/dd/yy' });
                $('#date_from').datepicker({
                    dateFormat: 'mm/dd/yy',
                    changeMonth: true,
                    changeYear: true,
                    // yearRange: "1900:3000",
                    autoclose: true
                });
                $('#date_to').datepicker({
                    dateFormat: 'mm/dd/yy',
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true
                });

                $('.datepicker').datepicker({
                    dateFormat: 'mm/dd/yy',
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true
                });

                $('#holiday_date').datepicker({
                    dateFormat: 'mm/dd/yy',
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true
                });

            });
            if (dCounter < 4) {
            $("#dependents")
            .append(`
                    <div class="row dependentsRow">
                        <div class="col-md-8 p-1">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input name="dependent_name" id="dependent_name${dCounter+1}" type="text" class="dependentsName form-control block w-full" wire:model.defer="state.dependent1" autocomplete="off" placeholder="Dependent"/>
                                <x-jet-label for="dependent_name${dCounter+1}" value="{{ __('Dependent ${dCounter+1}') }}" />
                                <x-jet-input-error for="dependent_name1" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-3 p-1">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <x-jet-input name="dependent_birthdate" id="dependent_birthdate${dCounter+1}" type="text" class="dependentsBday form-control datepicker block w-full" wire:model.defer="state.dependent_birthdate${dCounter+1}" placeholder="mm/dd/yyyy"/>
                                <x-jet-label for="dependent_birthdate${dCounter+1}" value="{{ __('Birthdate') }}" />
                                <x-jet-input-error for="dependent_birthdate${dCounter+1}" class="mt-2" />
                            </div>
                        </div>
                    </div>
                `);
            }
        });
        return false;
    });

  

});
</script>
</x-app-layout>
