<!DOCTYPE html>
<html>
<head>
  <title>Pusher Test</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('264cb3116052cba73db3', {
      cluster: 'us2',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind("my-event", function(data) {
      // alert(data);
      // alert(JSON.stringify(data));
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          // url: window.location.origin+'/file-preview-memo',
          url: "{{ route('testing.label') }}",
          method: 'get',
          data: JSON.stringify(data), // prefer use serialize method
          success:function(data){
              $("tbody").append('<tr><td>Testing Notification</td></tr>');
          }
      });
    }); 
  </script>
</head>
<body>
  <table>
    <thead>
      <tr><td>Testing Head</td></tr>
    </thead>
    <tbody>
      <tr>
        <td>Testing Only</td>
      </tr>
    </tbody>
  </table>
</body>
</html>