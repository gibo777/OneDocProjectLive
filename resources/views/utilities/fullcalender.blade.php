<x-app-layout>
    {{-- <script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script> --}}

    <link rel="stylesheet" href="{{ asset('/full-calendar/css/fullcalendar.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('/full-calendar/css/toastr.min.css') }}" /> --}}
    <script src="{{ asset('/full-calendar/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/full-calendar/js/moment.min.js') }}"></script>
    <script src="{{ asset('/full-calendar/js/fullcalendar.js') }}"></script>
    {{-- <script src="{{ asset('/full-calendar/js/toastr.min.js') }}"></script> --}}

    {{-- <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.js') }}"></script>
<script src="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/js/hris-jquery.js') }}"></script> --}}


    <x-slot name="header">
        {{ __('LEAVE APPLICATION CALENDAR') }}
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto mt-2 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form id="leave-form" action="{{ route('calendar') }}" method="POST">
                @csrf


                <div
                    class="px-4 py-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
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
    <div class="modal fade" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="calendarLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header banner-blue py-2">
                    <h4 class="modal-title text-xl text-white" id="calendarLabel"></h4>
                    <button type="button" class="close btn fa fa-close" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"></span></button>
                </div>

                <div class="modal-body bg-gray-50">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-5 pr-5">
                                <x-jet-label for="calendar_name" value="{{ __('Name:') }}"
                                    class="font-semibold text-xs leading-tight uppercase fst-italic" />
                                <x-jet-label id="calendar_name"
                                    class="d-block text-base uppercase text-start font-semibold" />
                            </div>
                            <div class="col-md-3 pr-5">
                                <x-jet-label for="calendar_employee_id" value="{{ __('Employee #:') }}"
                                    class="font-semibold text-xs leading-tight uppercase fst-italic" />
                                <x-jet-label id="calendar_employee_id"
                                    class="d-block text-base text-start font-semibold" />
                            </div>
                            <div class="col-md-4">
                                <x-jet-label for="calendar_leave_type" value="{{ __('Leave Type:') }}"
                                    class="font-semibold text-xs leading-tight uppercase fst-italic" />
                                <x-jet-label id="calendar_leave_type"
                                    class="d-block text-base text-start text-wrap text-break font-semibold text-uppercase" />
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-8 pr-5">
                                <x-jet-label for="calendar_date_range" value="{{ __('Date Covered:') }}"
                                    class="font-semibold text-xs leading-tight uppercase fst-italic" />
                                <x-jet-label id="calendar_date_range"
                                    class="d-block text-base text-start font-semibold" />
                            </div>
                            <div class="col-md-4">
                                <x-jet-label for="no_of_days" value="{{ __('Number of Day/s:') }}"
                                    class="font-semibold text-xs leading-tight uppercase fst-italic" />
                                <x-jet-label id="no_of_days" class="d-block text-base text-start font-semibold" />
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-8 pr-5">
                                <x-jet-label for="calendar_reason" value="{{ __('Reason:') }}"
                                    class="font-semibold text-xs leading-tight uppercase fst-italic" />
                                <x-jet-label id="calendar_reason"
                                    class="d-block text-base text-start text-wrap text-break font-semibold text-uppercase" />
                            </div>
                            <div class="col-md-4">
                                <x-jet-label for="leave_status" value="{{ __('Status:') }}"
                                    class="font-semibold text-xs leading-tight uppercase fst-italic" />
                                <x-jet-label id="leave_status"
                                    class="d-block text-base text-start text-wrap text-break font-semibold text-uppercase" />
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- =========================================== -->

    <script>
        $(document).ready(function() {

            var SITEURL = "{{ url('/') }}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            // alert(JSON.stringify(holidayEvents));

            var calendar = $('#calendar').fullCalendar({
                events: SITEURL + "/fullcalendar",
                displayEventTime: false,
                editable: true,
                weekMode: 'variable', // allow the number of weeks to change dynamically
                weekNumbers: false, // show week numbers
                fixedWeekCount: false,
                contentHeight: function() {
                    // calculate the content height based on the number of weeks displayed
                    var numWeeks = $('#calendar').fullCalendar('getView').end.diff(
                        $('#calendar').fullCalendar('getView').start, 'weeks'
                    );
                    return numWeeks * 100; // set the height to be 100 pixels per week
                },
                eventTextColor: '#fff',
                eventBackgroundColor: '#206CCE',
                eventRender: function(event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                    element.attr('title', event.title);
                },
                // selectable: true,
                selectHelper: true,
                /*select: function (start, end, allDay) {
                    var title = prompt('Event Title:');
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
                    }
                },*/
                eventDrop: function(event, delta) {
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
                        success: function(response) {
                            displayMessage("Event Updated Successfully");
                        }
                    });
                },
                eventClick: function(event) {
                    if (event.color === 'red') {
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: SITEURL + '/fullcalenderAjax',
                        data: {
                            id: event.id,
                            type: 'view'
                        },
                        success: function(response) {
                            // prompt('',JSON.stringify(response));
                            $("#calendarLabel").html(('Control #' + response[
                                'control_number']).toUpperCase());
                            $("#calendar_name").html(response['name']);
                            $("#calendar_employee_id").text(response['employee_id']);
                            $("#calendar_leave_type").html(
                                response['leave_type'] + (response['others'] ? ' - ' +
                                    response['others'] : ''));
                            $("#calendar_reason").html(
                                "<pre class='m-0 text-wrap text-break'>" + response[
                                    'reason'] + "</pre>");
                            $("#calendar_date_range").html([response['date_from'], response[
                                'date_to']].join('&nbsp;&nbsp;to&nbsp;&nbsp;'));
                            $("#no_of_days").html(
                                response['no_of_days'] + (response['time_designator'] ?
                                    ' (' + response['time_designator'] + ')' : '')
                            );
                            $("#leave_status").html(response['leave_status']);
                            $("#modalCalendar").modal('show');

                        }
                    });
                }

            });

        });

        function displayMessage(message) {
            toastr.success(message, 'Event');
        }
    </script>
</x-app-layout>
