
<x-app-layout>
<div>
    <x-slot name="header">
        <h2 id="view_header" class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('WELCOME TO ').strtoupper(config('app.name')) }}
            <!-- {{ __('Dashboard') }} -->
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
        <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            <div class="grid grid-cols-5 gap-6">

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
            </div>
        </div>
    </div>
</div>
</x-app-layout>