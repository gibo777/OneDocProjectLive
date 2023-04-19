{{-- <div class="flex flex-col sm:justify-center items-center pt-1 sm:pt-0 container"> --}}
    {{-- <div class="w-full sm:max-w-8xl px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"> --}}

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-5 md:gap-3']) }}>
    <div class="mt-1 md:mt-0 md:col-span-2">
    	<div class="px-3 py-3 bg-white sm:p-3 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
	        	{{ $slot }}
	    </div>
    </div>
</div>