<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
<x-guest-layout>
	<div class="max-w-5xl mx-auto mt-6 py-3 sm:px-6 lg:px-8">
        <div class="px-2 py-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
        		@if (isset($qrProfile))
        		<div class="row px-3">
		           	<div class="col-md-3 d-flex align-items-center justify-content-center my-2" x-show="!photoPreview">
		           		@if ($qrProfile->profile_photo_path!=null)
					    	<img id="imgProfile" src="{{ asset('/storage/'.$qrProfile->profile_photo_path) }}" class="rounded h-id w-id object-cover">
					    @else
					    	@if ($qrProfile->gender=='M')
					    	<img id="imgProfile" src="{{ asset('storage/profile-photos/default-formal-male.png') }}" class="rounded h-id w-id object-cover">
					    	@elseif ($qrProfile->gender=='F')
					    	<img id="imgProfile" src="{{ asset('storage/profile-photos/default-female.png') }}" class="rounded h-id w-id object-cover">
					    	@else
					    	<img id="imgProfile" src="{{ asset('storage/profile-photos/default-photo.png') }}" class="rounded h-id w-id object-cover">
					    	@endif
					    @endif
					</div>

                    <div class="col-md-9 mt-2">
						<table id="dataViewEmployees" class="view-employees table table-bordered table-striped sm:justify-center table-hover">
						    {{-- <thead class="thead">
						        <tr class="dt-head-center">
						            <th>Name</th>
						            <th>Position</th>
						            <th>Date Hired</th>
						            <th>Status</th>
						        </tr>
						    </thead> --}}
						    <tbody class="data" id="viewEmployee">
						            <tr id="{{ $qrProfile->id }}">
						            	<td class="thead col-3 text-right">Name</td>
						                <td class="col-9 text-left">{{ join(' ',[$qrProfile->last_name.' '.$qrProfile->suffix.',',$qrProfile->first_name,$qrProfile->middle_name]) }}</td>
						            </tr>
						            <tr id="{{ $qrProfile->id }}">
						            	<td class="thead text-right">Position</td>
						                <td class="text-left">{{ $qrProfile->position}}</td>
						            </tr>
						            <tr id="{{ $qrProfile->id }}">
						            	<td class="thead text-right">Department</td>
						                <td class="text-left">{{ $qrProfile->department }}</td>
						            </tr>
						            <tr id="{{ $qrProfile->id }}">
						            	<td class="thead text-right">Date Hired</td>
						                {{-- <td>{{ date("m-d-Y",strtotime($qrProfile->date_hired)) }}</td> --}}
						                <td class="text-left">{{ ($qrProfile->date_hired == NULL || $qrProfile->date_hired=='01/01/1970') ? '' : $qrProfile->date_hired }}</td>
						            </tr>
						            <tr id="{{ $qrProfile->id }}">
						            	<td class="thead text-right">Status</td>
						                <td class="text-left font-weight-bold {{ ($qrProfile->employment_status=='NO LONGER CONNECTED') ? 'text-danger' : 'text-success' }}">
										    {{ (strtolower($qrProfile->employment_status)=='no longer connected') ? $qrProfile->employment_status : 'ACTIVE'}}
										</td>
						            </tr>
						    </tbody>
						</table>
                    </div>

	            </div>
	            @else
        		<div class="row px-3">
        			Invalid Link
        		</div>
	            @endif

            <div class="flex items-center justify-end px-3">
                <a class="underline text-md text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Go to Employee Portal') }}
                </a>
            </div>
            {{-- <div class="flex items-center justify-center mt-3">
                <span class="text-sm">Copyright © {{ env('COMPANY_NAME') }}</span>
            </div> --}}
        </div>
    </div>
</x-guest-layout>