<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;

            width: 100%;

        }

        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2.5cm;
            margin-left: 2.5cm;
            margin-right: 2.5cm;
            margin-bottom: 2.5cm;
            font-family: sans-serif;
            border: 1px solid black;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 1cm;
            right: 1cm;
            height: 3cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 2cm;
        }

        * {
            box-sizing: border-box;
        }

        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 50%;
            padding: 10px;
            height: 50px;

            /* Should be removed. Only for demonstration */
        }

        .columnHeader {
            float: left;
            width: 42%;
            padding: 10px;
            height: 100px;
    
            */
            /* Should be removed. Only for demonstration */
        }


        .column-three {
            float: left;
            width: 30%;
            margin-bottom: -20px;
            padding: 10px;
            height: 60px;

            /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .title {
            font-size: 16px;
            font-weight: bolder;

        }

        .Label {
            font-size: 13px;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 90px;
            height: 10px;
            width: 10px;
            background-color: rgb(255, 255, 255);
            border: 2px solid black;

        }



        .containerleft {
            display: block;
            position: relative;
            padding-left: 110px;
            style="margin-top: 2px;" margin-bottom: 12px;
            cursor: pointer;
            font-size: 13px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .containerright {
            display: block;
            position: relative;
            padding-left: 110px;
            style="margin-top: 2px;" margin-bottom: 12px;
            cursor: pointer;
            font-size: 13px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;


        }

        .leftcheckbox {
            position: relative;
            padding-left: 17px;
            margin-bottom: 12px;
        }

        .headerLabel {
            font-size: 12px;
        }

        .container1 {
            padding: 12px;
        }
        .instructionLabel{
            font-size: 11px;
        
        }
        .instructionTitle{
            font-size: 11px;
            font-weight: bold;
        }
        .HRDContainer{
            float: left;
            width: 50%;
            padding: 10px;
            height: 100px;
            margin-top: 10px;
    
        }
        .HRDlabel{
            font-size: 12px;
            text-align: center;
        }
    </style>

</head>

<body>




    <div>
        <div class="row">
            <div class="columnHeader">
                <div class="headerLabel" style="float: left"> Rev. 2023-01 </div><br>
                <img src='data:image/jpeg;base64, {{ $data['imageLogo'] }}' width="275px" height="70px" />
            </div>
            <div class="columnHeader">
                <div class="headerLabel" style="float: right; "> Control NO. {{ $data['leave_details'][0]->control_number }} <br>
                    </div>
            </div>
        </div>

        <center><label class="title">APPLICATION FOR LEAVE ABSENCE</label></center>
    </div>

    @foreach ($data['leave_details'] as $leave_detail)
        <div class="row">
            <div class="column">
                <label class="Label">NAME : {{ $leave_detail->name }}</label><br>
                <label class="Label">DEPARTMENT : {{ $leave_detail->department }} </label><br>
                <label class="containerleft"> Re-filling
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="column">
                <label class="Label">DATE FILE : {{ date('m/d/Y g:i A', strtotime($leave_detail->date_applied)) }} </label><br>
                <label class="Label">EMPLOYEE : {{ $leave_detail->employee_id }} </label><br>
                <label class="containerright "> Cancellation
                    <span class="checkmark"></span>
                </label>

            </div>
        </div>
        <div class="container1">
            <div class="Label"> LEAVE TYPE: {{ $leave_detail->leave_type }} </div>
            <div class="Label"> REASON: {{ $leave_detail->reason }} </div> <br>
            <div class="title">NOTIFICATION OF LEAVE:</div>
        </div>
        <div class="row">
            <div class="column-three">
                <label class="containerleft">IN PERSON
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="column-three">
                <label class="containerleft">BY SMS
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="column-three">
                <label class="containerleft">BY EMAIL
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
        <div class="container1">
            <div class="Label">FROM:<u>{{ $leave_detail->date_from }}</u> TO: <u>{{ $leave_detail->date_to }}</u>

                <label style="float: right;">NUMBER OF DAYS: <u>{{ $leave_detail->no_of_days }}</u></label>
            </div>
        </div>

        <div class="container1">
            <hr>
            <table>
                <tr>
                    <td class="Label">( ) Approved</td>
                    <td class="Label"> Immediate Superior</td>
                </tr>
                <tr>
                    <td class="Label">( ) Approved</td>
                    <td class="Label"> Department Head</td>
                </tr>
            </table>
            <hr>
        </div>

        <center><label class="title">HUMAN RESOURCES DEPARTMENT</label></center>


        <div class="container1">
            <div class="row">
                <div class="columnHeader">
                    <table>
                        <thead>
                            <th colspan="2">STATUS</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="Label">AVAILABLE</td>
                                <td class="Label"></td>
                            </tr>
                            <tr>
                                <td class="Label">TAKEN</td>
                                <td class="Label"></td>
                            </tr>
                            <tr>
                                <td class="Label">BALANCE</td>
                                <td class="Label"></td>
                            </tr>
                            <tr>
                                <td class="Label">AS OF:</td>
                                <td class="Label"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="HRDContainer">
                    <hr>
                    <div class="HRDlabel">HR / ADMIN HEAD <br><br></div>
                    <hr>
                    <div class="HRDlabel">DATE</div>
                </div>
            </div>

            <i><label class="instructionTitle">INSTRUCTION: </center> <br></i>
            <i> <div class="instructionLabel">
                1. Application for leave of absence must be filed at the latest, three (3) working days prior to the
                date of
                leave. In case of emergency, it must be filed immediately upon reporting for work. <br>
                2. Application for sick leave of more than two (2) consecutive days must be supported by a medical
                certificate.
            </div></i>
        </div>
    @endforeach

</body>

</html>
