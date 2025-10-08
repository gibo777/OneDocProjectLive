<x-app-layout>

    <x-slot name="header">
        {{ __('REGISTER FACE') }}
    </x-slot>

    <div id="viewLeaves">
        <div class="max-w-7xl mx-auto py-1 sm:px-6 lg:px-8 ">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @csrf

            <div
                class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                <form id="faceForm">
                    <div class="row">

                        <div class="col-md-3 sm:justify-center">

                            <div>
                                <video id="video" width="320" height="240" autoplay
                                    style="transform: scaleX(-1);"></video>
                            </div>

                            <div class="my-1 text-center">
                                <x-jet-button id="capture" type="button" class="w-full"><i
                                        class="fa-solid fa-camera mr-2"></i> Capture</x-jet-button>
                            </div>

                            <div class="my-3 text-center">
                                <x-jet-input type="text" name="subject" id="subject" class="w-full"
                                    placeholder="Enter subject (e.g. employee ID)" required />
                            </div>

                            <pre id="responseBox" class="border-1 border-dark bg-light" style="height:180px; overflow:auto;"></pre>

                            <div class="my-1 text-center">
                                <x-jet-button type="submit" class="w-full">Save Images</x-jet-button>
                            </div>

                        </div>

                        <div class="col-md-9 bg-light border-1 border-dark rounded-5 px-3">
                            <div id="imageContainer" class="d-flex flex-wrap gap-2 py-2">
                                <!-- Canvases with hidden inputs will be appended here -->
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');

        // Start webcam
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                video.srcObject = stream;
            });

        // Capture snapshot (jQuery version)
        $('#capture').on('click', function() {
            const $imageContainer = $('#imageContainer');

            if ($imageContainer.children().length >= 6) {
                Swal.fire({
                    icon: "warning",
                    html: "You can only capture up to 6 images."
                });
                return;
            }

            const canvas = document.createElement('canvas');
            canvas.width = 280;
            canvas.height = 210;
            canvas.className = "rounded-lg border border-dark d-block mx-auto";

            const ctx = canvas.getContext('2d');
            ctx.save();
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            ctx.restore();

            Swal.fire({
                html: `<div style="text-align:center;"><img src="${canvas.toDataURL('image/jpg')}" class="w-full"></div>`,
                showCancelButton: true,
                confirmButtonText: 'Save Image',
                cancelButtonText: 'Retake',
                reverseButtons: true,
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const $wrapper = $('<div>', {
                        class: "my-2 text-center"
                    });

                    const $hiddenInput = $('<input>', {
                        type: 'hidden',
                        name: 'image[]',
                        value: canvas.toDataURL('image/jpg')
                    });

                    const $deleteBtn = $('<button>', {
                        type: 'button',
                        class: 'btn btn-sm btn-danger mt-1',
                        text: 'Delete'
                    }).on('click', function() {
                        $wrapper.remove();
                    });

                    $wrapper.append(canvas, $hiddenInput, $deleteBtn);
                    $imageContainer.append($wrapper);
                }
            });
        });

        // Preview form data before submit
        $("#faceForm").on("submit", function(e) {
            e.preventDefault();

            let subject = $("#subject").val();
            let images = [];

            $("#imageContainer input[type=hidden]").each(function() {
                images.push($(this).val());
            });

            $.ajax({
                url: "/faces/register",
                type: "POST",
                data: {
                    subject: subject,
                    image: images,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                beforeSend: function() {
                    $('#dataProcess').css({
                        'display': 'flex',
                        'position': 'fixed',
                        'top': '50%',
                        'left': '50%',
                        'transform': 'translate(-50%, -50%)'
                    });

                },
                success: function(res) {
                    $('#dataProcess').hide();
                    $("#responseBox").text(JSON.stringify(res, null, 2));
                    Swal.fire({
                        icon: 'success',
                        html: 'Image/s saved successfully!'
                    });
                },
                error: function(xhr) {
                    $("#responseBox").text(xhr.responseText);
                }
            });
        });
    </script>

</x-app-layout>
