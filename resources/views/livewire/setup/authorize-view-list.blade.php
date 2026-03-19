<x-slot name="header">
    {{ __('USER AUTHORIZATION') }}
</x-slot>

<div id="view_list">
    <div class="w-full p-0">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- ============================================================ --}}
        {{-- LISTING VIEW --}}
        {{-- ============================================================ --}}
        @if (!$selectedUserId)

            <div
                class="bg-white sm:p-6 shadow m-0 {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                {{-- FILTERS AND FORM BUTTON - START --}}
                <div class="container-fluid">
                    <div class="row g-2 pb-2 px-1 align-items-end inset-shadow">

                        <!-- Office -->
                        <div class="col-12 col-md-2 px-1">
                            <div class="form-floating w-100">
                                <select wire:model="fUserOffice" id="fUserOffice" class="form-select w-100">
                                    <option value="">All Offices</option>
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                                    @endforeach
                                </select>
                                <label for="fUserOffice">{{ __('OFFICE') }}</label>
                            </div>
                        </div>

                        <!-- Department -->
                        <div class="col-12 col-md-2 px-1">
                            <div class="form-floating w-100">
                                <select wire:model="fTLDept" id="fTLDept" class="form-select w-100">
                                    <option value="">All Departments</option>
                                    {{-- @foreach ($departments as $department)
                                        <option value="{{ $department->department_code }}">{{ $department->department }}</option>
                                    @endforeach --}}
                                </select>
                                <label for="fTLDept">{{ __('DEPARTMENT') }}</label>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-12 col-md-2 px-1">
                            <div class="form-floating w-100">
                                <select wire:model="fOTStatus" id="fOTStatus" class="form-select w-100">
                                    <option value="">All Statuses</option>
                                    {{-- @foreach ($lStatus as $status)
                                        <option>{{ $status->request_status }}</option>
                                    @endforeach --}}
                                </select>
                                <label for="fOTStatus">{{ __('STATUS') }}</label>
                            </div>
                        </div>

                        <!-- Roles -->
                        <div class="col-12 col-md-2 px-1">
                            <div class="form-floating w-100">
                                <select wire:model="fUserRole" id="fUserRole" class="form-select w-100">
                                    <option value="">All Roles</option>
                                    @foreach ($roleTypes as $roles)
                                        <option value="{{ $roles->role_type }}">{{ $roles->role_type }}</option>
                                    @endforeach
                                </select>
                                <label for="fUserRole">{{ __('ROLES') }}</label>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- FILTERS AND FORM BUTTON - END --}}

                <div id="table_data">

                    <!-- Top Pagination -->
                    <div class="row">
                        <div class="col-md-12 text-sm pl-4">
                            <div class="form-inline mt-1">
                                <label for="pageSize" class="mr-2">Show:</label>
                                <select wire:model="pageSize" id="pageSize"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md py-1">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <span class="mx-2">entries</span>
                                <div class="sm:col-span-7 sm:justify-center scrollable">
                                    {{ $authorizeUser->links('pagination.custom') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                        <div class="table-responsive">
                            <table id="dataTimeLogs"
                                class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover text-sm">
                                <thead class="thead">
                                    <tr class="dt-head-center">
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Employee #</th>
                                        <th class="text-nowrap">Office</th>
                                        <th class="text-nowrap">Department</th>
                                        <th class="text-nowrap">Assigned Office/s</th>
                                        <th class="text-nowrap">Role</th>
                                        <th class="text-nowrap">Employment Status</th>
                                    </tr>
                                </thead>
                                <tbody class="data hover custom-text-xs" id="viewEmployee">
                                    @if ($authorizeUser->isNotEmpty())
                                        @foreach ($authorizeUser as $record)
                                            <tr id="{{ $record->id }}" class="view-user"
                                                wire:dblclick="selectUser({{ $record->id }})"
                                                style="cursor: pointer;">
                                                @if (url('/') == 'http://localhost')
                                                    <td class="text-nowrap">xxx, xxx x.</td>
                                                @else
                                                    <td class="text-nowrap text-left">{{ $record->name }}</td>
                                                @endif
                                                <td class="text-nowrap">{{ $record->employee_id }}</td>
                                                <td class="text-nowrap">{{ $record->office }}</td>
                                                <td class="text-nowrap">{{ $record->department }}</td>
                                                <td class="text-nowrap">
                                                    {{ $record->assigned_offices ?? '-' }}
                                                </td>
                                                <td class="text-nowrap">{{ $record->role_type }}</td>
                                                <td class="text-nowrap">{{ $record->employment_status }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">No Matching Records Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Bottom Pagination -->
                        <div class="col-md-12 text-sm">
                            <div class="form-inline mt-1">
                                <label for="pageSize" class="mr-2">Show:</label>
                                <select wire:model="pageSize" id="pageSize"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md py-1">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <span class="mx-2">entries</span>
                                <div class="sm:col-span-7 sm:justify-center scrollable">
                                    {{ $authorizeUser->links('pagination.custom') }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>{{-- end listing bg-white --}}

            {{-- ============================================================ --}}
            {{-- DETAIL VIEW --}}
            {{-- ============================================================ --}}
        @else
            <div class="max-w-7xl mx-auto mt-2">
                <div class="px-5 pt-3 sm:p-3 shadow bg-white sm:rounded-md">

                    <!-- Back Button -->
                    <div class="mb-3">
                        <button wire:click="clearSelectedUser" class="btn btn-sm btn-secondary">
                            <i class="fa-solid fa-arrow-left"></i>&nbsp;Back to List
                        </button>
                    </div>

                    <!-- User Info -->
                    @if ($selectedUser)
                        <div class="w-full px-2 py-2 mb-3 border rounded">
                            <div class="row">
                                <div class="col-6 col-md-3 pt-1">
                                    <x-jet-label value="{{ __('NAME') }}" class="w-full" />
                                    <h6 class="mb-0">
                                        @if (url('/') == 'http://localhost')
                                            Xxx, Xxx x.
                                        @else
                                            {{ $selectedUser['name'] }}
                                        @endif
                                    </h6>
                                </div>
                                <div class="col-6 col-md-2 pt-1">
                                    <x-jet-label value="{{ __('EMPLOYEE #') }}" class="w-full" />
                                    <h6 class="mb-0">{{ $selectedUser['employee_id'] }}</h6>
                                </div>
                                <div class="col-6 col-md-3 pt-1">
                                    <x-jet-label value="{{ __('OFFICE') }}" class="w-full" />
                                    <h6 class="mb-0">{{ $selectedUser['office'] }}</h6>
                                </div>
                                <div class="col-6 col-md-2 pt-1">
                                    <x-jet-label value="{{ __('DEPARTMENT') }}" class="w-full" />
                                    <h6 class="mb-0">{{ $selectedUser['department'] }}</h6>
                                </div>

                                <div class="col-6 col-md-2 pt-1">
                                    <x-jet-label value="{{ __('ROLE') }}" class="w-full" />
                                    {{-- <h6 class="mb-0">{{ $selectedUser['role_type'] }}</h6> --}}
                                    <div class="form-floating w-100">
                                        <select wire:model="aUserRole" id="aUserRole" class="form-select w-100">
                                            <option value="">- Select Role -</option>
                                            @foreach ($roleTypes as $roles)
                                                <option value="{{ $roles->role_type }}">
                                                    {{ $roles->role_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="aUserRole">{{ __('ROLES') }}</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    <!-- Modules Section -->
                    @if (in_array($aUserRole, ['ADMIN', 'SUPER ADMIN']))
                        <div class="mb-3 border rounded" style="overflow: visible;">
                            <div class="d-flex flex-column flex-md-row">

                                <!-- CURRENT ASSIGNED OFFICE/S -->
                                <div class="flex-fill border-end">
                                    <div class="p-2 border-bottom">
                                        <x-jet-label value="{{ __('CURRENT ASSIGNED OFFICE/S') }}"
                                            class="w-full bg-light" />
                                        <div class="mt-1">
                                            @if (!empty($selectedModules))
                                                @foreach ($selectedModules as $module)
                                                    @php
                                                        $assignedOffices = !empty($module['assigned_office'])
                                                            ? explode('|', $module['assigned_office'])
                                                            : [];
                                                    @endphp
                                                    <div class="mb-1">
                                                        @if (!empty($module['assigned_office_names']))
                                                            @foreach (explode(', ', $module['assigned_office_names']) as $officeName)
                                                                <span
                                                                    class="badge bg-secondary me-1 mb-1">{{ $officeName }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted fst-italic">— None assigned</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-muted fst-italic">No Records Found.</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- ASSIGN NEW OFFICE/S -->
                                <div class="flex-fill position-relative">
                                    <div class="p-2 border-bottom">
                                        <x-jet-label value="{{ __('ASSIGN NEW OFFICE/S') }}"
                                            class="w-fulll bg-light" />
                                        <div class="mt-1">
                                            @if (!empty($selectedModules))
                                                @foreach ($selectedModules as $module)
                                                    @php
                                                        $assignedOffices = !empty($module['assigned_office'])
                                                            ? explode('|', $module['assigned_office'])
                                                            : [];
                                                    @endphp
                                                    <select class="module-office"
                                                        data-module-id="{{ $module['id'] }}" multiple="multiple"
                                                        style="width: 100%;">
                                                        @foreach ($offices as $office)
                                                            <option value="{{ $office->id }}"
                                                                {{ in_array((string) $office->id, array_map('strval', $assignedOffices)) ? 'selected' : '' }}>
                                                                {{ $office->company_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endforeach
                                            @else
                                                <span class="text-muted fst-italic">No Records Found.</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    <!-- Save Button -->
                    <div class="flex items-center justify-center px-4 py-3 sm:px-6">
                        <x-jet-button id="saveAssigned" data-user-id="{{ $selectedUserId }}">
                            <i class="fa-solid fa-floppy-disk"></i>&nbsp;Save Assignment
                        </x-jet-button>
                    </div>

                </div>
            </div>

        @endif
        {{-- END DETAIL VIEW --}}

    </div>
</div>

<style>
    #view_list .module-office+.multiselect-container {
        z-index: 9999 !important;
        position: absolute !important;
    }
</style>

<script>
    function initMultiselects() {
        $('.module-office').each(function() {
            if ($(this).data('multiselect')) {
                $(this).multiselect('destroy');
            }
            $(this).multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                buttonWidth: '100%',
                maxHeight: 300,
                includeSelectAllOption: true,
                selectAllText: 'Select All',
                nonSelectedText: 'None selected',
                allSelectedText: 'All selected',
                buttonClass: 'btn btn-sm btn-outline-secondary w-100 text-start',
                buttonText: function(options, select) {
                    if (options.length === 0) return 'None selected';
                    if (options.length === select.find('option').length - 1) return 'All selected';
                    if (options.length > 5) return options.length + ' Selected';
                    let labels = [];
                    options.each(function() {
                        labels.push($(this).text().trim());
                    });
                    return labels.join(', ');
                }
            });
        });
    }

    document.addEventListener('livewire:update', function() {
        setTimeout(function() {
            initMultiselects();
        }, 0);
    });

    window.addEventListener('detail-view-loaded', function() {
        setTimeout(function() {
            initMultiselects();
        }, 0);
    });

    $(document).on('click', '#saveAssigned', function() {
        const uID = $(this).data('user-id');
        let moduleOfficeMap = {};

        $('.module-office').each(function() {
            let moduleId = $(this).data('module-id');
            let selectedOffices = $(this).val() || [];
            moduleOfficeMap[moduleId] = selectedOffices;
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${window.location.origin}/save-authorize-viewing`,
            method: 'POST',
            data: {
                uID: uID,
                moduleOffices: moduleOfficeMap,
                aUserRole: $('#aUserRole').val()
            },
            beforeSend: function() {
                $('#dataProcess').css({
                    display: 'flex',
                    position: 'fixed',
                    top: '50%',
                    left: '50%',
                    transform: 'translate(-50%, -50%)'
                });
            },
            success: function(data) {
                $('#dataProcess').hide();

                // Swal.fire({
                //     html: JSON.stringify(data)
                // });
                // return false;

                if (data.isSuccess) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        html: 'User Authorization updated successfully.',
                        showConfirmButton: true
                    }).then(function() {
                        document.querySelector('[wire\\:click="clearSelectedUser"]')
                            .click();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: data.message
                    });
                }
            },
            error: function(xhr, status, error) {
                $('#dataProcess').hide();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: 'Something went wrong while saving.'
                });
            }
        });
    });
</script>
