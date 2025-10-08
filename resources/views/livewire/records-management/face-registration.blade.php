<x-slot name="header">
    {{ __('FACE REGISTRATION') }}
</x-slot>

<div id="view_faces">
    <div class="max-w-8xl mx-auto py-1 sm:px-6 lg:px-8 ">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="px-3 bg-white sm:p-6 shadow sm:rounded-md">
            <div class="col-span-8 sm:col-span-8 sm:justify-center">
                <div class="row pb-1 mx-1 inset-shadow">

                    {{-- Search Name/ Employee# --}}
                    <div class="col-md-3 py-2">
                        <div class="form-inline items-center form-floating">
                            <x-jet-input wire:model.debounce.300ms="search" type="text" id="search" name="search"
                                class="w-full form-control mt-1">
                            </x-jet-input>
                            <x-jet-label for="search" value="{{ __('Search Name/Employee #') }}" />
                        </div>
                    </div>

                    {{-- Office Filter --}}
                    {{-- <div class="col-md-2 py-2">
                        <div class="form-floating w-full" id="divfilterEmpOffice">
                            <select wire:model="fTLOffice" name="fTLOffice" id="fTLOffice"
                                class="form-control w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                <option value="">All Offices</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                                @endforeach
                            </select>
                            <x-jet-label for="fTLOffice" value="{{ __('OFFICE') }}" />
                        </div>
                    </div> --}}

                    {{-- Department Filter --}}
                    {{-- <div class="col-md-2 py-2">
                        <div class="form-floating w-full" id="divfTLDept">
                            <select wire:model="fTLDept" name="fTLDept" id="fTLDept"
                                class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_code }}">{{ $department->department }}
                                    </option>
                                @endforeach
                            </select>
                            <x-jet-label for="fTLDept" value="{{ __('DEPARTMENT') }}" />
                        </div>
                    </div> --}}

                    {{-- Export Button --}}
                    {{-- <div class="col-md-3 text-center mt-2 py-2">
                        @if (Auth::user()->id == 1 || Auth::user()->id == 8 || Auth::user()->id == 58 || Auth::user()->id == 287)
                            <div
                                class="form-group btn btn-outline-success d-inline-block shadow-sm p-2 rounded capitalize hover w-75">
                                <i class="fas fa-table"></i>
                                <span id="exportExcel" class="font-weight-bold">Export to Excel</span>
                            </div>
                        @endif
                    </div> --}}
                </div>
            </div>

            <div id="table_data" class="mt-3">

                <div class="row my-1">
                    <div class="col-md-9">
                        <div class="form-inline items-left justify-start">
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
                            <div class=" sm:col-span-7 sm:justify-center scrollable">
                                {{ $timeLogs->links('pagination.custom') }}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="row py-2">
                            <div class="col-md-2">
                                <x-jet-label for="search" value="{{ __('Search') }}" class="my-0 pt-1" />
                            </div>
                            <div class="col-md-8">
                                <x-jet-input wire:model.debounce.300ms="search" type="text" id="search"
                                    name="search" class="w-full" placeholder="Name/Employee ID">
                                </x-jet-input>
                            </div>
                        </div>
                    </div> --}}
                </div>

                {{-- Responsive Table --}}
                <div class="table-responsive">
                    <table id="dataFaces"
                        class="view-user-face table table-bordered table-striped table-hover text-sm mb-0">
                        <thead class="thead">
                            <tr>
                                <th class="py-1">Name</th>
                                <th class="py-1" style="width: 10%">Employee ID</th>
                                <th class="py-1">Office</th>
                                <th class="py-1">Department</th>
                                <th class="py-1">Image</th>
                            </tr>
                        </thead>
                        <tbody class="data hover custom-text-xs">
                            @if ($timeLogs->isNotEmpty())
                                @foreach ($timeLogs as $record)
                                    <tr id="{{ $record->id }}">
                                        <td class="text-left">{{ $record->name }}</td>
                                        <td>{{ $record->employee_id }}</td>
                                        <td>{{ $record->office }}</td>
                                        <td>{{ $record->department }}</td>
                                        <td>{{ $record->image_count }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No Matching Records Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>


                <div class="form-inline items-left justify-start">
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
                    <div class=" sm:col-span-7 sm:justify-center scrollable">
                        {{ $timeLogs->links('pagination.custom') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('dblclick', '.view-user-face tr', async function() {
        $.ajax({
            url: '/face-registration',
            method: 'get',
            data: {
                uID: $(this).attr('id')
            },
            success: function(html) {
                Swal.fire({
                    html: html,
                    width: '75%',
                    showConfirmButton: false,
                    showCloseButton: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                        const video = document.getElementById("video");
                        const captureBtn = document.getElementById("capture");
                        const imgContainer = document.getElementById(
                            "imageContainer");

                        // Start webcam
                        if (video) {
                            navigator.mediaDevices.getUserMedia({
                                    video: true
                                })
                                .then(stream => {
                                    video.srcObject = stream;
                                })
                                .catch(err => console.error("Webcam error:", err));
                        }

                        // Handle capture
                        if (captureBtn) {
                            captureBtn.addEventListener("click", () => {
                                if (!imgContainer) return;

                                if (imgContainer.children.length >= 4) {
                                    let notif = document.getElementById(
                                        "swalNotif");
                                    if (!notif) {
                                        notif = document.createElement(
                                            "div");
                                        notif.id = "swalNotif";
                                        notif.className =
                                            "alert alert-warning text-center py-1 mt-2";
                                        notif.innerText =
                                            "You can only capture up to 4 images.";
                                        document.querySelector(
                                                ".swal2-html-container")
                                            .appendChild(notif);
                                    }
                                    notif.style.display = "block";
                                    return;
                                }

                                // Full-size hidden input (mirrored)
                                const canvasFull = document.createElement(
                                    "canvas");
                                canvasFull.width = video.videoWidth;
                                canvasFull.height = video.videoHeight;
                                const ctxFull = canvasFull.getContext("2d");
                                ctxFull.save();
                                ctxFull.translate(canvasFull.width, 0);
                                ctxFull.scale(-1, 1);
                                ctxFull.drawImage(video, 0, 0, canvasFull
                                    .width, canvasFull.height);
                                ctxFull.restore();

                                // Small preview (mirrored thumbnail)
                                const canvasPreview = document
                                    .createElement("canvas");
                                canvasPreview.width = 310;
                                canvasPreview.height = 220;
                                const ctxPreview = canvasPreview.getContext(
                                    "2d");
                                ctxPreview.save();
                                ctxPreview.translate(canvasPreview.width,
                                    0);
                                ctxPreview.scale(-1, 1);
                                ctxPreview.drawImage(video, 0, 0,
                                    canvasPreview.width, canvasPreview
                                    .height);
                                ctxPreview.restore();

                                const wrapper = document.createElement(
                                    "div");
                                wrapper.className =
                                    "d-inline-block mx-1 text-center";

                                const hiddenInput = document.createElement(
                                    "input");
                                hiddenInput.type = "hidden";
                                hiddenInput.name = "image[]";
                                hiddenInput.value = canvasFull.toDataURL(
                                    "image/png");

                                const deleteBtn = document.createElement(
                                    "button");
                                deleteBtn.type = "button";
                                deleteBtn.className =
                                    "btn btn-sm btn-danger d-block mx-auto mt-1";
                                deleteBtn.innerText = "Delete";
                                deleteBtn.addEventListener("click", () => {
                                    wrapper.remove();
                                    let notif = document
                                        .getElementById(
                                            "swalNotif");
                                    if (notif && imgContainer
                                        .children.length < 6) {
                                        notif.style.display =
                                            "none";
                                    }
                                });

                                wrapper.appendChild(canvasPreview);
                                wrapper.appendChild(hiddenInput);
                                wrapper.appendChild(deleteBtn);
                                imgContainer.appendChild(wrapper);
                            });
                        }
                        $('#saveImages').on('click', function() {
                            alert('test');
                            return false;
                        });
                    },
                    willClose: () => {
                        // Stop webcam when modal closes
                        const video = document.getElementById("video");
                        if (video && video.srcObject) {
                            video.srcObject.getTracks().forEach(track => track
                                .stop());
                        }
                    }
                });
            }
        });
    });
</script>
