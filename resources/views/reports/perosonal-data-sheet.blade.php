<html>

<head>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;

            width: 100%;

        }

        td {
            padding-left: 10px;
            padding-top: 5px;
            padding-right: 10px;
        }

        table {
            font-size: 12px;
        }

        /**
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
            font-family: sans-serif;
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

        .title {
            font-size: 28px;

            +'-weight: bolder

        }

        /* input {
            border: 0;
            outline: 0;
            background: transparent;
            border-bottom: 1px solid black;
        } */

        input[type=checkbox] {
            vertical-align: middle;
            position: relative;
            bottom: 1px;
        }

        label {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>


        <img src='data:image/jpeg;base64, {{ $data['imageLogo'] }}' width="300px" height="85px" />
        {{-- <img src='as' width="300px" height="100px" /> --}}

    </header>

    <footer style="font-size: 12px;">
        <hr>
        <div style="color: #15124b; font-weight:bold; ">
            IMC BUILDING, LRA Central Offices Compound, East Avenue cor. NIA Road, Diliman,
            Quezon City 1100 PHILIPPINES Telfax numbersm, 435-5696 and 441-1091
        </div>
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>


        @foreach ($data['user_details'] as $user_details)
            <div style="float: right; margin-top:-14% ">
                <center> 
                    <img src='data:image/jpeg;base64, {{ $data['PimageLogo'] }}' width="150px" height="150px" />
                </center>
                <br>
                <table>
                    <tr>
                        <td style="background-color:black; color: white; "><b>Employee No.</b></td>
                        <td>{{ $user_details->employee_id }}</td>
                    </tr>
                    <tr>
                        <td style="background-color:black; color: white;"><b>Date Submitted</b></td>
                        <td>{{ date('m/d/Y') }}</td>
                    </tr>
                </table>
            </div>


            <br><br> <br><br><br><br>
            <center>
                <div class="title"> Personal Data Sheet </div>
            </center>

            <table style="font-size: 12px">



                <tr>

                    <td><b>Last Name : </b>{{ $user_details->last_name }}</td>
                    <td> <b>First Name : </b>{{ $user_details->first_name }}</td>
                    <td> <b>Mid. Name : </b>{{ $user_details->middle_name }}</td>
                </tr>
            </table>


            <h3>Personal Information</h3>
            <table>

                <tr>
                    <td> <b>Height:</b>
                        @if ($user_details->height != null)
                            {{ $user_details->height }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>Weight:</b>
                        @if ($user_details->weight != null)
                            {{ $user_details->weight }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>Sex:</b>
                        @if ($user_details->gender)
                            {{ $user_details->gender }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>Civil Status:</b>
                        @if ($user_details->civil_status != null)
                            {{ $user_details->civil_status }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>

                <tr>
                    <td> <b>Citizenship:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>Religion:</b>
                        @if ($user_details->religion != null)
                            {{ $user_details->religion }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>Birth Date:</b>
                        @if ($user_details->birthdate != null)
                            {{ $user_details->birthdate }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>Birth Place:</b>
                        @if ($user_details->birth_place != null)
                            {{ $user_details->birth_place }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>

                <tr>
                    <td colspan="3"> <b>City Address:</b>
                        @if ($user_details->home_address != null)
                            {{ join(', ',[$user_details->home_address,$user_details->barangay,$user_details->city,$user_details->province]) }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>Contact No.:</b>
                        @if ($user_details->contact_number != null)
                            {{ $user_details->contact_number }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>

                <tr>
                    <td colspan="3"> <b>Prov. Address:</b>
                        @if ($user_details->home_address != null)
                            {{ $user_details->province }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>Mobile No.:</b>
                        @if ($user_details->mobile_number != null)
                            {{ $user_details->mobile_number }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            </table>


            <h3>Accounting Data</h3>
            <table>

                <tr>
                    <td> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>PHIC No.:</b>
                        @if ($user_details->religion != null)
                            {{-- {{ $user_details->religion }} --}}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>PAG-IBIG No.:</b>
                        @if ($user_details->birthdate != null)
                            {{-- {{ $user_details->birthdate }} --}}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>TIN:</b>
                        @if ($user_details->birth_place != null)
                            {{-- {{ $user_details->birth_place }} --}}
                        @else
                            N/A
                        @endif
                    </td>

                </tr>

                <tr>
                    <td> <b>Tax Status:</b><br>
                        <input type="checkbox" />Single <br>
                        <input type="checkbox" value="">Head Of The Family<br>
                        <input type="checkbox" value="">Married
                    <td colspan="2">
                        <b>Dependendents:</b><br>
                        1.<input type="text"></input><br>
                        2.<input></input><br>
                        3.<input></input><br>
                        4.<input></input><br>
                    </td>
                    <td> <b>Birth Date:</b><br>
                        <input></input><br>
                        <input></input><br>
                        <input></input><br>
                        <input></input><br>

                </tr>
                <td colspan="2">Last Name: {{ $user_details->last_name }}</td>
                <td colspan="2">Mid. Name: {{ $user_details->middle_name }}</td>

                <tr>

                </tr>

                <tr>

                    <td>Mid. Name: {{ $user_details->middle_name }}</td>
                    <td>Mid. Name: {{ $user_details->middle_name }}</td>
                    <td colspan="2">Last Name: {{ $user_details->last_name }}</td>
                </tr>
            </table>


            <h3>Family Background</h3>
            <table>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>

                </tr>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>

                </tr>

                <tr>
                    <td> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>

                    <td> <b>PAG-IBIG No.:</b>
                        @if ($user_details->birthdate != null)
                            {{ $user_details->birthdate }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>TIN:</b>
                        @if ($user_details->birth_place != null)
                            {{ $user_details->birth_place }}
                        @else
                            N/A
                        @endif
                    </td>

                </tr>

                <tr>
                    <td> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>

                    <td colspan="2"> <b>TIN:</b>
                        @if ($user_details->birth_place != null)
                            {{ $user_details->birth_place }}
                        @else
                            N/A
                        @endif
                    </td>

                </tr>
                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>

                </tr>
            </table>

            <br><br>
            <table>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>

                </tr>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>



                <tr>
                    <td> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>

                    <td> <b>PAG-IBIG No.:</b>
                        @if ($user_details->birthdate != null)
                            {{ $user_details->birthdate }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td> <b>TIN:</b>
                        @if ($user_details->birth_place != null)
                            {{ $user_details->birth_place }}
                        @else
                            N/A
                        @endif
                    </td>

                </tr>


                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        @if ($user_details->citizenship != null)
                            {{ $user_details->citizenship }}
                        @else
                            N/A
                        @endif
                    </td>

                </tr>
            </table>



            <h3>Educational Background</h3>
            <table>

                <tr>
                    <th>Type</th>
                    <th>School</th>
                    <th>Type</th>
                    <th>School</th>
                    <th>School</th>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <p>*TYPE (primary, secondary, college, vocational, etc.)</p>


            <h3>Employment History</h3>
            <table>

                <tr>
                    <th>Employer's Name</th>
                    <th>Nature of Business</th>
                    <th>Position</th>
                    <th>Date From</th>
                    <th>Date To</th>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <h3>Character References</h3>
            <table>

                <tr>
                    <th>Name</th>
                    <th>Company / Contact No.</th>
                    <th>Address</th>
                    <th>Position</th>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>


            </table>

            <div class="row">
                <p>Have you ever been convicted by a court of law? <input type="checkbox">Yes <input type="checkbox">No
                </p>
                <p>If yes, please provide date/s and conviction/s:_________________________</p>
                <br>
                I certify that the information contained herein is correct.
            </div><br><br><br>
            <div class="row" style="float: right;">
                <table>

                    <thead>
                        <th colspan="2" style="background-color:black; color: white; "> For HR Use Only:</th>
                        <thead>
                        <tbody>
                            <tr>
                                <td>Received By:</td>
                                <td>Emp. ID No.:</td>
                            </tr>
                            <tr>
                                <td>RReceived Date:</td>
                                <td>Encoded On/By:</td>
                            </tr>
                        </tbody>
                </table>
            </div>
        @endforeach
    </main>
</body>

</html>
