<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 File Upload Example - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
<script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
</head>
      
<body>
<div class="container">
       
    <div class="panel panel-primary">
  
      <div class="panel-heading">
        <h2>Laravel 9 File Upload Example - ItSolutionStuff.com</h2>
      </div>
  
      <div class="panel-body">
       
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif
      
        <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
  
            <div class="mb-3">
                <label class="form-label" for="inputFile">File:</label>
                <input 
                    type="file" 
                    name="file" 
                    id="inputFile"
                    class="form-control @error('file') is-invalid @enderror">
  
                @error('file')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
   
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Upload</button>
            </div>
       
        </form>
      
      </div>
    </div>
</div>

<script type="text/javascript">
    
    $('#inputFile').on('change', function() {
        // alert('Gilbert'); return false;
        // var filePath = $("#inputGroupFile02").files[0].mozFullPath;
        // alert(filePath);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // alert($("#inputGroupFile02").val()); return false;
            // alert(window.location.origin+'/file-preview-memo'); return false;
            $.ajax({
                url: window.location.origin+'/file-upload',
                method: 'post',
                data: $("#memo-form").serialize(), // prefer use serialize method
                success:function(data){
                    // alert(data);
                         
                }
            });

            return false;

        // let fileName = $(this).val().split('\\').pop(); 
        // $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });
</script>
</body>
    
</html>