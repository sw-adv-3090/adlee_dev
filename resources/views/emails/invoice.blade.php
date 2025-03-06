<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr;
        }

        .card {
            padding: 3rem 1.25rem;
        }

        @media (min-width: 640px) {
            .card {
                padding: 3rem 4.5rem;
            }
        }

        .flex-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .flex-row {
            display: flex;
            justify-content: space-between;
        }

        @media (min-width: 640px) {
            .flex-container {
                flex-direction: row;
            }
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        @media (min-width: 640px) {
            .text-left {
                text-align: left;
            }
        }

        .text-right {
            text-align: right;
            /* margin-top: 1rem; */
        }

        @media (min-width: 640px) {
            .text-right {
                text-align: right;
                margin-top: 0;
            }
        }

        .heading-primary {
            font-size: 1.25rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #3490dc;
        }

        .dark .heading-primary {
            color: #c3e6e5;
        }

        .address,
        .invoice-info,
        .client-info,
        .payment-details,
        .total-details {
            padding-top: 0.5rem;
            line-height: 1.5;
        }

        .divider {
            margin: 1.75rem 0;
            height: 1px;
            background-color: #e2e8f0;
        }

        .dark .divider {
            background-color: #2a4365;
        }

        .table-container {
            overflow-x: auto;
            min-width: 100%;
        }

        .invoice-table {
            width: 100%;
            text-align: left;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 0.75rem 1rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .invoice-table th {
            background-color: #e2e8f0;
            color: #2d3748;
        }

        .dark .invoice-table th {
            background-color: #2a4365;
            color: #e2e8f0;
        }

        .invoice-table td {
            background-color: #f7fafc;
        }

        .font-normal {
            font-weight: 400;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-right {
            text-align: right;
        }

        .description {
            font-size: 0.875rem;
        }

        .final-total {
            font-size: 1.25rem;
            color: #3490dc;
        }

        .dark .final-total {
            color: #c3e6e5;
        }

        .logo {
            width: 15%;
            object-fit: contain;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .pt-0 {
            padding-top: 0 !important;
        }

        .pt-1 {
            padding-top: 0.25rem !important;
        }

        .capitalize {
            text-transform: capitalize !important;
        }

        .w-full {
            width: 100%;
        }
    </style>
</head>

<body>
    <main>
        <div class="grid-container">
            <div class="card">
                <div style="width: 100%;">
                    <div class="text-left">
                        <img src="{{ asset('logo.png') }}" alt="Adlee Logo" class="logo">
                        {{-- <img src="https://adlee.io/logo.png" alt="Adlee Logo" class="logo"> --}}
                        {{-- <h2 class="heading-primary">Adlee</h2> --}}
                        <div class="address">
                            {{-- <h3>Adlee</h3> --}}
                            {{-- <p>12345 Sunny Road</p>
                            <p>Sunnyville, CA 12345</p> --}}
                        </div>
                    </div>
                    <div class="text-right w-full">
                        <h2 class="heading-primary">invoice</h2>
                        <div class="invoice-info">
                            <p>Invoice #: <span class="font-semibold">{{ $transaction->number }}</span></p>
                            <p>Created: <span class="font-semibold">{{ now()->format('F j, Y h:i:A') }}</span></p>
                            <p>Paid: <span
                                    class="font-semibold">{{ $transaction->created_at->format('F j, Y h:i:A') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div style="width: 100%;margin-bottom:60px;">
                    <div class="text-left">
                        <p class="invoiced-to mb-2">Invoiced From:</p>
                        <img src="{{ asset($transaction->sponsor?->company_logo) }}" alt="Sponsor Logo" class="logo">
                        {{-- <img src="https://adlee.io/storage/uploads/bYijSiPc0xe13lVl2UwU6GqL7Lhm7t6uBtsG54sk.png"
                            alt="Sponsor Logo" class="logo"> --}}
                        <div class="client-info pt-1">
                            <p class="font-semibold">{{ $transaction->sponsor?->company_name }}</p>
                            {{-- <p>{{ $transaction->sender?->email }}</p> --}}
                            <p style="text-transform: capitalize;">{{ $transaction->sponsor?->address }},
                                {{ $transaction->sponsor?->city }},
                                {{ $transaction->sponsor?->state }}, {{ $transaction->sponsor?->country }}
                                {{ $transaction->sponsor?->postal_code }}.</p>
                        </div>
                    </div>
                    <div class="text-right" style="margin-top: -150px;">
                        <p class="invoiced-to mb-2">Invoiced To:</p>
                        <img src="{{ asset($transaction->company?->company_logo) }}" alt="BBO Logo" class="logo">
                        {{-- <img src="https://adlee.io/storage/uploads/SQVN4veP7Y0XlcuN1ynyqV1xaEu4FhimO4YArbTt.png"
                            alt="BBO Logo" class="logo"> --}}
                        <div class="client-info pt-1">
                            <p class="font-semibold">{{ $transaction->company?->company_name }}</p>
                            {{-- <p>{{ $transaction->receiver?->email }}</p> --}}
                            {{-- <p>260 W. Storm Street, New York, NY 10025.</p> --}}
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
                                {{-- <th class="text-center">Service Fee</th> --}}
                                {{-- <th class="text-center">Transaction Fee</th> --}}
                                {{-- <th class="text-center">Paid Amount</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div>
                                        <p class="description mb-1">Sponsorship Payment</p>
                                        <p class="font-medium uppercase">Payment for coupon number
                                            {{ $transaction->coupon?->number }}</p>
                                    </div>
                                </td>
                                <td class="text-center">${{ number_format($transaction->amount, 2) }}</td>
                                {{-- <td class="text-center">${{ $transaction->service_fee }}</td> --}}
                                {{-- <td class="text-center">${{ $transaction->transaction_fee }}</td> --}}
                                {{-- <td class="text-center">${{ $transaction->paid_amount }}</td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="text-right">
                    <p class="total font-semibold">Total:</p>
                    <div class="total-details">
                        <p>Sub Total : <span class="font-semibold">${{ number_format($transaction->amount, 3) }}</span>
                        </p>
                        @if ($type === 'sponsor')
                            <p>Transaction Fee ({{ $transaction->transaction_fee_percentage }}%) : <span
                                    class="font-semibold">${{ number_format($transaction->transaction_fee, 3) }}</span>
                            </p>
                        @endif

                        @if (
                            ($type === 'sponsor' && $transaction->commission_paid) ||
                                ($type === 'ad-space-owner' && !$transaction->commission_paid))
                            <p>Service Fee ({{ $transaction->service_fee_percentage }}%) : <span
                                    class="font-semibold">${{ number_format($transaction->service_fee, 3) }}</span></p>
                        @endif
                        <p class="final-total">Total: <span
                                class="font-semibold">${{ number_format($type === 'sponsor' ? $transaction->paid_amount : $transaction->receiver_amount, 3) }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
