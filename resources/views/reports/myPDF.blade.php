<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles	
<link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap4.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.min.css') }}">
<style type="text/css">	
/*.rotate {
  background-color: transparent;
  outline: 2px dashed;
  transform: rotate(270deg);
}*/
</style>
</head>
<body>
	<div class="col-span-8 sm:col-span-8 p-12"> 
        <div class="row p-3">
            <div class="col-md-2 py-1">
              <img class="border-0" src="{{ asset('/img/company/1doc-memo-logo.png') }}" />
            </div>

            <div class="col-md-10">
                <div class="row justify-center">
                    <div class="col-md-12 thead bg-dark">
                    	<div class="row">
	                        <div class="col-md-7 p-2">
	                            <h4 class="font-serif font-bold">INTERNAL MEMO</h4>
	                        </div>
	                        <div class="col-md-5 pt-3 sm:justify-end">
	                            <h6 class="font-serif font-bold">{{ date('Y') }} HR/Personnel - 02</h6>
	                        </div>
                    	</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-1">
                            <h7 class="text-sm">To</h7>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-2">
 							<h7 class="text-sm">From</h7>
 						</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-2">
 							<h7 class="text-sm">Date</h7>
 						</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-2">
 							<h7 class="font-weight-bold text-sm">SUBJECT</h7>
 							<hr class="bg-dark" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row p-3">
            <div class="col-md-2 py-1">
              <img class="border-0" src="{{ asset('/img/company/1doc-memo-logo.png') }}" />
            </div>

            <div class="col-md-10">
                <div class="row justify-center">
                    <div class="col-md-12 thead bg-dark">
                    	<div class="row">
	                        <div class="col-md-7 p-2">
	                            <h4 class="font-serif font-bold">INTERNAL MEMO</h4>
	                        </div>
	                        <div class="col-md-5 pt-3 sm:justify-end">
	                            <h6 class="font-serif font-bold">2022 HR/Personnel - 02</h6>
	                        </div>
                    	</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-1">
                            <h7 class="text-sm">To</h7>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-2">
 							<h7 class="text-sm">From</h7>
 						</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-2">
 							<h7 class="text-sm">Date</h7>
 						</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-2">
 							<h7 class="font-weight-bold text-sm">SUBJECT</h7>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row p-3">
            <div class="col-md-2 py-1">
              <img class="border-0" src="{{ asset('/img/company/1doc-memo-logo.png') }}" />
            </div>

            <div class="col-md-10">
                <div class="row justify-center">
                    <div class="col-md-12 thead bg-dark">
                    	<div class="row">
	                        <div class="col-md-7 p-2">
	                            <h4 class="font-serif font-bold">INTERNAL MEMO</h4>
	                        </div>
	                        <div class="col-md-5 pt-3 sm:justify-end">
	                            <h6 class="font-serif font-bold">2022 HR/Personnel - 02</h6>
	                        </div>
                    	</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-1">
                            <h7 class="text-sm">To</h7>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-2">
 							<h7 class="text-sm">From</h7>
 						</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-2">
 							<h7 class="text-sm">Date</h7>
 						</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-span-8 sm:col-span-1 pt-2">
 							<h7 class="font-weight-bold text-sm">SUBJECT</h7>
                        </div>
                    </div>
                </div>

            </div>
        </div>




    </div>
</body>
</html>