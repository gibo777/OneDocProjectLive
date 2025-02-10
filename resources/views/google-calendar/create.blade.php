
<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-app-layout>

    <x-slot name="header">
            {{ __('GOOGLE CALENDAR INTEGRATION') }}
    </x-slot>
    <div>
        <div class="max-w-5xl mx-auto mt-2">
            <!-- FORM start -->

            
            @if (session('status'))
                @php
                    $status = session('status');
                @endphp
                <div class="alert alert-{{ $status['type'] }}">
                    {{ $status['message'] }}
                </div>
            @endif
            
            <form action="{{ route('events.store') }}" method="POST">
            @csrf

            <div class="px-5 pt-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                <div class="row rounded my-2">
                    <div class="col-md-6 row">
                    	<div class="col-md-3">
			        		<label for="title">Title:</label>
                    	</div>
                    	<div class="col-md-9">
			        		<x-jet-input type="text" name="title" id="title" placeholder="Event Title" class="w-full" required />
                    	</div>
		        	</div>
		        	<div class="col-md-6 row">
                    	<div class="col-md-3">
				        	<label for="description">Description:</label>
                    	</div>
                    	<div class="col-md-9">
					        <x-jet-input type="text" name="description" id="description" placeholder="Event Description" class="w-full" required/>
					    </div>
		        	</div>
                </div>
            	
                <div class="row rounded">
                    <div class="col-md-6 row">
                    	<div class="col-md-4">
			        		<label for="start_time">Start Time:</label>
                    	</div>
                    	<div class="col-md-8">
			        		<input type="date" name="start_time" id="start_time" required>
                    	</div>
		        	</div>
		        	<div class="col-md-6 row">
                    	<div class="col-md-3">
					        <label for="end_time">End Time:</label>
                    	</div>
                    	<div class="col-md-9">
					        <input type="date" name="end_time" id="end_time" required>
                    	</div>
		        	</div>
                </div>


                <div class="row">
                    <!-- Upload File -->
                    <div id="div_upload" name="div_upload" class="form-floating col-md-4" hidden="true">
                        <x-jet-input id="upload_file" type="file" class="form-control mt-1 block w-full" placeholder="Attach necessary document" />
                        <x-jet-label for="upload_file" value="{{ __('Attach necessary document') }}" />

                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                </div>


                <div class="row">
	                <div class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
	                    <x-jet-button id="submitLeave" name="submitLeave">
	                        {{ __('Create Event') }}
	                    </x-jet-button>
	                </div>
                </div>
            </div>
                
            </form>
        </div>
    </div>



{{-- <script type="text/javascript">
    const curDateLeave = `{{ $department->curDate }}`;
    const empID = `{{ Auth::user()->employee_id }}`;
</script>
<script type="text/javascript" src="{{ asset('/js/modules/eleaves/eleave-form.js') }}"></script> --}}

<script type="text/javascript">
	/*$(document).ready(function() {
		$(document).on('click','#submitLeave', async function() {
			Swal.fire({ html: 'test google' }); return false;
		});
	});*/
</script>

</x-app-layout>
