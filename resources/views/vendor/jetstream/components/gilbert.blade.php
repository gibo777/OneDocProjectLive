@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-5 md:gap-3']) }}>

    <div class="mt-1 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="{{ $submit }}">
            <div class="px-3 py-3 bg-white sm:p-3 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="grid grid-cols-6 gap-4">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-center px-2 py-2 bg-gray-50 text-right sm:px-3 shadow sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
