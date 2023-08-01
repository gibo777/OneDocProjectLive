<x-app-layout>
    <x-slot name="header">
            {{ __('MEMO') }}
    </x-slot>
    <?php //phpinfo(); ?>
<!-- <a href="{{ route('document.wordtopdf') }}">Convert Word To PDF</a> -->

<!-- <input id="memo_counter" type="text" name="memo_counter"> -->
<!-- <div id="myProgress" class="col-span-5">
    <div id="processing_bar" class="myBar"></div>
</div> -->

    <div class="" style="height: 550px;">
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8 h-100" style="height: 550px;">

        <div class="col-span-8 sm:col-span-8" >
            <form id="memo-form" action="{{ route('tmp.file.preview') }}" method="POST">
            @csrf
            <div class="row">

                <!-- MEMO MOBILE VIEW -->
                <div class="col-md-4 py-2 hidden" id="mobile-view">
                  <ul class="nav nav-tabs">
                    <li class="nav-link active"><a data-toggle="tab" href="#general-memo-mobile">General Memo</a></li>
                    <li class="nav-link"><a data-toggle="tab" href="#specific-memo-mobile">Specific Memo</a></li>
                    <li class="">
                        <x-jet-button  name="add_memo" class="btn btn-primary btn-sm" aria-pressed="true">Add Memo</x-jet-button>
                    </li>
                  </ul>
                  <div class="tab-content embed-responsive-item">
                    <!-- <div id="profile_info" class="tab-pane fade-in active" style="height: 550px;"> -->
                    <div id="general-memo-mobile" class="tab-pane fade-in active">
                        <div class="p-3">
                            GENERAL
                        </div>
                    </div>
                    <div id="specific-memo-mobile" class="tab-pane fade">
                        <div class="p-3">
                            SPECIFIC
                        </div>
                    </div>
                  </div>
                </div>
                <!-- MEMO PREVIEW -->
                <div class="row justify-content-center col-md-8 bg-gray-200 border items-center justify-center border border-secondary rounded-left">
                    <!-- <iframe id="preview-memo" src="http://localhost:8000/view-pdf" class="col-md-12" width="100%" height="550"> -->
                    <iframe id="preview-memo" src="" class="h-100 w-full" width="100%">

                    <!-- <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ asset('storage/memo-archives/helloWorld.docx') }}" width="100%" height="550"> -->
                    <!-- <iframe src="" width="100%" height="550"> -->
                            <!-- This browser does not support PDFs. Please download the PDF to view it: <a href="{{ asset('storage/memo-archives/helloWorld.pdf') }}">Download PDF</a> -->


                    </iframe>
                    <?php 

                        /*@if(upload is image)
                            <img src="{{image url}}"/>
                        @elseif(upload is pdf)
                            <iframe src="{{pdf url}}" frameborder="0" style="width:100%;min-height:640px;"></iframe>
                        @elseif(upload is document)
                            <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{urlendoe(doc url)}}" frameborder="0" style="width:100%;min-height:640px;"></iframe>
                        @else
                        //manage things here
                        @endif*/
                    ?>
                </div>

                <!-- MEMO DESKTOP VIEW -->
                <div class="col-md-4 py-0 bg-light border border-secondary h-100" id="desktop-view">

