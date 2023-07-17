<html>

<head>
    <title>Shpping Label</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        @font-face {
            font-family: 'Poppins';
            src: storage_path('Poppins') format('truetype');
        }

        table {
            font-size: 25px;
        }
    </style>

</head>

<body>
    <div style="border-style: solid; border-color: #000000; padding:0px 0 0.4rem 0; width:21rem">
        <table style="margin-left:1rem;margin-top:-1rem;">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <table>
                            <thead>
                                <tr>
                                    <th width="60%"></th>

                                </tr>
                            </thead>
                            @php
                                $user_loc = json_decode($getdata->full_address);
                                
                            @endphp
                            <tr>
                                <td style="font-weight: bold;">
                                    Ship To
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Name: - {{ $getdata->Getuser->name }}
                                </td>
                                <td>

                            </tr>
                            <tr>
                                <td>
                                    @if (isset($user_loc->address_1))
                                        {{ $user_loc->address_1 }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if (isset($user_loc->address_2))
                                        {{ $user_loc->address_2 }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $user_loc->city }} , {{ $user_loc->state }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Pincode - {{ $user_loc->pincode }}
                                </td>

                            </tr>
                        </table>

                        <table style="margin-top:50px;">
                            <tr>
                                <td>Phone - {{ $getdata->GetUser->phone }}</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <div style="margin-top:5rem; margin-left: 4rem; text-align: center;">
                           <div style="height: 6rem;width:6rem;background-color:rgb(199, 196, 196);">
                            <label style="color: #fff; font-size:2rem;">
                                QR CODE
                            </label>
                           
                           </div>
                           <label style="font-size: 20px; text-align: center;">Place Here QR</label>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>




        <hr style="">
        </hr>

        <table>
            <thead>
                <tr>
                    <th style="width: 7rem;"> Payment Type</th>
                    <th style="width: 7rem;">Amount</th>
                    <th style="width: 7rem;">Items</th>
                </tr>
            <tbody>
                <tr>
                    <td style="text-align: center;">
                        Prepaid
                    </td>
                    <td style="text-align: center;">
                        INR {{ $getdata->amount }}
                    </td>
                    <td style="text-align: center;">
                        Printed Items
                    </td>
                </tr>
            </tbody>
            </thead>
        </table>
        <hr>
        </hr>

        <table style="margin-left:1rem">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <table>
                            <thead>
                                <tr>
                                    <th width="60%"></th>

                                </tr>
                            </thead>
                            <tr>
                                <td style="text-overflow: clip; white-space: nowrap;">
                                    <span style="font-weight: bold;">Shipped By </span><small>(If Undelivered Return
                                        To)</small>
                                </td>
                            </tr>
                            @php
                                $branch_loc = json_decode($getdata->Getemp->GetBranchName->address);
                            @endphp
                            <tr>
                                <td>
                                    Jignesh Prints & Packaging
                                </td>
                                <td>

                            </tr>
                            <tr>
                                <td>
                                    @if (isset($branch_loc->adress_line_1))
                                        {{ $branch_loc->adress_line_1 }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if (isset($branch_loc->adress_line_2))
                                        {{ $branch_loc->adress_line_2 }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if (isset($branch_loc->district))
                                        {{ $branch_loc->district }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if (isset($branch_loc->state))
                                        {{ $branch_loc->state }}
                                    @endif , India
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Pincode - @if (isset($branch_loc->pincode))
                                        {{ $branch_loc->pincode }}
                                    @endif
                                </td>

                            </tr>
                        </table>

                        <table style="margin-top:50px;">
                            <tr>
                                <td>Phone - @if (isset($branch_loc->contact_number))
                                        {{ $branch_loc->contact_number }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <div style="margin-top:5rem; margin-left: 0.4rem;text-align: center;">{!! DNS2D::getBarcodeHTML($getdata->order_id, 'QRCODE', 6, 6) !!}
                            <label style="font-size: 20px; text-align: center;">{{ $getdata->order_id }}</label>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        </hr>
        <div style="margin-top:-17px; margin-bottom:-15px; line-height: 75%">


            <small style="margin-left:1rem; font-size:18px;"> 
                1. Visit Official Website of Sasta Prints to View the Condition of Carriage.
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. All Disputes are subject to Nasik Jurisdiction.
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Shipping Charges Are Inclusive Of Service Tax And All Figure Are In INR.
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. Goods Once Sold Will Only Be Taken Back Or Exchanged As Per Store's &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Exchange/Return Policy .
            </small>

        </div>
        <hr>
        </hr>
        <div style="text-align: center; margin-top:-2rem;">
            <small style="margin-left:1rem; font-size:18px;">This Is Auto Genarated Label And Does Not Need
                Signature</small>
        </div>
    </div>

</body>

</html>
