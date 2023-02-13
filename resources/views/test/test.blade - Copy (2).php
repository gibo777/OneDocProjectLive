  
<x-app-layout>  
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.5.2/flatly/bootstrap.min.css"> -->
<link href="{{ asset('/Multi-column-Dropdown-Plugin-jQuery-Inputpicker/src/jquery.inputpicker.css?v3') }}" rel="stylesheet" type="text/css">


<div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form id="leave-form" action="{{ route('calendar') }}" method="POST">
            @csrf


            <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="grid grid-cols-5 gap-6 sm:justify-center">


<div class="container">
<input class="form-control" id="demo-1" value="jQuery" />


<input class="form-control" id="demo-2" value="jQuery" />
</div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script> -->
<script src="{{ asset('/Multi-column-Dropdown-Plugin-jQuery-Inputpicker/src/jquery.inputpicker.js?v3') }}"></script>
<script>
$('#demo-3').inputpicker({
    url: 'src/example-regions.json',
    fields:['id','name','hasc'],
    fieldText:'name',
    fieldValue:'id'
});
$("input[type='text']").on("click", function () {
   alert($(this).val());
});
$('#demo-1').inputpicker({
  data:[ "jQuery", "Script", "Net" ]
});
$('#demo-2').inputpicker({
    data:[
        {value:"1",text:"jQuery", description: "This is the description of the text 1."},
        {value:"2",text:"Script", description: "This is the description of the text 2."},
        {value:"3",text:"Net", description: "This is the description of the text 3."}
    ],
    fields:[
        {name:'value',text:'Id'},
        {name:'text',text:'Title'},
        {name:'description',text:'Description'}
    ],
    headShow: true,
    fieldText : 'text',
    fieldValue: 'value',
  filterOpen: true
    });
</script>
<script type="text/javascript">

  // var _gaq = _gaq || [];
  // _gaq.push(['_setAccount', 'UA-36251023-1']);
  // _gaq.push(['_setDomainName', 'jqueryscript.net']);
  // _gaq.push(['_trackPageview']);

  // (function() {
  //   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  //   // ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  //   // alert(ga.src);
  //   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  // })();

</script>
<script>
/*try {
  fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", { method: 'HEAD', mode: 'no-cors' })).then(function(response) {
    return true;
  }).catch(function(e) {
    var carbonScript = document.createElement("script");
    carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
    carbonScript.id = "_carbonads_js";
    document.getElementById("carbon-block").appendChild(carbonScript);
  });
} catch (error) {
  console.log(error);
}*/
</script>


                </div>
            </div>
                
            </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
 




          });
    </script>


</x-app-layout>