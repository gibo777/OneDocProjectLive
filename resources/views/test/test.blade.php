<x-app-layout>


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

<x-slot name="header">
    {{ __('Google Calendar Integration (TEST)') }}
</x-slot>

<div class="max-w-8xl mx-auto m-1 sm:px-6 lg:px-8 p-2 shadow-sm">

{{-- <input type="text" id="autoFillText"> --}}
{{-- <p class="copy-text">Click here to copy this text</p> --}}
<iframe src="https://calendar.google.com/calendar/embed?src=5be3de62c935b7c9d0c1a00efc90e540d12911a0fd034b048ce4a6ab0f7e859e%40group.calendar.google.com&ctz=Asia%2FManila" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
{{-- {{ phpinfo() }} --}}

</div>

</x-app-layout>
