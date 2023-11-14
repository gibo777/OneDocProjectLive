{{-- <div class="container">
    <div class="row w-full justify-center">
        <div class="col-md-12"> --}}
            {{-- {!! QrCode::size(200)->backgroundColor(229,248,252)->generate(url('/').'/'.Str::random(128)) !!} --}}
            {{-- {!! QrCode::size(100)->backgroundColor(229,248,252)->generate( $qrLink ) !!} --}}

            {{-- {{ $fullName }} --}}
            {{-- {{ url('/qr-code-link').'/'.$qrLink }} --}}
            <div >
            	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(140)->generate( url('/qr-code-link').'/'.$qrLink )) !!} ">
		        <a id="downloadLink" href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)
            ->margin(5)->generate( url('/qr-code-link').'/'.$qrLink )) !!} " download="{{$fullName}}.png">Download QR Code</a>
		    </div>

            {{-- {!! base64_encode(QrCode::format('png')->size(100)->backgroundColor(229,248,252)->generate( $qrLink )) !!} --}}

            {{-- <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate('Generate any QR Code!')) !!} "> --}}
            	{{-- <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('sample qr'))}  --}}
        {{-- </div>
    </div> 
</div>  --}}