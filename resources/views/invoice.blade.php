<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    {{-- link css style from public folder --}}
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
</head>

<body>
    <main>
        <div class="grid-container">
            <div class="card">
                <div class="flex-container">
                    <div class="text-left">
                        <img src="{{ asset('logo.png') }}" alt="Adlee Logo" class="logo">
                        {{-- <h2 class="heading-primary">Adlee</h2> --}}
                        <div class="address">
                            <h3>Adlee</h3>
                            {{-- <p>12345 Sunny Road</p>
                            <p>Sunnyville, CA 12345</p> --}}
                        </div>
                    </div>
                    <div class="text-right w-full">
                        <h2 class="heading-primary">invoice</h2>
                        <div class="invoice-info">
                            <p>Invoice #: <span class="font-semibold">123558844422682</span></p>
                            <p>Created: <span class="font-semibold">June 23, 2021</span></p>
                            <p>Paid: <span class="font-semibold">July 23, 2021 11:03 PM</span></p>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex-container">
                    <div class="text-left">
                        <p class="invoiced-to mb-2">Invoiced From:</p>
                        <img src="{{ asset('demo/company-logo-1.png') }}" alt="Sponsor Logo" class="logo">
                        <div class="client-info pt-1">
                            <p class="font-semibold">John Doe</p>
                            <p>johndoe@example.com</p>
                            <p>260 W. Storm Street, New York, NY 10025.</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="invoiced-to mb-2">Invoiced To:</p>
                        <img src="{{ asset('demo/company-logo-2.png') }}" alt="BBO Logo" class="logo">
                        <div class="client-info pt-1">
                            <p class="font-semibold">John Doe</p>
                            <p>johndoe@example.com</p>
                            <p>260 W. Storm Street, New York, NY 10025.</p>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="table-container">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>DESCRIPTION</th>
                                <th class="text-center">Amount</th>
                                {{-- <th class="text-center">Service Fee</th>
                                <th class="text-center">Transaction Fee</th> --}}
                                {{-- <th class="text-center">Paid Amount</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div>
                                        <p class="description mb-1">Coupon Payment</p>
                                        <p class="font-medium capitalize">Payment for coupon numner NS-215-5522</p>
                                    </div>
                                </td>
                                <td class="text-center">$10</td>
                                {{-- <td class="text-center">$55</td>
                                <td class="text-center">$55</td> --}}
                                {{-- <td class="text-center">$550</td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="text-right">
                    <p class="total font-semibold">Total:</p>
                    <div class="total-details">
                        <p>Sub Total : <span class="font-semibold">$7320</span></p>
                        <p>Transaction Fee (2%) : <span class="font-semibold">$20</span></p>
                        <p>Service Fee (2%) : <span class="font-semibold">$20</span></p>
                        <p class="final-total">Total: <span class="font-semibold">$8780</span></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
