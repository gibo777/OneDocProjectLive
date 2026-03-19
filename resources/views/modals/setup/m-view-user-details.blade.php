<!-- Header -->
<div class="banner-blue pl-2 p-1 text-md text-center fw-bold">
    {{ __('AUTHORIZE USER') }}
</div>


<!-- User Details -->
<div class="modal-body border p-2">
    <div class="d-flex flex-wrap justify-between gap-2">
        <div class="flex-grow-1 min-w-[200px]">
            <x-jet-label class="text-secondary">
                {!! __('<i class="text-sm">Name:</i>&nbsp;<strong>:name</strong>', ['name' => $userDetails->name]) !!}
            </x-jet-label>
        </div>

        <div class="flex-grow-1 min-w-[200px]">
            <x-jet-label class="text-secondary">
                {!! __('<i class="text-sm">Employee #:</i>&nbsp;<strong>:employee</strong>', [
                    'employee' => $userDetails->employee_id,
                ]) !!}
            </x-jet-label>
        </div>

        <div class="flex-grow-1 min-w-[200px]">
            <x-jet-label class="text-secondary">
                {!! __('<i class="text-sm">Office:</i>&nbsp;<strong>:office</strong>', ['office' => $userDetails->office]) !!}
            </x-jet-label>
        </div>

        <div class="flex-grow-1 min-w-[200px]">
            <x-jet-label class="text-secondary">
                {!! __('<i class="text-sm">Department:</i>&nbsp;<strong>:department</strong>', [
                    'department' => $userDetails->department,
                ]) !!}
            </x-jet-label>
        </div>

        <div class="flex-grow-1 min-w-[200px]">
            <x-jet-label class="text-secondary">
                {!! __('<i class="text-sm">Role:</i>&nbsp;<strong>:role</strong>', ['role' => $userDetails->role_type]) !!}
            </x-jet-label>
        </div>
    </div>
</div>


<div class="table-responsive my-2 w-100" style="overflow-x:auto;">
    <table class="table table-bordered text-nowrap small m-0 p-0 w-100">
        <thead class="banner-blue">
            <tr class="bg-gray-500 text-white text-center py-1">
                <th>Nav Name</th>
                <th>Assigned Office</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modules as $index => $module)
                <tr>
                    <td>{{ $module->module_name }}</td>
                    <td class="py-0">
                        <select class="form-select w-100 module-office" data-module-id="{{ $module->id }}" multiple>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}" @if (in_array($office->id, explode(',', $module->assigned_office))) selected @endif>
                                    {{ $office->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>{{ $module->module_category }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Update Button -->
<div class="flex items-center justify-center my-2">
    <x-jet-button id="saveAssigned" class="">{{ __('Update') }}</x-jet-button>
</div>
