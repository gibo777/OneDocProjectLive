
<!-- <script src="{{ asset('/js/hris-jquery.js') }}"></script> -->
<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-app-layout>
<div>
    <x-slot name="header">
            {{ __('PROCESSING E-LEAVE APPLICATION') }}
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
        <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
           
            <form id="process-leave" method="POST" action="{{ route('process.eleave') }}">
                <div class="grid grid-cols-5 gap-6 text-center sm:justify-center">
                    <!-- CUT-OFF DATE -->
                    <div class="col-span-5 sm:col-span-5" id="div_date_covered">
                            <x-jet-label for="process_date_from" value="{{ __('CUT-OFF DATE') }}" class="font-semibold text-xl"/>
                            <x-jet-input id="process_date_from" name="process_date_from" type="text" wire:model.defer="state.process_date_from" class="date-input datepicker" placeholder="mm/dd/yyyy" autocomplete="off"/>

                            <label class="font-semibold text-gray-800 leading-tight">TO</label>

                            <x-jet-input id="process_date_to" name="process_date_to" type="text" wire:model.defer="state.process_date_to" class="date-input datepicker" placeholder="mm/dd/yyyy" autocomplete="off" readonly/>
                            <x-jet-input-error for="process_date_from" class="mt-2" />
                            <x-jet-input-error for="process_date_to" class="mt-2" />
                    </div>

                    <div class="col-span-5 sm:col-span-5">
                        <x-jet-button id="btn_process" value="" disabled>{{ __('PROCESS E-LEAVE') }}</x-jet-button>
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
</x-app-layout>



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
