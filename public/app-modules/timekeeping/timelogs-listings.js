$(document).ready(function () {


    function formatDate(inputDate) {
        var date = new Date(inputDate);
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, "0");
        var day = String(date.getDate()).padStart(2, "0");

        // Return the formatted date in the desired format (MM-DD-YYYY)
        return [month, day, year].join("/");
    }


    /* Triggers Date From Searching of Time-In/Time-Out */
    // $(document).on('change', '#fTLdtFrom', function() {
    //     var dateFrom = new Date($(this).val());
    //     var yearFrom = dateFrom.getFullYear();
    //     var dateTo = new Date($('#fTLdtTo').val());
    //     if ($('#fTLdtTo').val() == '') {
    //         $('#fTLdtTo').val($(this).val());
    //     } else if (dateTo < dateFrom) {
    //         $('#fTLdtTo').val($(this).val());
    //         // console.log(dateFrom);
    //         /*Swal.fire({
    //             icon: 'error',
    //             title: 'Invalid Date Range',
    //         }).then(function() {
    //             Livewire.emit('setDateTo');
    //         });*/
    //     }
    // });

    $(document).on('click', '#clearFilter', function () {
        Livewire.emit('clearDateFilter');
    });

    Livewire.on('setDateTo', function () {
        $('#fTLdtTo').val($('#fTLdtFrom').val());
    });

    Livewire.on('clearDateFilter', function () {
        $('#fTLdtTo').val(''); $('#fTLdtFrom').val('');
    });




    /* Triggers Date To Searching of Time-In/Time-Out */
    $(document).on('keyup change', '#fTLdtTo', async function () {
        var dateFrom = new Date($('#fTLdtFrom').val());
        var dateTo = new Date($(this).val());
        if (dateTo < dateFrom) {
            $(this).val($('#fTLdtFrom').val());
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range',
                // text: '',
            });
        }
    });
    /* END - Date From and Date To Searching */


    /* Double Click event to show Employee details */
    $(document).on('dblclick', '.view-detailed-timelogs tr', async function () {
        $('#dataLoad').css({
            'display': 'flex',
            'position': 'absolute',
        });

        $.ajax({
            url: '/timelogs-perday',
            method: 'get',
            data: { 'id': $(this).attr('id') },
            success: function (data) {
                // $('#dataLoad').hide(); Swal.fire({ html: data }); return false;
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
                        var imagePath = data[n]['image_path'] ?? '';
                        var fullFilePath = `/storage/timelogs/${imagePath}.txt`;
                        var withGeoLoc = (data[n]['latitude'] && data[n]['longitude']) ? 1 : 0;
                        // var googleMapsUrl = `https://www.google.com/maps?q=${data[n]['latitude'].toFixed(7)},${data[n]['longitude'].toFixed(7)}`;

                        if (withGeoLoc) {
                            var googleMapsUrl = `https://www.google.com/maps?q=${data[n]['latitude'].toFixed(7)},${data[n]['longitude'].toFixed(7)}`;
                        }

                        fetch(fullFilePath)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error("Failed to fetch file");
                                }
                                return response.text();
                            })
                            .then(fileContent => {
                                var viewOnMap = `<td>
                                                <img width="124px" src="${fileContent}" />
                                                ${withGeoLoc ? `<a href="${googleMapsUrl}" class="text-sm text-primary" target="_blank">view on map</a>` : ''}
                                            </td>`;
                                resolve(`<tr>${viewOnMap}
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

                $('#dataLoad').hide(); // Hide the loading indicator after data is loaded
            }
        });
    });

    /*==== EXPORT TO EXCEL TIMELOGS - Start ====*/
    $(document).on('click', '#exportExcel', async function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/export-timelogs-xls',
            method: 'get',
            data: {
                'id': uID,
                'office': $('#fTLOffice').val(),
                'department': $('#fTLDept').val(),
                'timeIn': $('#fTLdtFrom').val(),
                'timeOut': $('#fTLdtTo').val(),
                'search': $('#search').val(),
            },
            success: function (response) {
                // prompt('test',response); return false;

                // Extracting data from the SQL response JSON
                const { tlSummary, tlDetailed, currentDate } = response;
                var currentDateValue = currentDate;

                /* Columns for Summary Timelogs */
                var columnMappings1 = {
                    'department': 'Department',
                    'full_name': 'Name',
                    'biometrics_id': 'Staff Code',
                    'tdate': 'Date',
                    'tweeks': 'Week',
                    'time_in': 'Time1',
                    'time_out': 'Time2'
                };

                // Define the columns you want to include in the Excel XML content
                var selectedColumns1 = [
                    'department',
                    'full_name',
                    'biometrics_id',
                    'tdate',
                    'tweeks',
                    'time_in',
                    'time_out'
                ];


                /* Columns for Detailed Timelogs */
                var columnMappings2 = {
                    'full_name': 'Name',
                    'biometrics_id': 'Staff Code',
                    'employee_id': 'Employee ID',
                    'tdate': 'Date',
                    'tweeks': 'Week',
                    'time_in': 'Time-In',
                    'time_out': 'Time-Out',
                    'head_name': 'Supervisor',
                    'office': 'Office',
                    'department': 'Department'
                };

                // Define the columns you want to include in the Excel XML content
                var selectedColumns2 = [
                    'full_name',
                    'biometrics_id',
                    'employee_id',
                    'tdate',
                    'tweeks',
                    'time_in',
                    'time_out',
                    'head_name',
                    'office',
                    'department',
                ];

                // Extract data for Excel XML content
                var data1 = [];
                var data2 = [];

                // Push headers as the first row of data for Timelogs Summary
                data1.push(selectedColumns1.map(column => columnMappings1[column]));
                // Extract table data for Timelogs Summary
                tlSummary.forEach(function (employee) {
                    var rowData = selectedColumns1.map(column => {
                        var value = employee[column];
                        return (value !== null && value !== undefined) ? value : '';
                    });
                    data1.push(rowData);
                });

                // Push headers as the first row of data for Detailed Timelogs
                data2.push(selectedColumns2.map(column2 => columnMappings2[column2]));
                // Extract table data for Detailed Timelogs
                tlDetailed.forEach(function (employee2) {
                    var rowData2 = selectedColumns2.map(column2 => {
                        var value2 = employee2[column2];
                        return (value2 !== null && value2 !== undefined) ? value2 : '';
                    });
                    data2.push(rowData2);
                });

                // Create Excel XML content
                var xmlContent = '<?xml version="1.0"?>\n';
                xmlContent += '<?mso-application progid="Excel.Sheet"?>\n';
                xmlContent += '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"\n';
                xmlContent += ' xmlns:o="urn:schemas-microsoft-com:office:office"\n';
                xmlContent += ' xmlns:x="urn:schemas-microsoft-com:office:excel"\n';
                xmlContent += ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"\n';
                xmlContent += ' xmlns:html="http://www.w3.org/TR/REC-html40">\n';

                //======= Sheet 1 - Timelogs Summary =======//
                xmlContent += '<Worksheet ss:Name="Timelogs Summary">\n';
                xmlContent += '<Table>\n';

                //==== Add headers for Timelogs Summary ====//
                xmlContent += '<Row>\n';
                selectedColumns1.forEach(function (column) {
                    xmlContent += `<Cell><Data ss:Type="String">${columnMappings1[column]}</Data></Cell>\n`;
                });
                xmlContent += '</Row>\n';

                // Add data rows for Timelogs Summary
                data1.slice(1).forEach(function (row) {
                    xmlContent += '<Row>\n';
                    row.forEach(function (cell) {
                        cell = cell.toString()
                            .replace(/&/g, '&amp;')
                            .replace(/'/g, '&apos;')
                            .replace(/"/g, '&quot;');
                        xmlContent += `<Cell><Data ss:Type="String">${cell}</Data></Cell>\n`;
                    });
                    xmlContent += '</Row>\n';
                });

                xmlContent += '</Table>\n';
                xmlContent += '</Worksheet>\n';

                //======= Sheet 2 - Detailed Timelogs =======//
                xmlContent += '<Worksheet ss:Name="Detailed Timelogs">\n';
                xmlContent += '<Table>\n';
                // Add headers for Detailed Timelogs
                xmlContent += '<Row>\n';
                selectedColumns2.forEach(function (column2) {
                    xmlContent += `<Cell><Data ss:Type="String">${columnMappings2[column2]}</Data></Cell>\n`;
                });
                xmlContent += '</Row>\n';


                // Swal.fire({ html: data2 }); return false;
                // Add data rows for Detailed Timelogs
                data2.slice(1).forEach(function (row2) {
                    xmlContent += '<Row>\n';
                    row2.forEach(function (cell2) {
                        cell2 = cell2.toString()
                            .replace(/&/g, '&amp;')
                            .replace(/'/g, '&apos;')
                            .replace(/"/g, '&quot;');
                        xmlContent += `<Cell><Data ss:Type="String">${cell2}</Data></Cell>\n`;
                    });
                    xmlContent += '</Row>\n';
                });
                xmlContent += '</Table>\n';
                xmlContent += '</Worksheet>\n';

                xmlContent += '</Workbook>';

                // Create a blob from the XML content
                var blob = new Blob([xmlContent], { type: 'application/vnd.ms-excel' });
                var url = window.URL.createObjectURL(blob);

                var filename = `1DOC_${currentDateValue}.xlsx`; // Use .xlsx extension for Excel files

                // Create a download link
                var a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();

                // Clean up
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);


            }
        });
        return false;
    });
    /*==== EXPORT TO EXCEL TIMELOGS - End ====*/





});


