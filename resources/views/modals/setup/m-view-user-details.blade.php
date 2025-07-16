<div class="mx-3">

            <div class="row my-1">
                <table class="table table-bordered table-auto w-auto text-nowrap small m-0 p-0">
                    <thead class="banner-blue">
                        <tr>
                            <th colspan="5" class="text-center py-1">Assign Viewing</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name: <b>{{ $userDetails->name }}</b></td>
                            <td>Employee #: <b>{{ $userDetails->employee_id }}</b></td>
                            <td>Office: <b>{{ $userDetails->office }}</b></td>
                            <td>Department: <b>{{ $userDetails->department }}</b></td>
                            <td>Role: <b>{{ $userDetails->role_type }}</b></td>
                        </tr>
                        <tr class="bg-gray-500 text-white">
                            <th class="text-center py-1" colspan="2">Module Name</th>
                            <th class="text-center py-1" colspan="3">Assigned Office</th>
                        </tr>

                        @foreach ($modules as $index => $module)
                        <tr>
                            <td colspan="2">{{ $module->module_name }}</td>
                            <td class="py-0" colspan="3">
                                <select wire:model="m{{ $index + 1 }}Office" name="m{{ $index + 1 }}Office" id="m{{ $index + 1 }}Office" multiple>
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}" @if(in_array($office->id, explode(',', $module->assigned_office))) selected @endif>{{ $office->company_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach


                        {{-- <tr>
                            <td class="text-sm-left align-content-center py-0">
                                {{ __('Leaves Listing') }}
                            </td>
                            <td class="py-0" colspan="3">
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
                            <td class="py-0" colspan="3">
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
                            <td class="py-0" colspan="3">
                                <select wire:model="m3Office" name="m3Office" id="m3Office" multiple>
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>


            {{-- <div class="row my-1">
                <table class="table table-bordered table-auto text-nowrap small w-full">
                    <thead class="banner-blue">
                        <tr>
                            <th class="text-center py-1" style="width: 30%;">Module Name</th>
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
            </div> --}}

			<div class="w-full text-center justify-content-center my-2">
			<x-jet-button id="saveAssigned">Save</x-jet-button>
			</div>

</div>

