
{{-- <div class="banner-blue">
    <h7 class="modal-title text-white font-weight-bold fs-5" id="myModalLabel">Modules Viewing Authorization</h7>
</div> --}}


<div class="mx-3">

    <ul class="nav nav-pills" id="pills-tab" role="tablist">
        <!-- Personal Data Tab -->
        {{-- <li class="nav-item" role="presentation">
            <button id="pills-pd-tab" class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-pd" type="button" role="tab" aria-controls="pills-pd" aria-selected="true">
                Modules Viewing
            </button>
        </li> --}}
        {{-- @if (Auth::user()->id == 1)
        <li class="nav-item" role="presentation">
            <button id="pills-ad-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-ad" type="button" role="tab" aria-controls="pills-ad" aria-selected="false">
                Accounting Data
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button id="pills-fb-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-fb" type="button" role="tab" aria-controls="pills-fb" aria-selected="false">
                Family Background
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button id="pills-eb-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-eb" type="button" role="tab" aria-controls="pills-eb" aria-selected="false">
                Educational Background
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button id="pills-eh-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-eh" type="button" role="tab" aria-controls="pills-eh" aria-selected="false">
                Employment History
            </button>
        </li>
        @endif --}}
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <!-- Personal Data Tab Content -->
        <div class="tab-pane fade show active" id="pills-pd" role="tabpanel" aria-labelledby="pills-pd-tab">
        <form id="fUpdateEmployee" method="POST" enctype="multipart/form-data">
        @csrf
                {{-- <div class="col-md-12 text-left border-1">
                    <div class="row my-1 pt-1 ">
                        <div class="col-md-3 px-1">
                            <x-jet-label id="fullName" value="Name: {{ $userDetails->name }}" class="w-full text-md" />
                        </div>
                        <div class="col-md-3 px-1">
                            <x-jet-label id="homeAddress" value="Employee #: {{ $userDetails->employee_id }}" class="w-full text-md text-wrap" />
                        </div>
                        <div class="col-md-3 px-1">
                            <x-jet-label id="homeCountry" value="Office: {{ $userDetails->office }}" class="w-full text-md" />
                        </div>
                        <div class="col-md-3 px-1">
                            <x-jet-label id="homeZipCode" value="Department: {{ $userDetails->department }}" class="w-full text-md" />
                        </div>
                    </div>
                </div> --}}

            <div class="row my-1">
                <table class="table table-bordered table-auto w-auto text-nowrap small m-0 p-0">
                    <thead class="inset-shadow">
                        <tr>
                            <th colspan="4" class="text-center py-1">Modules Viewing Assignment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name: <b>{{ $userDetails->name }}</b></td>
                            <td>Employee #: <b>{{ $userDetails->employee_id }}</b></td>
                            <td>Office: <b>{{ $userDetails->office }}</b></td>
                            <td>Department: <b>{{ $userDetails->department }}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="row my-1">
                <table class="table table-bordered table-auto text-nowrap small w-full">
                    <thead class="banner-blue">
                        <tr>
                            <th class="text-center py-1" style="width: 30%;">Modules Name</th>
                            <th class="text-center py-1">Assigned Office</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-sm-left align-content-center py-0">
                                {{ __('Leaves Listing') }}
                            </td>
                            <td class="py-0">
                                <select wire:model="m1Office" name="m1Office" id="m1Office" multiple>
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-left align-content-center py-0">
                                {{ __('Timelogs Listing') }}
                            </td>
                            <td class="py-0">
                                <select wire:model="m2Office" name="m2Office" id="m2Office" multiple>
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-left align-content-center py-0">
                                {{ __('Employees Listing') }}
                            </td>
                            <td class="py-0">
                                <select wire:model="m3Office" name="m3Office" id="m3Office" multiple>
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- <div class="row my-1 pt-1">
                <div class="col-md-4 px-1 my-1">
                    <div>
                        <x-jet-label for="m1Office" value="{{ __('Leaves Listing') }}" class="pl-4 text-black-50 w-full" />
                    </div>
                </div>
                <div class="col-md-8 text-left align-items-center w-full nopadding border-1">
                    <select wire:model="m1Office" name="m1Office" id="m1Office" multiple>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row my-1 pt-1">
                <div class="col-md-4 px-1 my-1">
                    <div>
                        <x-jet-label for="m2Office" value="{{ __('Timelogs Listing') }}" class="pl-4 text-black-50 w-full" />
                    </div>
                </div>
                <div class="col-md-8 text-left align-items-center w-full nopadding border-1">
                    <select wire:model="m2Office" name="m2Office" id="m2Office" multiple>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row my-1 pt-1">
                <div class="col-md-4 px-1 my-1">
                    <div>
                        <x-jet-label for="m3Office" value="{{ __('Employees Listing') }}" class="pl-4 text-black-50 w-full" />
                    </div>
                </div>
                <div class="col-md-8 text-left align-items-center w-full nopadding border-1">
                    <select wire:model="m3Office" name="m3Office" id="m3Office" multiple>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}


			<div class="text-center justify-content-center my-2">
			<x-jet-button id="saveModuleView">Save</x-jet-button>
			</div>
		</form>
        </div>


        <!-- Additional Tab Contents -->
        @if (Auth::user()->id == 1)
        <div class="tab-pane fade" id="pills-ad" role="tabpanel" aria-labelledby="pills-ad-tab">
            <!-- Content for Accounting Data Tab -->
        </div>
        <div class="tab-pane fade" id="pills-fb" role="tabpanel" aria-labelledby="pills-fb-tab">
            <!-- Content for Family Background Tab -->
        </div>
        <div class="tab-pane fade" id="pills-eb" role="tabpanel" aria-labelledby="pills-eb-tab">
            <!-- Content for Educational Background Tab -->
        </div>
        <div class="tab-pane fade" id="pills-eh" role="tabpanel" aria-labelledby="pills-eh-tab">
            <!-- Content for Employment History Tab -->
        </div>
        @endif
    </div>


</div>

