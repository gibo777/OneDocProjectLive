<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Copy Text on Click</title>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script>
$(document).ready(function(){
    $('.copy-text').click(function(){
        var textToCopy = $(this).text();
        copyToClipboard(textToCopy);
        alert("Text copied to clipboard: " + textToCopy);
    });
    
    function copyToClipboard(text) {
        var input = $('<input>');
        $('body').append(input);
        input.val(text).select();
        document.execCommand('copy');
        input.remove();
    }
    $(document).on('change keyup keydown paste', '#autoFillText', function() {
        $('.copy-text').text($(this).val());
    });
});
</script>
</head>
<body>

<input type="text" id="autoFillText">
<p class="copy-text">Click here to copy this text</p>
{{ phpinfo() }}

</body>
</html>
