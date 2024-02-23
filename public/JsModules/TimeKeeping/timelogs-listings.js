$(document).ready(function() {

    if (("{{ count($employees) }}") == 0) { return false; }
    // Initialize DataTable
    var table = $('#dataTimeLogs').DataTable({
        /*"order": [
            [3, 'desc'],
            [4, 'desc'],
            [0, 'asc'],
        ],*/
        "order": [],
        /*"columnDefs": [
          { width: '170px', targets: [3] }, 
        ],*/
        // "ordering": false,
        "lengthMenu": [ 5,10, 15, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 15, // Set the default number of entries per page
        "dom": '<<"top"ilpf>rt<"bottom"ilp><"clear">>', // Set Info, Search, and Pagination both top and bottom of the table
    });

    function formatDate(inputDate) {
        var date = new Date(inputDate); // Create a Date object from the input string
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, "0"); // Pad the month with leading zeros if needed
        var day = String(date.getDate()).padStart(2, "0"); // Pad the day with leading zeros if needed

        // Return the formatted date in the desired format (MM-DD-YYYY)
        return [month,day,year].join("/");
      }

    /*$.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

            var sD  = $('#filterTimeLogsDept').val();
            var cD  = data[2]; // Department Column
            
            // Check if a department filter is selected
            var departmentFilterActive = (sD != null && sD !== '');

            // Apply both filters
            if (!departmentFilterActive) {
                return true; // No filters applied, show all rows
            }
            var departmentMatch = !departmentFilterActive || cD.includes(sD);

            return departmentMatch;
        
    });*/

    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

            var sTO  = $('#filterTimeLogsOffice').val();
            var sTD = $('#filterTimeLogsDept').val();
            var cTO  = data[2]; // Office Column
            var cTD = data[3]; // Department Column
            // alert(cTD); return false;
            
            // Check if a department filter is selected
            var officeFilterActive = (sTO != null && sTO !== '');

            // Check if a LeaveType filter is selected
            var departmentFilterActive = (sTD != null && sTD !== '');

            // Apply both filters
            if (!officeFilterActive && !departmentFilterActive) {
                return true; // No filters applied, show all rows
            }
            var officeMatch = !officeFilterActive || cTO.includes(sTO);
            var departmentMatch = !departmentFilterActive || cTD.includes(sTD);

            return officeMatch && departmentMatch;
       
        
    });


    /* START - Date From and Date To Searching */
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var searchDateFrom = $('#dateFrom').val();
        var searchDateTo = $('#dateTo').val();

        // Convert search date strings to Date objects
        var dateFrom = new Date(searchDateFrom);
        var dateTo = new Date(searchDateTo);

        // Set the time to the start and end of the selected days
        dateFrom.setHours(0, 0, 0, 0);
        dateTo.setHours(23, 59, 59, 999);

        // Get the time-in and time-out values from columns 3 and 4
        var searchTimeIn = data[3];
        var searchTimeOut = data[4];

        // Convert time-in and time-out strings to Date objects (if applicable)
        var timeIn = searchTimeIn ? new Date(searchTimeIn) : null;
        var timeOut = searchTimeOut ? new Date(searchTimeOut) : null;

        // Check if the row's time-in or time-out falls within the selected date range
        if (
            (!searchDateFrom || !searchDateTo) || // No date range selected
            (!timeIn && !timeOut) || // No time values available
            (timeIn >= dateFrom && timeIn <= dateTo) ||
            (timeOut >= dateFrom && timeOut <= dateTo)
        ) {
            return true; // Row matches the search criteria
        }

        return false; // Row does not match the search criteria
    });


    $('#filterTimeLogsOffice').on('keyup change', function() {
        table.draw();
    });
    $('#filterTimeLogsDept').on('keyup change', function() {
        table.draw();
    });


    /* Triggers Date From Searching of Time-In/Time-Out */
    $('#dateFrom').on('keyup change', function() {
        if ($('#dateTo').val()=='' || $('#dateTo').val()==null) {
            $('#dateTo').val($(this).val());
        } else {
            var dateFrom = new Date($(this).val());
            var dateTo = new Date($('#dateTo').val());
            if( dateTo < dateFrom ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Range',
                    // text: '',
                }).then(function() {
                    $(this).val('');
                });
            }
        }
        table.draw();
    });

    /* Triggers Date To Searching of Time-In/Time-Out */
    $('#dateTo').on('keyup change', function() {
        var dateFrom = new Date($('#dateFrom').val());
        var dateTo = new Date($(this).val());
        if( dateTo < dateFrom ) {
            $(this).val($('#dateFrom').val());
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range',
                // text: '',
            });
        }
        table.draw();
    });
    /* END - Date From and Date To Searching */





    /* Double Click event to show Employee details */
    $(document).on('dblclick','.view-detailed-timelogs tr',async function(){
        // alert($(this).attr('id')); return false;


        $('#dataLoad').css('display','flex');
        $('#dataLoad').css('position','absolute');
        $('#dataLoad').css('top','40%');
        $('#dataLoad').css('left','40%');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/timelogs-detailed',
            method: 'get',
            data: {'id':$(this).attr('id')}, // prefer use serialize method
            success:function(data){
                let tableStructure = `<table id="dataDetailedTimeLogs" class="table table-bordered data-table sm:justify-center table-hover">
                        <thead class="thead">
                            <tr>
                                <th>Photo</th>
                                <th>Time-In</th>
                                <th>Time-Out</th>
                            </tr>
                        </thead>
                        <tbody class="data text-center" id="data">`;

                // Function to fetch content and return a promise
                function fetchContent(n) {
                    return new Promise((resolve, reject) => {
                        var basePath = '{{ asset('storage/timelogs') }}';
                        var imagePath = data[n]['image_path'];
                        var fullFilePath = basePath + '/' + imagePath + '.txt';

                        fetch(fullFilePath)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error("Failed to fetch file");
                                }
                                return response.text();
                            })
                            .then(fileContent => {
                                resolve(`<tr>
                                            <td><img width="124px" src="${fileContent}" /></td>
                                            <td>${data[n]['time_in']}</td>
                                            <td>${data[n]['time_out']}</td>
                                        </tr>`);
                            })
                            .catch(error => {
                                console.error("Error reading the file:", error);
                                reject(error);
                            });
                    });
                }

                // Array to store promises
                let promises = [];

                // Loop through data and create promises
                for (let n = 0; n < data.length; n++) {
                    promises.push(fetchContent(n));
                }

                // Wait for all promises to resolve
                Promise.all(promises)
                    .then(rows => {
                        // Append the rows to the table structure
                        tableStructure += rows.join('');
                        tableStructure += `</tbody></table>`;

                        // Show the table using Swal.fire
                        Swal.fire({
                            allowOutsideClick: false,
                            html: tableStructure
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching content:", error);
                    });

                $('#dataLoad').css('display','none');
            }
        });
    });

    /* EXPORT TO EXCEL TIMELOGS */
    $('#exportExcel').click(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/timelogs-excel',
            method: 'get',
            data: {'id': $(this).attr('id')},
            success: function(html) {
                // Create a temporary div to hold the table HTML
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;

                // Extract data from the table
                var data = [];
                var headers = [];
                var rows = tempDiv.querySelectorAll('tbody tr');
                
                // Extract headers
                tempDiv.querySelectorAll('thead th').forEach(function(th) {
                    headers.push(th.textContent.trim());
                });
                
                // Push headers as the first row of data
                data.push(headers);
                
                // Extract table data
                rows.forEach(function(row) {
                    var rowData = [];
                    row.querySelectorAll('td').forEach(function(cell) {
                        rowData.push(cell.textContent.trim());
                    });
                    data.push(rowData);
                });

                // Create Excel XML content
                var xmlContent = '<?xml version="1.0"?>\n';
                xmlContent += '<?mso-application progid="Excel.Sheet"?>\n';
                xmlContent += '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"\n';
                xmlContent += ' xmlns:o="urn:schemas-microsoft-com:office:office"\n';
                xmlContent += ' xmlns:x="urn:schemas-microsoft-com:office:excel"\n';
                xmlContent += ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"\n';
                xmlContent += ' xmlns:html="http://www.w3.org/TR/REC-html40">\n';
                xmlContent += '<Worksheet ss:Name="Sheet1">\n';
                xmlContent += '<Table>\n';
                
                // Add headers
                xmlContent += '<Row>\n';
                headers.forEach(function(header) {
                    xmlContent += '<Cell><Data ss:Type="String">' + header + '</Data></Cell>\n';
                });
                xmlContent += '</Row>\n';
                
                // Add data rows
                data.slice(1).forEach(function(row) {
                    xmlContent += '<Row>\n';
                    row.forEach(function(cell) {
                        xmlContent += '<Cell><Data ss:Type="String">' + cell + '</Data></Cell>\n';
                    });
                    xmlContent += '</Row>\n';
                });
                
                xmlContent += '</Table>\n';
                xmlContent += '</Worksheet>\n';
                xmlContent += '</Workbook>';

                // Create a blob from the XML content
                var blob = new Blob([xmlContent], { type: 'application/vnd.ms-excel' });
                var url = window.URL.createObjectURL(blob);

                // Create a download link
                var a = document.createElement('a');
                a.href = url;
                a.download = 'SVV_V3.xlsx'; // Use .xlsx extension for Excel files
                document.body.appendChild(a);
                a.click();

                // Clean up
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            }
        });
        return false;

    });



});