
if($('.datetimepicker')) {
    $('.datetimepicker').datetimepicker({
        format: 'MM/DD/YYYY',
        icons: {
            up: "fa fa-angle-up",
            down: "fa fa-angle-down",
            next: 'fa fa-angle-right',
            previous: 'fa fa-angle-left'
        }
    });
    $(document).on('click','#addPatient', function(){
        $('.datetimepicker').datetimepicker({
            format: 'MM/DD/YYYY',
            icons: {
                up: "fa fa-angle-up",
                down: "fa fa-angle-down",
                next: 'fa fa-angle-right',
                previous: 'fa fa-angle-left'
            }
        });
    })
}