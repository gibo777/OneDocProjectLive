<!-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 container"> -->
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-2 sm:pt-0 container">
	
    <div>
        {{ $logo }}
    </div>
    <div class="w-full {{ Route::currentRouteName()=="register"? "sm:max-w-5xl" : "sm:max-w-md" }}  px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
