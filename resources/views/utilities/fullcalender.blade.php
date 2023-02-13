<x-app-layout>
<script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>

<link rel="stylesheet" href="{{ asset('/full-calendar/css/fullcalendar.css') }}" />
<link rel="stylesheet" href="{{ asset('/full-calendar/css/toastr.min.css') }}" />
<script src="{{ asset('/full-calendar/js/jquery.min.js') }}"></script>
<script src="{{ asset('/full-calendar/js/moment.min.js') }}"></script>
<script src="{{ asset('/full-calendar/js/fullcalendar.js') }}"></script>
<script src="{{ asset('/full-calendar/js/toastr.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.js') }}"></script>
<script src="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/js/hris-jquery.js') }}"></script>


    <x-slot name="header">
            {{ __('LEAVE APPLICATION CALENDAR') }}
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
                <form id="leave-form" action="{{ route('calendar') }}" method="POST">
                @csrf


                <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                    <div class="grid grid-cols-5 gap-6 sm:justify-center">
                        <!-- Name -->
                        <div id="table_data" class="col-span-5 sm:col-span-5 sm:justify-center text-center scrollable">
                            <!-- <div id='caljump'>
                                <label for='months'>Jump to</label>
                                <select id='months'></select>
                            </div> -->
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
                    
                </form>
                </div>
            </div>
        </div>
    </div>


<!-- =========================================== -->
<!-- Modal for History -->
<div class="modal fade" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" >
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-lg" id="calendarLabel">
        </h4>
        <button type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body bg-gray-50">
        <div class="grid grid-cols-5 gap-6 ">
            <!-- Name -->
            <div class="col-span-6 sm:col-span-2 w-full">
                <x-jet-label for="calendar_name" value="{{ __('Name:') }}" class="font-semibold text-xs leading-tight uppercase" />
                <x-jet-label id="calendar_name" class="text-base uppercase"/>
            </div>

            <div class="col-span-6 sm:col-span-1 font-semibold">
                <x-jet-label for="calendar_employee_id" value="{{ __('Employee #:') }}" class="font-semibold text-xs leading-tight uppercase" />
                <x-jet-label id="calendar_employee_id" class="text-base" />
            </div>

            <div class="col-span-6 sm:col-span-1 font-semibold">
                <x-jet-label for="calendar_leave_type" value="{{ __('Leave Type:') }}" class="font-semibold text-xs leading-tight uppercase" />
                <x-jet-label id="calendar_leave_type" class="text-base" />
            </div>

            <div class="col-span-6 sm:col-span-3 font-semibold">
                <x-jet-label for="calendar_date_range" value="{{ __('Date Covered:') }}" class="font-semibold text-xs leading-tight uppercase" />
                <x-jet-label id="calendar_date_range" class="text-base" />
            </div>

            <div class="col-span-6 sm:col-span-3 font-semibold">
                <x-jet-label for="calendar_reason" value="{{ __('Reason:') }}" class="font-semibold text-xs leading-tight uppercase" />
                <x-jet-label id="calendar_reason" class="text-base" />
            </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- =========================================== -->

      <script>
         $(document).ready(function () {
            
         var SITEURL = "{{ url('/') }}";
           
         $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
           
         var calendar = $('#calendar').fullCalendar({
                             editable: true,
                             events: SITEURL + "/fullcalender",
                             displayEventTime: false,
                             editable: true,
                             eventRender: function (event, element, view) {
                                 if (event.allDay === 'true') {
                                         event.allDay = true;
                                 } else {
                                         event.allDay = false;
                                 }
                             },
                             selectable: true,
                             selectHelper: true,
                             select: function (start, end, allDay) {
                                 /*var title = prompt('Event Title:');
                                 if (title) {
                                     var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                     var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                                     $.ajax({
                                         url: SITEURL + "/fullcalenderAjax",
                                         data: {
                                             title: title,
                                             start: start,
                                             end: end,
                                             type: 'add'
                                         },
                                         type: "POST",
                                         success: function (data) {
                                             displayMessage("Event Created Successfully");
           
                                             calendar.fullCalendar('renderEvent',
                                                 {
                                                     id: data.id,
                                                     title: title,
                                                     start: start,
                                                     end: end,
                                                     allDay: allDay
                                                 },true);
           
                                             calendar.fullCalendar('unselect');
                                         }
                                     });
                                 }*/
                             },
                             eventDrop: function (event, delta) {
                                 var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                                 var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
           
                                 $.ajax({
                                     url: SITEURL + '/fullcalenderAjax',
                                     data: {
                                         title: event.title,
                                         start: start,
                                         end: end,
                                         id: event.id,
                                         type: 'update'
                                     },
                                     type: "POST",
                                     success: function (response) {
                                         displayMessage("Event Updated Successfully");
                                     }
                                 });
                             },
                             eventClick: function (event) {
                                // alert(event.id); return false;
                                 // var deleteMsg = confirm("Do you really want to delete?");
                                 // if (deleteMsg) {
                                     $.ajax({
                                         type: "POST",
                                         url: SITEURL + '/fullcalenderAjax',
                                         data: {
                                                 id: event.id,
                                                 type: 'view'
                                         },
                                         success: function (response) {
                                            // prompt('',response);
                                            $("#calendarLabel").html(('Leave #'+ response['leave_number']+" of "+response['name']).toUpperCase());
                                            $("#calendar_name").html(response['name']);
                                            $("#calendar_employee_id").html(response['employee_id']);
                                            $("#calendar_leave_type").html(response['leave_type']);
                                            $("#calendar_reason").html("<pre>"+response['reason']+"</pre>");
                                            $("#calendar_date_range").html([response['date_from'],response['date_to']].join('&nbsp;&nbsp;to&nbsp;&nbsp;'));
                                            $("#modalCalendar").modal('show');

                                            /*$("#dialog" ).dialog({
                                                modal: true,
                                                width: "auto",
                                                height: "auto",
                                                title: ("Leave #"+response['leave_number']+" of "+response['name']).toUpperCase(),
                                                buttons: [
                                                {
                                                    id: "OK",
                                                    text: "OK",
                                                    click: function () {
                                                        $(this).dialog('close');
                                                        // location.reload();
                                                    }
                                                }
                                                ]
                                            });
                                            $(".ui-dialog-titlebar").addClass('banner-blue');*/
                                            // $(".ui-dialog-titlebar").hide();
                                             // calendar.fullCalendar('removeEvents', event.id);
                                             // displayMessage("Event Deleted Successfully");
                                         }
                                     });
                                 // }
                             }
          
                         });
          
         });
          
         function displayMessage(message) {
             toastr.success(message, 'Event');
         } 
           
      </script>
   </x-app-layout>