<ul class="nav nav-pills" id="pills-tab" role="tablist">
    {{-- tab 1 | Personal Data --}}
    <li class="nav-item" role="presentation">
        <button id="pills-general-tab" class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-general" type="button" role="tab" aria-controls="pills-general" aria-selected="true">
        General
        </button>
    </li>
    {{-- tab 2 | Accounting Data --}}
    <li class="nav-item" role="presentation">
        <button id="pills-ad-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-ad" type="button" role="tab" aria-controls="pills-ad" aria-selected="false">
        Personal
        </button>
    </li>
    {{-- tab 3 | Family Background --}}
    <li class="nav-item mt-1 pl-5" role="presentation">
        @if (Auth::user()->department == '1D-HR')
            <x-jet-button id="addMemo" data-toggle="tab" href="#add-memo-desktop">
                {{ __('Add Memo') }}
            </x-jet-button>
        @endif
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
  {{-- GENERAL MEMO --}}
    <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-general-tab">
      <div class="w-full pr-3">
          <div class="row">
            <div class="col-12">
              <div class="list-group" id="general-list-tab" role="tablist">
                @foreach($memos as $key=>$memo)
                @if ($memo->memo_send_option=='g')
                  <a class="list-group-item list-group-item-action cut-text {{ ($memo->is_viewed==1) ? 'bg-viewed' : '' }}" data-value="{{ $memo->file_name }}" name="g-memo-list[]" id="{{ $memo->id }}" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                    {{ date('m/d/y',strtotime($memo->uploaded_at)).' - '.$memo->memo_subject }}
                  </a>
                  <input type="hidden" name="{{ $memo->id }}" value="{{ $memo->is_viewed }}">
                @endif
                @endforeach
              </div>
            </div>
          </div>
      </div>
    </div>
    {{-- PERSONAL MEMO --}}
    <div class="tab-pane fade" id="pills-ad" role="tabpanel" aria-labelledby="pills-ad-tab">
          <div class="w-full pr-3 ">
              <div class="row">
                <div class="col-12">
                  <div class="list-group" id="personal-list-tab" role="tablist">
                    <?php 
                    /*@foreach($memos as $key=>$memo)
                    @if ($memo->memo_send_option=='p')
                      <a class="list-group-item list-group-item-action cut-text" data-value="{{ $memo->file_name }}" name="p-memo-list[]" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        {{ date('m/d/y',strtotime($memo->uploaded_at)).' - '.$memo->memo_subject }}
                      </a>
                    @endif
                    @endforeach*/
                    ?>
                  </div>
                </div>
              </div>
          </div>
    </div>
    <div class="tab-pane fade" id="pills-fb" role="tabpanel" aria-labelledby="pills-fb-tab">
        test 3
    </div>
