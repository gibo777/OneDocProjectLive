<x-jet-gilbert submit="updateProfileInformation">

<link href="{{ asset('/selectsearch/select2/dist/css/select2.min.css') }}" rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap4.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.min.css') }}">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('/selectsearch/jquery-3.2.1.min.js') }}" type='text/javascript'></script>
<script type="text/javascript" src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('/selectsearch/select2/dist/js/select2.min.js') }}" type='text/javascript'></script>

<!-- TABLE WITH PAGINATION beging -->
<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.min.js') }}"></script>

    <x-slot name="title">
        {{ __('e-Signature') }}
    </x-slot>

    <x-slot name="description">
        {{ __('') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-8 sm:col-span-8"> 
        <div class="row">
            <div class="col-md-12">
                <div class="row pb-2">
                    <div class="col-md-4">
                        <div class="col-span-8 sm:col-span-4">
                            <iframe id="preview-memo" src="" class="col-md-12 bg-light" width="100%" height="150"></iframe>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-span-8 sm:col-span-4">
                            <x-jet-label for="last_name" value="{{ __('e-Signature') }}" />
                                <textarea id="reason" name="reason" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full empty" wire:model.defer="state.reason" /> </textarea>
                            <x-jet-input-error for="last_name" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-span-8 sm:col-span-1 item-center">
                              <div class="custom-file">
                                <x-jet-input type="file" class="custom-file-input" id="eSignature_file" />

                                <x-jet-label class="custom-file-label" for="eSignature_file" value="{{ __('Choose e-Signature Image') }}" />
                              </div>
                              <div class="">
                                <x-jet-button class="btn btn-secondary btn-sm" id="preview_esignature" value="{{ __('Preview') }}">{{ __('Preview') }}</x-jet-button>
                              </div>
                        </div>
                    </div>
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
    <script>
$(document).ready(function(){
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    var memo_ctr = 0;

    /*if(window.matchMedia("(max-width: 767px)").matches){
        // The viewport is less than 768 pixels wide
        $("#desktop-view").hide();
        $("#mobile-view").show();
    } else{
        // The viewport is at least 768 pixels wide
        $("#desktop-view").show();
        $("#mobile-view").hide();
    }*/

    $('#eSignature_file').on('change', function() {
        alert('heyyy'); return false;
             /* // Get the selected file
              var files = $('#eSignature_file')[0].files;
              var file_extension = $('#eSignature_file').val().split('.').pop();

              if(files.length > 0){
                switch (file_extension) {
                    case 'png': case 'jpg': case 'jpeg':
                         var fd = new FormData();

                         // Append data 
                         fd.append('file',files[0]);
                         fd.append('_token',CSRF_TOKEN);

                         // Hide alert 
                         $('#responseMsg').hide();

                         // AJAX request 
                         $.ajax({
                           url: "{{route('uploadFile')}}",
                           method: 'post',
                           data: fd,
                           contentType: false,
                           processData: false,
                           // dataType: 'json',
                           success: function(data){
                            // alert(data);
                           },
                           error: function(response){
                              console.log("error : " + JSON.stringify(response) );
                           }
                         });
                         let fileName = $(this).val().split('\\').pop();
                         $(this).next('.custom-file-label').addClass("selected").html(fileName); 
                     break;
                     default:
                        $("#preview_memo").prop("disabled",true);
                        alert('Unsupported file!');
                     break;
                }
            }*/
    });


    $('#preview_esignature').on('click', function() {
            /*$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // alert("{{ route('file.preview') }}");
            // alert($("#inputGroupFile02").val()); return false;
            // alert(window.location.origin+'/file-preview-memo'); return false;
            $.ajax({
                // url: window.location.origin+'/file-preview-memo',
                url: "{{ route('file.preview') }}",
                method: 'get',
                // data: $("#memo-form").serialize(), // prefer use serialize method
                data: { 'file': $("#inputGroupFile02").val() }, // prefer use serialize method
                success:function(data){
                }
            });*/

            return false;

        // let fileName = $(this).val().split('\\').pop(); 
        // $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });

});
</script>

</x-jet-gilbert>
