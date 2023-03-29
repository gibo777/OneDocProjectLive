
<x-jet-form-module submit="submitLeave">
    <x-slot name="form">
        <!-- Name -->

        <div class="col-span-5 sm:col-span-2">
            <x-jet-label for="name" value="{{ __('NAME') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" value="{{ Auth::user()->name }}" />
            <?php  //value="{{ Auth::user()->name }}" ?>

            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Department -->
        <div class="col-span-5 sm:col-span-1">
            <x-jet-label for="department" value="{{ __('DEPARTMENT') }}" />
            <?php /*<x-jet-input id="department" type="text" class="mt-1 block w-full" wire:model.defer="state.department" value="{{ Auth::user()->department }}" />
            <x-jet-input-error for="department" class="mt-2" />*/
            ?>
            {{ view('utilities.dropdown')}}
            <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
        </div>

        <!-- Date Applied -->
        <div class="col-span-5 sm:col-span-1">
            <x-jet-label for="date_applied" value="{{ __('DATE APPLIED') }}" />
            <x-jet-input id="date_applied" type="date" class="mt-1 block w-full" wire:model.defer="state.date_applied" />
            <x-jet-input-error for="date_applied" class="mt-2" />
        </div>

        <!-- Employee Number -->
        <div class="col-span-5 sm:col-span-2">
            <x-jet-label for="employee_number" value="{{ __('EMPLOYEE #') }}" />
            <x-jet-input id="employee_number" type="text" class="mt-1 block w-full" wire:model.defer="state.employee_number" value="{{ Auth::user()->employee_id }}" />
            <x-jet-input-error for="employee_number" class="mt-2" />
        </div>

        <!--  Leave Type -->
        <div class="col-span-3 sm:col-span-1">
            <x-jet-label for="leave_type" value="{{ __('LEAVE TYPE') }}" class="font-semibold text-gray-800 leading-tight" />
            <select name="leave_type" id="leave_type" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                <option value="">Select Leave Type</option>
                <option value="VL">Vacation Leave (VL)</option>
                <option value="SL">Sick Leave (SL)</option>
                <option value="ML">Maternity Leave (ML)</option>
                <option value="PL">Paternity Leave (PL)</option>
                <option value="EL">Emergency Leave (EL)</option>
                <option value="Others">Others</option>
            </select>
            <div id="div_others" name="div_others" hidden="true">
            <x-jet-input id="others_leave" name="others_leave" type="text" class="mt-1 block w-full" hidden="true" wire:model.defer="state.others" placeholder="Specify leave here..." />
            <x-jet-input-error for="others" class="mt-2" />
            </div>
        </div>

        <!-- Reason for Leave -->
        <div class="col-span-5 sm:col-span-2">
            <x-jet-label for="reason" value="{{ __('REASON') }}" class="font-semibold text-gray-800 leading-tight"/>
            <textarea id="reason" name="reason" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" wire:model.defer="state.employee_number" /> </textarea>
            <x-jet-input-error for="employee_number" class="mt-2" />

        </div>


        <!-- Notification of Leave -->
        <div class="col-span-5 sm:col-span-5 sm:justify-center">
            <x-jet-label for="leave_notification" value="{{ __('NOTIFICATION OF LEAVE') }}" class="font-semibold text-xl text-gray-800 leading-tight"/>
        </div>

        <div class="col-span-5 sm:col-span-1">
            <x-jet-input id="leave_notification" type="checkbox" value="IN PERSON" wire:model.defer="state.leave_notification" />IN PERSON
        </div>
        <div class="col-span-5 sm:col-span-1">
            <x-jet-input id="leave_notification" type="checkbox" value="IN PERSON" wire:model.defer="state.leave_notification" />BY SMS
        </div>
        <div class="col-span-5 sm:col-span-3">
            <x-jet-input id="leave_notification" type="checkbox" value="IN PERSON" wire:model.defer="state.leave_notification" />BY E-MAIL
        </div>

            <!-- Date Covered -->
            <div class="col-span-5 sm:col-span-2" id="div_date_covered">
                    <x-jet-label for="date_from" value="{{ __('DATE COVERED') }}" />
                    <x-jet-input id="date_from" name="date_from" type="date" class="" wire:model.defer="state.date_from" />
                    <x-jet-input-error for="date_from" class="mt-2" />

                    <label class="font-semibold text-gray-800 leading-tight">TO</label>

                    <x-jet-input id="date_to" name="date_to" type="date" class="" wire:model.defer="state.date_to" />
                    <x-jet-input-error for="date_to" class="mt-2" />

                    <label for="range_notice" id="range_notice" name="range_notice"/></label>
            </div>

            <!-- Number of Days -->
            <div class="col-span-5 sm:col-span-2" id="div_number_of_days">
                    <x-jet-label for="number_of_days" value="{{ __('NUMBER OF DAY/S') }}" />
                    <label id="number_of_days" class="font-semibold text-xl text-gray-800 leading-tight items-center"></label>
            </div>

        <div class="col-span-5 sm:col-span-1 sm:justify-center">
            <table class="leave-status-table font-semibold text-gray-800 leading-tight">
                <tr><th colspan="2">STATUS</th></tr>
                <tr class="leave-status-field">
                  <th>Available</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Taken</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Balance</th>
                  <td></td>
                </tr>
                <tr>
                  <th>As of:</th>
                  <td id="td_as_of"></td>
                </tr>
              </tbody>
            </table>
        </div>


        <!-- Upload File -->
        <div id="div_upload" name="div_upload" class="col-span-5 sm:col-span-2" hidden="true">
            <x-jet-label for="upload_file" value="{{ __('Attach necessary document') }}" />
            <x-jet-input id="upload_file" type="file" class="mt-1 block w-full"/>
            <?php  //value="{{ Auth::user()->name }}" ?>

            <x-jet-input-error for="name" class="mt-2" />
        </div>


        <!-- INSTRUCTIONS -->
        <div class="col-span-5 sm:col-span-5 sm:justify-center">
            INSTRUCTIONS:
            <ol>
                <li>
                    1. Application for leave of absence must be filed at the latest, 
                    three (3) working days prior to the date of leave. &nbsp; In case of emergency,
                    it must be filed immediately upon reporting for work.
                </li>
                <li>
                    2. Application for sick leave of more than two (2) consecutive days must be supported by a medical certificate.
                </li>
            </ol>
        </div>


        


        <!-- DEPARTMENT HEAD -->
        <!-- <div class="col-span-5 sm:col-span-5 sm:justify-center text-center">
            <x-jet-label for="name" value="{{ __('DEPARTMENT HEAD') }}" class="font-semibold text-xl text-gray-800 leading-tight"/>
        </div> -->
        
        <!-- HUMAN RESOURCED DEPARTMENT -->
        <!-- <div class="col-span-5 sm:col-span-5 text-center">
            <x-jet-label for="name" value="{{ __('HUMAN RESOURCES DEPARTMENT') }}" class="font-semibold text-xl text-gray-800 leading-tight" />
        </div> -->
    </x-slot>

    <x-slot name="actions">
        <x-jet-button id="submit_leave" name="submit_leave" wire:loading.attr="disabled" wire:target="photo">
            {{ __('SUBMIT LEAVE FORM') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-module>

