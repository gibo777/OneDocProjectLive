
<!-- <script src="{{ asset('/js/hris-jquery.js') }}"></script> -->
<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-app-layout>
<div>
    <x-slot name="header">
            {{ __('PROCESSING E-LEAVE APPLICATION') }}
    </x-slot>

    <div class="max-w-5xl mx-auto py-12 sm:px-6 lg:px-8">
        <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
           
            <form id="process-leave" method="POST" action="{{ route('process.eleave') }}">
                <div class="grid grid-cols-5 gap-6 text-center sm:justify-center">
                    <!-- CUT-OFF DATE -->
                    <div class="col-span-5 sm:col-span-5" id="div_date_covered">
                            <x-jet-label for="processDateFrom" value="{{ __('CUT-OFF DATE') }}" class="font-semibold text-xl"/>
                            <x-jet-input id="processDateFrom" name="processDateFrom" type="date" wire:model.defer="state.processDateFrom" {{-- class="date-input datepicker"  --}}placeholder="mm/dd/yyyy" autocomplete="off"/>

                            <label class="font-semibold text-gray-800 leading-tight">TO</label>

                            <x-jet-input id="processDateTo" name="processDateTo" type="date" wire:model.defer="state.processDateTo" {{-- class="date-input datepicker" --}} placeholder="mm/dd/yyyy" autocomplete="off"/>
                            <x-jet-input-error for="processDateFrom" class="mt-2" />
                            <x-jet-input-error for="processDateTo" class="mt-2" />
                    </div>

                    <div class="col-span-5 sm:col-span-5">
                        <x-jet-button id="btnProcessEleave" value="" disabled>{{ __('PROCESS E-LEAVE') }}</x-jet-button>
                    </div>
                    <div id="myProgress" class="col-span-5">
                        <div id="processing_bar" class="myBar"></div>
                        <!-- <div id="test_count" class="myBar"></div> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>

<x-jet-input id="hid_access_id" name="hid_access_id" value="{{ Auth::user()->access_code }}" type="text" hidden/>

<div id="loading" hidden>
  <img id="loading-image" src="{{ asset('/img/misc/loading-blue.gif') }}" alt="Loading..." />
</div>

</x-app-layout>

<script type="text/javascript">
$(document).ready(function(){
    
    /* PROCESS E-LEAVE begin */
    $("#processDateFrom").change(function() {

        if ($('#processDateTo').val()=='' || $('#processDateTo').val()==null) {
            var pdto = new Date($(this).val());
            pdto.setDate(pdto.getDate()+14);
            var pdm = pdto.getMonth()+1; if (pdm<10) { pdm = "0"+pdm; }
            var pdd = pdto.getDate(); if (pdd<10) { pdd = "0"+pdd; }

            if($(this).val().length>=10) {
                $("#processDateTo").val([pdto.getFullYear(),pdm,pdd].join('-'));
                // $("#processDateTo").val([pdm,pdd,pdto.getFullYear()].join('/'));
                // $("#processDateTo").removeAttr('disabled');
                // alert($("#processDateTo").val());
                $("#btnProcessEleave").removeAttr('disabled');
            }
        } else {
            var dateFrom = new Date($(this).val());
            var dateTo = new Date($('#processDateTo').val());

            if( dateTo < dateFrom ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Range',
                    // text: '',
                }).then(function() {
                    $("#processDateFrom").val('');
                    $("#processDateTo").val('');
                    $("#btnProcessEleave").prop('disabled',true);
                });
            } else {
                $("#btnProcessEleave").prop('disabled',false);
            }
        }
    });

    /*$("#processDateFrom").on('keyup keydown', function(e) {
        // alert($(this).val().length);
        if($(this).val().length<10) {
            $("#btnProcessEleave").attr('disabled',true);
        } else {
            $("#btnProcessEleave").removeAttr('disabled');
        }
    });*/


    $("#processDateTo").change(function() {
        if ($(this).val()!="" && $("#processDateFrom").val()!="") {
            var dt_diff = (Date.parse($(this).val()) - Date.parse($("#processDateFrom").val())) / (1000*3600*24) + 1;
            // alert( dt_diff );

            var dateFrom = new Date($('#processDateFrom').val());
            var dateTo = new Date($(this).val());

            if( dateTo < dateFrom ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Range',
                    // text: '',
                }).then(function() {
                    // $("#processDateFrom").val('');
                    $("#processDateTo").val('');
                    $("#btnProcessEleave").prop('disabled',true);
                });
            } else {
                $("#btnProcessEleave").prop('disabled',false);
            }
        }
    });


    $("#btnProcessEleave").click(function() {
        // var url = window.location.origin+'/view-processing-leave';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/view-processing-leave',
            method: 'get',
            data: $("#process-leave").serialize(), // prefer use serialize method
            success:function(id){
                // Swal.fire({ html: id }); return false;
                if (id.length<=0) {
                    $("#processing_bar").html("NOTHING TO PROCESS").width("100%");
                } else {
                    /*alert(id.length); return false;
                    for (var n=0; n<id.length; n++) {
                        alert("ID: "+id[n]['id']+"\nEnd Date: "+id[n]['date_to']);
                        if (n==3) {return false;}
                    }*/
                    var n_processed = 0;
                    for (var n=0; n<id.length; n++) {
                        // alert(id[n]['id']);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: window.location.origin+'/processing-leave',
                            method: 'post',
                            data: { 'id': id[n]['id'] }, // prefer use serialize method
                            success:function(data){
                                n_processed++;
                                // $("#test_count").html(id[n]['id']);
                                if (n_processed==1) {
                                    move(id);
                                }
                            }
                        });
                    }
                }
            }
        });
        return false;
    });

    var i = 0;
    var ctr = 0;
    function move(leaveID) {
        var counts = leaveID.length;
        if (i == 0) {
        i = 1;
        var elem = $("#processing_bar");
        var width = 0;
        // var done = Math.ceil(counts/100);
        // alert(done); return false;
        var id = setInterval(frame, (counts*1.5));
        var ctr_success=0;
        // alert("INTER: "+id+"\nCOUNTS: "+counts); return false;
        $("#loading").removeAttr('hidden');
        $("#loading").show();
            function frame() {
              if (width >= 100) {
                clearInterval(id);
                i = 0;
              } else {
                    // ctr_success = data;
                    ctr = ctr+(1/counts)*100;
                    width = ctr;
                    // $("#test_count").html(ctr_success+"|"+counts+"|"+ctr.toFixed(2)+"|"+leaveID[n]['id'])
                    elem.width(width + "%");
                    if (Math.round(width)<100) {
                        $("#processing_bar").html(width.toFixed(2) + "%");
                    } else {
                        $("#loading").hide();
                        $("#processing_bar").html(counts+" LEAVE/S PROCESSED");
                    }
              }
            }
        }
    }
    /* PROCESS E-LEAVE end*/
});
</script>