</div>



                  {{-- <ul class="nav nav-tabs">
                      <li class="nav-link active">
                          <a id="general-tab" data-toggle="tab" href="#general-memo-desktop">General&nbsp;&nbsp;
                          @foreach ($memo_counts as $key=>$memo_count)
                            @if ($memo_count->memo_send_option=='g')
                            <span id="g_count" class="badge badge-primary badge-pill">{{ $memo_count->memo_count }}</span>
                            @endif
                          @endforeach
                          </a>
                      </li>
                      <li class="nav-link">
                          <a id="specific-tab" data-toggle="tab" href="#specific-memo-desktop">Personal&nbsp;&nbsp;
                          @foreach ($memo_counts as $key=>$memo_count)
                            @if ($memo_count->memo_send_option=='p')
                            <span id="s_count" class="badge badge-primary badge-pill">{{ $memo_count->memo_count }}</span>
                            @endif
                          @endforeach
                          </a>
                      </li>

                    @if (Auth::user()->department == 'HR')
                    <li class="nav-link">
                        <a data-toggle="tab" href="#add-memo-desktop" class="btn btn-primary">Add</a>
                    </li>
                    @endif
                  </ul> --}}

                  {{-- <div class="tab-content embed-responsive-item scrollable" style="height: 500px;">
                    <!-- <div id="profile_info" class="tab-pane fade-in active" style="height: 550px;"> -->
                    <div id="general-memo-desktop" class="tab-pane fade-in active">
                        <div class="w-full pr-3">
                            <div class="row">
                              <div class="col-12">
                                <div class="list-group" id="general-list-tab" role="tablist">
                                  @foreach($memos as $key=>$memo)
                                  @if ($memo->memo_send_option=='g')
                                    <a class="list-group-item list-group-item-action cut-text {{ ($memo->is_viewed==1) ? 'bg-viewed' : '' }}" data-value="{{ $memo->file_name }}" name="g-memo-list[]" id="{{ $memo->id }}" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                                      {{ date('m/d/y',strtotime($memo->uploaded_at)).' - '.$memo->memo_subject }}
                                    </a>
                                    <input type="hidden" name="{{ $memo->id }}" value="{{ $memo->is_viewed }}">
                                  @endif
                                  @endforeach
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div id="specific-memo-desktop" class="tab-pane fade">
                        <div class="w-full pr-3 ">
                            <div class="row">
                              <div class="col-12">
                                <div class="list-group" id="personal-list-tab" role="tablist">
                                  <?php 
                                  /*@foreach($memos as $key=>$memo)
                                  @if ($memo->memo_send_option=='p')
                                    <a class="list-group-item list-group-item-action cut-text" data-value="{{ $memo->file_name }}" name="p-memo-list[]" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                                      {{ date('m/d/y',strtotime($memo->uploaded_at)).' - '.$memo->memo_subject }}
                                    </a>
                                  @endif
                                  @endforeach*/
                                  ?>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div> --}}
                    <div id="add-memo-desktop" class="tab-pane fade">
                        <div class="col-span-6 px-2 py-1 sm:col-span-6 w-full">
                            <x-jet-label value="{{ __('Subject:') }}" />
                            <x-jet-input id="memo_subject" name="memo_subject" type="text" class="mt-1 block w-full" autocomplete="off" />
                            <x-jet-input-error for="memo_subject" class="mt-2" />
                        </div>
                        <div class="p-3">
                          <div class="row p-2">
                            <div class="col-span-12 sm:col-span-6 px-1">
                                <x-jet-label for="" value="{{ __('Sending Option:') }}" />
                                <select id="memo_send_option" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" placeholder="Search" >
                                    <option value="">-Sending Option-</option>
                                    <option value="g">General</option>
                                    <option value="s">Personal</option>
                                </select>
                                <x-jet-input-error for="memo_send_option" class="mt-2" />

                                <x-jet-input type="text" id="file_created" hidden/>
                            </div>
                            <div class="col-span-12 sm:col-span-4 px-3">
                                <x-jet-label for="" value="{{ __('Upload/Create:') }}" />
                                <select id="memo_upload_create" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" placeholder="Search" >
                                    <option value="u">Upload</option>
                                    <option value="c">Create</option>
                                </select>
                                <x-jet-input-error for="memo_send_option" class="mt-2" />

                                <x-jet-input type="text" id="file_created" hidden/>
                            </div>
                          </div>
                        </div>
                        <div id="div_memo_recepients" class="col-span-6 sm:col-span-2 px-2 w-full hidden">
                            <x-jet-label for="memo_department" value="{{ __('Department:') }}" />
                            <select id="memo_department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Search" style="width: 100%;">
                                <option value="">All Departments</option>
                                @foreach ($departments as $key=>$department)
                                <option value="{{ $department->department_code }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                            <x-jet-input-error for="memo_department" class="mt-2" />

                            <x-jet-label for="memo_recipient" value="{{ __('Memo Recipient:') }}" class="pt-3" />
                            <select id="memo_recipient" name="memo_recipient[]" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Search" style="width: 100%;" multiple="multiple">
                                <!-- <option value="">-Select Recipient</option> -->
                                @foreach ($employees as $key=>$employee)
                                <option value="{{ $employee->employee_id }}">{{ $employee->last_name.', '.$employee->first_name }}</option>
                                @endforeach
                            </select>
                            <x-jet-input-error for="memo_recipient" class="mt-2" />
                        </div>

                        <div class="px-2 pt-3">
                            <div class="input-group mb-3">

                              <div class="custom-file">
                                <x-jet-input type="file" class="custom-file-input" id="inputGroupFile02" name="inputGroupFile02[]"
                                disabled multiple/>

                                <x-jet-label class="custom-file-label" for="inputGroupFile02" value="{{ __('Choose File') }}" />
                              </div>
                            </div>
                        </div>

                        <div class="p-1">
                            <div class="input-group mb-3 items-center justify-center">
                              <div class="input-group-append">
                                <x-jet-button class="btn btn-secondary btn-sm" id="preview_memo" value="{{ __('Preview') }}" disabled>{{ __('Preview') }}</x-jet-button>
                              </div>
                              <div class="input-group-append">
                                <x-jet-button class="btn btn-primary btn-sm" id="send_memo" value="{{ __('Preview') }}" disabled>{{ __('Send Memo') }}</x-jet-button>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </form>
        </div>

        </div>
    </div>

