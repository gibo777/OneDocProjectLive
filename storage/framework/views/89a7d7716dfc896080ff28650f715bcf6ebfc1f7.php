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
        @page  {
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


        <img src='data:image/jpeg;base64, <?php echo e($data['imageLogo']); ?>' width="300px" height="85px" />
        

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


        <?php $__currentLoopData = $data['user_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="float: right; margin-top:-14% ">
                <center> 
                    <img src='data:image/jpeg;base64, <?php echo e($data['PimageLogo']); ?>' width="150px" height="150px" />
                </center>
                <br>
                <table>
                    <tr>
                        <td style="background-color:black; color: white; "><b>Employee No.</b></td>
                        <td><?php echo e($user_details->employee_id); ?></td>
                    </tr>
                    <tr>
                        <td style="background-color:black; color: white;"><b>Date Submitted</b></td>
                        <td><?php echo e(date('m/d/Y')); ?></td>
                    </tr>
                </table>
            </div>


            <br><br> <br><br><br><br>
            <center>
                <div class="title"> Personal Data Sheet </div>
            </center>

            <table style="font-size: 12px">



                <tr>

                    <td><b>Last Name : </b><?php echo e($user_details->last_name); ?></td>
                    <td> <b>First Name : </b><?php echo e($user_details->first_name); ?></td>
                    <td> <b>Mid. Name : </b><?php echo e($user_details->middle_name); ?></td>
                </tr>
            </table>


            <h3>Personal Information</h3>
            <table>

                <tr>
                    <td> <b>Height:</b>
                        <?php if($user_details->height != null): ?>
                            <?php echo e($user_details->height); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>Weight:</b>
                        <?php if($user_details->weight != null): ?>
                            <?php echo e($user_details->weight); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>Sex:</b>
                        <?php if($user_details->gender): ?>
                            <?php echo e($user_details->gender); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>Civil Status:</b>
                        <?php if($user_details->civil_status != null): ?>
                            <?php echo e($user_details->civil_status); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td> <b>Citizenship:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>Religion:</b>
                        <?php if($user_details->religion != null): ?>
                            <?php echo e($user_details->religion); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>Birth Date:</b>
                        <?php if($user_details->birthdate != null): ?>
                            <?php echo e($user_details->birthdate); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>Birth Place:</b>
                        <?php if($user_details->birth_place != null): ?>
                            <?php echo e($user_details->birth_place); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="3"> <b>City Address:</b>
                        <?php if($user_details->home_address != null): ?>
                            <?php echo e(join(', ',[$user_details->home_address,$user_details->barangay,$user_details->city,$user_details->province])); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>Contact No.:</b>
                        <?php if($user_details->contact_number != null): ?>
                            <?php echo e($user_details->contact_number); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="3"> <b>Prov. Address:</b>
                        <?php if($user_details->home_address != null): ?>
                            <?php echo e($user_details->province); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>Mobile No.:</b>
                        <?php if($user_details->mobile_number != null): ?>
                            <?php echo e($user_details->mobile_number); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
            </table>


            <h3>Accounting Data</h3>
            <table>

                <tr>
                    <td> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>PHIC No.:</b>
                        <?php if($user_details->religion != null): ?>
                            
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>PAG-IBIG No.:</b>
                        <?php if($user_details->birthdate != null): ?>
                            
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>TIN:</b>
                        <?php if($user_details->birth_place != null): ?>
                            
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
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
                <td colspan="2">Last Name: <?php echo e($user_details->last_name); ?></td>
                <td colspan="2">Mid. Name: <?php echo e($user_details->middle_name); ?></td>

                <tr>

                </tr>

                <tr>

                    <td>Mid. Name: <?php echo e($user_details->middle_name); ?></td>
                    <td>Mid. Name: <?php echo e($user_details->middle_name); ?></td>
                    <td colspan="2">Last Name: <?php echo e($user_details->last_name); ?></td>
                </tr>
            </table>


            <h3>Family Background</h3>
            <table>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>

                </tr>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>

                </tr>

                <tr>
                    <td> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>

                    <td> <b>PAG-IBIG No.:</b>
                        <?php if($user_details->birthdate != null): ?>
                            <?php echo e($user_details->birthdate); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>TIN:</b>
                        <?php if($user_details->birth_place != null): ?>
                            <?php echo e($user_details->birth_place); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>

                </tr>

                <tr>
                    <td> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>

                    <td colspan="2"> <b>TIN:</b>
                        <?php if($user_details->birth_place != null): ?>
                            <?php echo e($user_details->birth_place); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>

                </tr>
                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>

                </tr>
            </table>

            <br><br>
            <table>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>

                </tr>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>



                <tr>
                    <td> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>

                    <td> <b>PAG-IBIG No.:</b>
                        <?php if($user_details->birthdate != null): ?>
                            <?php echo e($user_details->birthdate); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td> <b>TIN:</b>
                        <?php if($user_details->birth_place != null): ?>
                            <?php echo e($user_details->birth_place); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>

                </tr>


                <tr>
                    <td colspan="3"> <b>SSS No.:</b>
                        <?php if($user_details->citizenship != null): ?>
                            <?php echo e($user_details->citizenship); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </main>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views/reports/perosonal-data-sheet.blade.php ENDPATH**/ ?>