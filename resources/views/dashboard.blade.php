<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">


<x-app-layout>

<!-- <div style="height: 580px"> -->
<div>
    <x-slot name="header">
            {{ __('WELCOME TO ').strtoupper(env('COMPANY_NAME')) }} 
            {{-- {{  join(' ',['Welcome to', env('COMPANY_NAME'), Auth::user()->first_name,Auth::user()->last_name])  }} --}}
    </x-slot>
<!-- <audio src="{{ asset('media/videoplayback.mp3') }}" autoplay loop controls> -->

<!-- <audio controls autoplay loop>
    <source src="{{ asset('media/videoplayback.mp3') }}" type="audio/mpeg">
</audio> -->

<audio controls autoplay hidden>
  {{-- <source id="audio-background" src="{{ asset('media/videoplayback.mp3') }}" type="audio/mpeg"> --}}
</audio>


    <div class="max-w-7xl mx-auto pt-1 sm:px-6 lg:px-8">
        <div class="px-2 py-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
           <div class="row px-3">
                <div class="col-md-5 pt-5">
                    <!-- <div class="grid grid-cols-5 gap-6 text-center sm:justify-center"> -->
                    {{-- <img src="{{ asset('/img/company/onedoc-logo.png') }}" class="rounded w-50 mx-auto d-block py-2" alt="{{ strtoupper(config('app.name')) }}"> --}}
                        {{-- {{ __('WELCOME TO ').strtoupper(config('app.name')) }} --}}
                        <ol>
                          <li>
                            <p>WHO WE ARE</p>
                            <p class="h6 text-justify">
                            One Document Corporation is focused on Information Technology-related project developments and technology-based solutions, on its decade of existence this 2021 is expanding its reach through program-based versatile integrated systems that accelerate progress for any business operations.
                            </p>

                            <p>Mission:</p>
                            <p class="h6 text-justify">
                            To have the entrepreneurial spirit in the continuous search for project opportunities, vigilant in growing from current businesses focused on our customers, and from new initiatives through ingenuity and reinvention, always committed to deliver dependable goods and services, locally and globally.
                            </p>

                            <p>Vision:</p>
                            <p class="h6 text-justify">
                            To be a recognized socially-responsible leader in productive and profitabletechnology-based project developments, committed to improve lives, here and/or abroad
                            </p>
                          </li>
                        </ol>
                    <!-- </div> -->
                </div>

            <div class="col-md-7">
                <div id="carouselExampleIndicators" class="carousel slide pt-3" data-ride="carousel">
                  <ol class="carousel-indicators">
                    @if(date('a')=='am')
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    @else
                    <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
                    @endif
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
                  </ol>

                  
                  <div class="carousel-inner">
                    @if(date('a')=='am')
                    <div class="carousel-item active" style="height: 450px !important;">
                      <img src="{{ asset('img/carousel/goodmorning.jpg') }}" class="d-block w-100 h-100" alt="...">
                    </div>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="{{ asset('img/carousel/1.jpg') }}" class="d-block w-100 h-100" alt="...">
                    </div>
                    @else
                    <div class="carousel-item active" style="height: 450px !important;">
                      <img src="{{ asset('img/carousel/1.jpg') }}" class="d-block w-100 h-100" alt="...">
                    </div>
                    @endif
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="{{ asset('img/carousel/2.jpg') }}" class="d-block w-100 h-100" alt="...">
                    </div>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="{{ asset('img/carousel/3.jpg') }}" class="d-block w-100 h-100" alt="...">
                    </div>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="{{ asset('img/carousel/4.jpg') }}" class="d-block w-100 h-100" alt="...">
                    </div>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="{{ asset('img/carousel/5.jpg') }}" class="d-block w-100 h-100" alt="...">
                    </div>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="{{ asset('img/carousel/6.jpg') }}" class="d-block w-100 h-100" alt="...">
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
                <div class="p-3">
                <ol>
                    <li>
                        Accelerating Our Nation’s Progress Through Information Technology.
                    </li>
                </ol>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>

<input type="button" id="audio-button" name="" value="button" hidden>
<x-jet-input type="text" id="date_compare" value="{{ substr(Auth::user()->birthdate,5,5).'|'.substr(Carbon\Carbon::now(),5,5) }}" hidden/>

<!-- =========================================== -->
<!-- Modal for Greetings -->
<div class="modal fade " id="modalGreetings" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-xl" >
        <div class="modal-dialog-centered">  
            <img src="{{ asset('/img/misc/Happy_Birthday.gif') }}">
        </div>
    </div>
</div>
<!-- =========================================== -->
<script src="{{ asset('/js/confetti.js') }}"></script>
<script type="text/javascript">
  /*$(document).ready(function() {
    $("#audio-button").click(function() {
    $("#audio-background")[0].play(); return false;
    });
  });*/
</script>

</x-app-layout>