<!-- =========================================== -->
<!-- Modal for History -->
<div class="modal fade" id="modalMemoCreation" tabindex="-1" role="dialog" aria-labelledby="memoCreationLabel" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-lg" id="leaveHistoryLabel">
            Memo Creation
        </h4>
        <button id="closeModal" type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body bg-gray-50">
            <div class="grid grid-cols-6 gap-6 pb-3">
                <div class="col-span-6 sm:col-span-6 sm:justify-center font-medium scrollable">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="card-body">
                                    <form method="post" action="" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <textarea class="ckeditor form-control" name="wysiwyg-editor"></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>
<!-- =========================================== -->


<?php 

// $homepage = file_get_contents('http://www.example.com/');
// echo $homepage;
?>

<script>
$(document).ready(function(){

    Pusher.logToConsole = true;

    var pusher = new Pusher('264cb3116052cba73db3', {
      cluster: 'us2',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind("my-event", function(data) {
      // alert(data);
      // alert(JSON.stringify(data));
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          // url: window.location.origin+'/file-preview-memo',
          url: "{{ route('counts_pusher') }}",
          method: 'get',
          data: JSON.stringify(data), // prefer use serialize method
          success:function(data){
            // $("#nav-memo-counter").text(data.memo_counts);

            $("#g_count").text(data.memo_g_counts);
            $("#s_count").text(data.memo_s_counts);
            // alert('Hey Gibs');
          }
      });
    }); 


  $("#general-tab").on('click', function() {
    $("[name='g-memo-list[]']").each(function() {
      $(this).removeClass('active');
      $("#preview-memo").attr('src','');
    });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('memo.data') }}",
            method: 'get',
            // data: { 'file_path':  }, // prefer use serialize method
            success:function(data){
              // prompt('',data);
              $("#general-list-tab").empty();
              append_memo(data,"g");
            }
        });
  });

  $("#specific-tab").on('click', function() {
    $("[name='p-memo-list[]']").each(function(){
      $(this).removeClass('active');
      $("#preview-memo").attr('src','');
    });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('memo.data') }}",
            method: 'get',
            // data: { 'file_path':  }, // prefer use serialize method
            success:function(data){
              // prompt('',data);
              $("#personal-list-tab").empty();
              //
              append_memo(data,"p");
              // view_memo("[name='p-memo-list[]']");
            }
        });
  });


  $("[name='g-memo-list[]']").each(function() {
    $(this).on('click', function() {
    var memo_id_ee = $(this).attr('id');
      // alert('Gibs');
      // prompt('',"{{ str_replace('\\', '/', public_path('storage/memo-files/')) }}"+$(this).data('value'));
      // $("#preview-memo").attr('src', "{{ asset('storage/memo-files') }}/"+$(this).data('value'));
    $("[name='g-memo-list[]']").removeClass('active');
      $(this).removeClass('bg-viewed');
      $(this).addClass('active');

      bg_memo_viewed ("g",$(this).attr('id'));

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            // url: window.location.origin+'/file-preview-memo',
            url: "{{ route('view.memo') }}",
            method: 'get',
            data: { 'file_path': "{{ str_replace('\\', '/', public_path('storage/memo-files/')) }}"+$(this).data('value') }, // prefer use serialize method
            success:function(data){
              // prompt('',data);
                $("#preview-memo").removeAttr('src');
                $("#preview-memo").attr('src',data);
                $("[name='"+memo_id_ee+"']").val(1);
                memo_viewed(memo_id_ee)
                move(20);
            }
        });
    return false;
    });

  });

  function bg_memo_viewed (option,selected) {
    // alert(option+'\n'+selected);
    $("[name='"+option+"-memo-list[]']").each(function() {
      if ($(this).attr('id')!=selected) {
        if ($("[name='"+$(this).attr('id')+"']").val()==1) {
          $(this).addClass('bg-viewed');
        }
      }``
    });
    return false;
  }


  function append_memo(data, option) {
    var list_tab='';
    var bg_viewed='';
    if (option=='g') {
      list_tab = "#general-list-tab";
    } else {
      list_tab = "#personal-list-tab";
    }

      for (var n=0; n<data.length; n++) {
        // prompt('',data[n]['memo_send_option'] + '\n' +option);
        if (data[n]['memo_send_option']==option) {
          // prompt('', data[n]['memo_subject']);
          if (data[n]['is_viewed']==1) { bg_viewed = 'bg-viewed'; } else { bg_viewed = ''; }
          $(list_tab).append('<a class="list-group-item list-group-item-action cut-text '+bg_viewed+'" data-value="'+data[n]['file_name']+'" name="'+option+'-memo-list[]" id="'+data[n]['id']+'" data-toggle="list" href="#list-home" role="tab" aria-controls="home">'+data[n]['uploaded_at']+' - '+data[n]['memo_subject']+'</a>');
          $(list_tab).append('<input type="hidden" name="'+data[n]['id']+'" value="'+data[n]['is_viewed']+'">');
        }
      }
      view_memo("[name='"+option+"-memo-list[]']", option);
  }

  function view_memo(input_name, option='') {
    // alert(input_name);
        $(input_name).each(function() {
          $(this).on('click', function() {
            var memo_id_ee = $(this).attr('id');
            $(input_name).removeClass('active');
            $(input_name).removeClass('bg-viewed');
            bg_memo_viewed (option,$(this).attr('id'));
            $(this).addClass('active');
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                  // url: window.location.origin+'/file-preview-memo',
                  url: "{{ route('view.memo') }}",
                  method: 'get',
                  data: { 'file_path': "{{ str_replace('\\', '/', public_path('storage/memo-files/')) }}"+$(this).data('value') }, // prefer use serialize method
                  success:function(data){
                    // prompt('',data);
                      $("#preview-memo").removeAttr('src');
                      $("#preview-memo").attr('src',data);
                      $("[name='"+memo_id_ee+"']").val(1);
                      memo_viewed(memo_id_ee);
                      move(20);
                  }
              });
          return false;
          });
        });
  } // End view_memo method

  function memo_viewed(id) {
    // alert ('Help me Lord');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        // url: window.location.origin+'/file-preview-memo',
        url: "{{ route('memo.viewed') }}",
        method: 'post',
        data: { 'id': id }, // prefer use serialize method
        success:function(data){
          // alert(data);
        }
    });
  }



    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    var memo_ctr = 0;

    if(window.matchMedia("(max-width: 767px)").matches){
        // The viewport is less than 768 pixels wide
        $("#desktop-view").hide();
        $("#mobile-view").show();
    } else{
        // The viewport is at least 768 pixels wide
        $("#desktop-view").show();
        $("#mobile-view").hide();
    }

    function send_memo_validation() {
      var memo_subject      = $("#memo_subject").val(),
          memo_send_option  = $("#memo_send_option").val(),
          memo_file         = $("#inputGroupFile02").val(),
          memo_department   = $("#memo_department").val(),
          memo_recipient    = $("#memo_recipient").select2('val');
          memo_ctr=0;

      if ($.trim(memo_subject)=='') {
        memo_ctr++
      }
      if ($.trim(memo_send_option)=='') {
        memo_ctr++
      }
      if ($.trim(memo_file)=='') {
        memo_ctr++
      }
      if (memo_send_option=='p') {
        if ($.trim(memo_department)=='') {
          if (memo_recipient.length==0) {
            memo_ctr++
          }
        }
      }
      if ($.trim($("#preview-memo").attr('src'))=='') {
        memo_ctr++;
      }

      if (memo_ctr>0) {
        $("#send_memo").prop('disabled',true);
      } else {
        $("#send_memo").prop('disabled',false);
      }

    }

    $('.custom-file-input').on('change', function() {
        // alert($(this).val());return false;
              // Get the selected file
              var files = $('#inputGroupFile02')[0].files;
              var file_extension = $('#inputGroupFile02').val().split('.').pop();

              if(files.length > 0){
                switch (file_extension) {
                    case 'docx': case 'pdf': case 'png': case 'jpg': case 'jpeg': case 'gif':
                         var fd = new FormData();

                         // Append data 
                         fd.append('file',files[0]);
                         fd.append('_token',CSRF_TOKEN);

                         // Hide alert 
                         // $('#responseMsg').hide();

                         // AJAX request 
                         // $.ajax({
                         //   url: "{{route('uploadFile')}}",
                         //   method: 'post',
                         //   data: fd,
                         //   contentType: false,
                         //   processData: false,
                         //   // dataType: 'json',
                         //   success: function(data){
                         //    // prompt('',data);
                         //     // $("#file_created").val(data);
                             $("#preview_memo").prop("disabled",false);
                         //   },
                         //   error: function(response){
                         //      console.log("error : " + JSON.stringify(response) );
                         //   }
                         // });
                         let fileName = $(this).val().split('\\').pop();
                         $(this).next('.custom-file-label').addClass("selected").html(fileName); 
                     break;
                     default:
                        $("#preview_memo").prop("disabled",true);
                        alert('Unsupported file!');
                     break;
                }
              }/*else{
                 $("#preview_memo").prop("disabled",true);
                 alert("Please select a file.");
              }*/


    });


    $("#memo_send_option").on('change', function() {
        if ($(this).val()=='') {
            $("#inputGroupFile02").prop('disabled',true);
        } else {
            $("#inputGroupFile02").prop('disabled',false);
            if($(this).val()=='p') {
                $("#div_memo_recepients").removeClass('hidden');
            } else {
                $("#div_memo_recepients").addClass('hidden');
            }   
        }
    });

    $("#memo_upload_create").on('change',function() {
      if ($(this).val()=='c') {
        $("#modalMemoCreation").modal('show');

      }
    });

    $('#closeModal').click(function () {
      $("#memo_upload_create").val('u');
    });

    $("#memo_subject").on('change paste keyup keydown', function() {
       send_memo_validation();
    });
    $("#memo_send_option").on('change', function() {
       send_memo_validation();
    });
    $("#inputGroupFile02").on('change paste keyup keydown', function() {
       send_memo_validation();
    });
    $("#memo_department").on('change paste keyup keydown', function() {
       send_memo_validation();
    });
    $("#memo_recipient").on('change paste keyup keydown', function() {
       send_memo_validation();
    });

    $("#memo_recipient").select2({
      placeholder: 'Select Recipient/s',
      width: 'resolve'
    });

    $('#preview_memo').on('click', function() {
              var files = $('#inputGroupFile02')[0].files;
              var file_extension = $('#inputGroupFile02').val().split('.').pop();

              if(files.length > 0){
                switch (file_extension) {
                    case 'docx': case 'pdf': case 'png': case 'jpg': case 'jpeg': case 'gif':
                         var fd = new FormData();

                         // Append data 
                         fd.append('file',files[0]);
                         fd.append('_token',CSRF_TOKEN);

                         // Hide alert 
                         // $('#responseMsg').hide();

                         // AJAX request 
                         $.ajax({
                           url: "{{route('tmp.file.preview')}}",
                           method: 'post',
                           data: fd,
                           contentType: false,
                           processData: false,
                           // dataType: 'json',
                           success: function(data){
                            // alert("{{ route('file.preview') }}"); return false;
                              $.ajaxSetup({
                                  headers: {
                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  }
                              });
                              $.ajax({
                                  // url: window.location.origin+'/file-preview-memo',
                                  url: "{{ route('file.preview') }}",
                                  method: 'get',
                                  // data: $("#memo-form").serialize(), // prefer use serialize method
                                  data: { 'file': $("#inputGroupFile02").val() }, // prefer use serialize method
                                  success:function(data){
                                      $("#preview-memo").removeAttr('src');
                                      $("#preview-memo").attr('src',data);
                                      send_memo_validation();
                                      move(20);
                                  }
                              });
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
              }
            return false;
    });

    $("#send_memo").on('click', function() {
      // prompt('',$("#memo-form").serialize()); return false;
        var files = $('#inputGroupFile02')[0].files;
        var file_extension = $('#inputGroupFile02').val().split('.').pop();

        if(files.length > 0){
          switch (file_extension) {
              case 'docx': case 'pdf': case 'png': case 'jpg': case 'jpeg': case 'gif':
                   var fd = new FormData();
                   // prompt('',fd.length); return false;

                   // Append data 
                   fd.append('file',files[0]);
                   fd.append('_token',CSRF_TOKEN);
                   fd.append('memo_subject',$("#memo_subject").val());
                   fd.append('send_option',$("#memo_send_option").val());
                   if ($("#memo_send_option").val()=='p') {
                    fd.append('department',$("#memo_department").val());
                    fd.append('recipient', $("#memo_recipient").val());
                   }

                   // Hide alert 
                   $('#responseMsg').hide();

                   // AJAX request 
                   $.ajax({
                     url: "{{route('send.memo')}}",
                     method: 'post',
                     data: fd,
                     contentType: false,
                     processData: false,
                     // dataType: 'json',
                     beforeSend: function (xhr) {
                        $("#loadingModal").modal("show");
                     },
                     success: function(data){
                      // prompt('',data);
                      // alert('success?');
                        $("#loadingModal").modal("hide");
                        $("#loadingModal").removeClass("in");
                        // $("#loadingModal").addClass("hidden");
                     },
                     error: function(response){
                        console.log("error : " + JSON.stringify(response) );
                     }
                   });
                   /*let fileName = $(this).val().split('\\').pop();
                   $(this).next('.custom-file-label').addClass("selected").html(fileName); */
               break;
               default:
                  $("#preview_memo").prop("disabled",true);
                  alert('Unsupported file!');
               break;
          }
        }
        return false;
    });

    var i = 0;
    var ctr = 0;
    function move(counts) {
        if (i == 0) {
        i = 1;
        // var elem = $("#processing_bar");
        var width = 0;
        var id = setInterval(frame, (counts*2));
        var ctr_success=0;
            function frame() {
              if (width >= 100) {
                clearInterval(id);
                i = 0;
              } else {
                    // ctr_success = data;
                    ctr = ctr+(1/counts)*100;
                    width = ctr;
                    // $("#test_count").html(ctr_success+"|"+counts+"|"+ctr.toFixed(2)+"|"+leaveID[n]['id'])
                    // elem.width(width + "%");
                    if (Math.round(width)<100) {
                        // $("#processing_bar").html(width.toFixed(2) + "%");
                    } else {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            // url: window.location.origin+'/file-preview-memo',
                            url: "{{ route('remove.tmp.file') }}",
                            method: 'get',
                            data: $("#memo-form").serialize(), // prefer use serialize method
                            // data: { 'file': $("#inputGroupFile02").val() }, // prefer use serialize method
                            success:function(data){
                            }
                        });

                    }
              }
            }
        }
    }


    $('.ckeditor').ckeditor();
    CKEDITOR.replace('wysiwyg-editor', {
        filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

});
</script>

<!-- loading-blue-circle -->
<div class="modal in bg-light opacity-75" id="loadingModal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl" >
        <div class="modal-dialog-centered">  
            <img src="{{ asset('/img/misc/loading-blue-circle.gif') }}">
        </div>
    </div>
</div>
</x-app-layout>

