<x-slot name="header">
    {{ __('WFH REQUEST FORM') }}
</x-slot>

<div>
    <div class="max-w-6xl mx-auto mb-4 mt-2">

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="submitWFH">
            <div class="px-5 pt-3 bg-white sm:p-6 shadow sm:rounded-md">

                {{-- Header Info --}}
                <div class="row inset-shadow rounded">
                    <div class="col-md-5 pt-1">
                        <x-jet-label value="{{ __('NAME') }}" />
                        <h6>
                            {{ join(' ', [
                                Auth::user()->last_name . ',',
                                Auth::user()->first_name,
                                empty(Auth::user()->suffix) ? '' : Auth::user()->suffix . '',
                                Auth::user()->middle_name,
                            ]) }}
                        </h6>
                    </div>
                    <div class="col-md-4 pt-1">
                        <x-jet-label value="{{ __('EMPLOYEE #') }}" />
                        <h6>{{ Auth::user()->employee_id }}</h6>
                    </div>
                    <div class="col-md-3 pt-1">
                        <x-jet-label value="{{ __('REQUEST DATE') }}" />
                        <h6>{{ $dateApplied }}</h6>
                    </div>
                </div>

                {{-- Input Row --}}
                <div class="row inset-shadow rounded mt-1 align-items-center">
                    <div class="col-md-2 py-1 px-1 form-floating">
                        <x-jet-input wire:model.defer="newDate" id="newDate" type="date"
                            class="w-full form-control" required />
                        <x-jet-label value="{{ __('Date') }}" />
                    </div>

                    <div class="col-md-2 form-floating py-1 px-1">
                        <x-jet-input wire:model.defer="newTimeFrom" id="newTimeFrom" type="time"
                            class="w-full form-control" required />
                        <x-jet-label value="{{ __('Begin Time') }}" />
                    </div>

                    <div class="col-md-2 form-floating py-1 px-1">
                        <x-jet-input wire:model.defer="newTimeTo" id="newTimeTo" type="time"
                            class="w-full form-control" required />
                        <x-jet-label value="{{ __('End Time') }}" />
                    </div>

                    <div class="col-md-5 form-floating py-1 px-1">
                        <textarea wire:model.defer="newActivity" id="newActivity" class="w-full form-control"
                            style="min-height:58px;max-height:58px;resize:vertical;overflow-y:hidden;text-align:left;" required></textarea>
                        <x-jet-label value="{{ __('Activity') }}" />
                    </div>

                    <div class="col-md-1 py-1 px-0 d-flex align-items-center justify-content-center">
                        <x-jet-button wire:click.prevent="addActivity" id="addActivityBtn" class="w-full">
                            Add
                        </x-jet-button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="my-3" style="margin-left:-12px;margin-right:-12px;">
                    <div style="overflow-x:auto;width:100%;">
                        <table class="table table-bordered text-sm mb-0" style="min-width:850px;width:100%;">
                            <thead class="text-center">
                                <tr>
                                    <th rowspan="2" style="width:15%;">Date</th>
                                    <th colspan="2" style="width:20%;">Time</th>
                                    <th rowspan="2">Activity</th>
                                    <th rowspan="2" style="width:10%;">Action</th>
                                </tr>
                                <tr>
                                    <th style="width:10%;">Begin</th>
                                    <th style="width:10%;">End</th>
                                </tr>
                            </thead>
                            <tbody id="activityTableBody">
                                @forelse($activities as $index => $activity)
                                    <tr>
                                        <td>{{ $activity['date'] }}</td>
                                        <td>{{ $activity['from'] }}</td>
                                        <td>{{ $activity['to'] }}</td>
                                        <td style="text-align:left; white-space: pre-line;">{{ $activity['activity'] }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" wire:click.prevent="openEdit({{ $index }})"
                                                class="btn btn-primary d-inline-flex align-items-center justify-content-center me-1"
                                                style="width: 24px; height: 24px; padding: 0;" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            <button type="button"
                                                wire:click.prevent="removeActivity({{ $index }})"
                                                class="btn btn-danger d-inline-flex align-items-center justify-content-center"
                                                style="width: 24px; height: 24px; padding: 0;" title="Remove">
                                                <i class="fa-solid fa-x"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No activities added yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex row items-center justify-center mt-1">
                    <div class="col-md-3 px-1 my-1">
                        <x-jet-button type="submit" class="w-full" :disabled="empty($activities)">
                            SUBMIT WFH REQUEST
                        </x-jet-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ✅ SweetAlert + Picker Script --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const isFirefox = navigator.userAgent.toLowerCase().includes('firefox');
        const enablePickerSupport = (ctx = document) => {
            if (!isFirefox) {
                ctx.querySelectorAll('input[type="date"], input[type="time"]').forEach(input => {
                    input.addEventListener('click', () => input.showPicker && input.showPicker());
                });
            }
        };
        enablePickerSupport();

        document.addEventListener('livewire:load', () => {
            Livewire.on('activityAdded', () => {
                $('#newTimeFrom').val('');
                $('#newTimeTo').val('');
                $('#newActivity').val('');
            });

            // ✅ Styled Swal for Success
            window.addEventListener('swal-success', event => {
                Swal.fire({
                    icon: 'success',
                    title: '<strong class="text-success">Success!</strong>',
                    html: `<div style="font-size:15px;">${event.detail.message}</div>`,
                    timer: 1600,
                    showConfirmButton: false,
                });
            });

            // ✅ Styled Swal for Errors (including overlaps)
            window.addEventListener('swal-error', event => {
                Swal.fire({
                    icon: 'error',
                    title: '<strong class="text-danger">Oops!</strong>',
                    html: `<div style="font-size:15px;">${event.detail.message}</div>`,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Got it',
                    allowOutsideClick: false,
                });
            });

            // Sync current activities for overlap check
            Livewire.on('updateActivitiesData', activities => {
                window.currentActivities = activities;
            });
        });

        // ✅ Edit modal with overlap validation
        window.addEventListener('open-edit-modal', event => {
            Swal.fire({
                showCancelButton: true,
                confirmButtonText: 'Save Changes',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#6c63ff',
                cancelButtonColor: '#6c757d',
                allowOutsideClick: false,
                focusConfirm: false,
                title: '<h5 class="fw-bold mb-3 banner-blue">Edit Activity</h5>',
                html: `
                    <div class="text-start">
                        <div class="form-floating mb-3">
                            <input id="editDate" type="date" class="form-control" value="${event.detail?.date ?? ''}">
                            <label for="editDate">Date</label>
                        </div>
                        <div class="d-flex gap-2 mb-3">
                            <div class="form-floating flex-fill">
                                <input id="editTimeFrom" type="time" class="form-control" value="${event.detail?.timeFrom ?? ''}">
                                <label for="editTimeFrom">Begin Time</label>
                            </div>
                            <div class="form-floating flex-fill">
                                <input id="editTimeTo" type="time" class="form-control" value="${event.detail?.timeTo ?? ''}">
                                <label for="editTimeTo">End Time</label>
                            </div>
                        </div>
                        <div class="form-floating mb-2">
                            <textarea id="editActivity" class="form-control" style="height: 100px; resize: none;">${event.detail?.activity ?? ''}</textarea>
                            <label for="editActivity">Activity</label>
                        </div>
                    </div>
                `,
                didOpen: () => enablePickerSupport(document),
                preConfirm: () => {
                    const date = document.getElementById('editDate').value;
                    const from = document.getElementById('editTimeFrom').value;
                    const to = document.getElementById('editTimeTo').value;
                    const activity = document.getElementById('editActivity').value;

                    if (window.currentActivities && Array.isArray(window
                            .currentActivities)) {
                        const editIndex = event.detail?.index;
                        const start = new Date(`${date}T${from}`);
                        const end = new Date(`${date}T${to}`);

                        for (let i = 0; i < window.currentActivities.length; i++) {
                            if (i === editIndex) continue;
                            const a = window.currentActivities[i];
                            const aDate = new Date(a.date);
                            if (aDate.toLocaleDateString() === new Date(date)
                                .toLocaleDateString()) {
                                const aStart = new Date(`${a.date} ${a.from}`);
                                const aEnd = new Date(`${a.date} ${a.to}`);
                                if (start < aEnd && end > aStart) {
                                    Swal.showValidationMessage(
                                        '⛔ Overlaps another activity on this date.');
                                    return false;
                                }
                            }
                        }
                    }

                    return {
                        index: event.detail?.index,
                        date,
                        timeFrom: from,
                        timeTo: to,
                        activity
                    };
                }
            }).then(result => {
                if (result.isConfirmed && result.value) {
                    const p = result.value;
                    Livewire.emit('updateActivity', p.index, p.date, p.timeFrom, p.timeTo, p
                        .activity);
                }
            });
        });
    });
</script>
