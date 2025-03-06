@extends('layouts.template')

@push('styles')
    <style>
        .main-wrapper {
            margin-left: auto;
            margin-right: auto;
            max-width: 48rem;
            border-radius: 0.125rem;
            border-width: 1px;
        }

        .wrapper {
            display: flex;
            align-items: center;
        }

        .left-wrapper {
            display: flex;
            padding: 0.75rem;
            background-color: #d1fae5;
            flex-direction: column;
            height: 100%;
            border-right-width: 4px;
            border-color: #6b7280;
            border-style: dotted;
            gap: 0.75rem;
            width: 25%;
        }

        .left-item {
            padding-bottom: 0.25rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            width: 100%;
            border-bottom: 1px solid lightgrey;
        }

        .left-company-item-wrapper {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .text-center {
            text-align: center;
        }

        .left-qr-code {
            padding: 0.125rem;
            background-color: #ffffff;
            width: 5rem;
            height: 5rem;
            border-radius: 0.25rem;
        }

        .left-qr-code img {
            object-fit: contain;
            width: 100%;
        }

        .powered-by {
            display: block;
            padding-bottom: 0.25rem;
            padding-top: 0.5rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            text-align: center;
        }

        .left-logo {
            object-fit: contain;
            width: 6rem;
        }

        .right-wrapper {
            padding: 0.75rem;
            width: 75%;
        }

        .coupon-container {
            display: flex;
            justify-content: flex-end;
        }

        .coupon-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .coupon-title {
            color: #4b5563;
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .coupon-number {
            padding: 0.25rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            background-color: #d1fae5;
            color: #6b7280;
            font-weight: 500;
            text-align: center;
            width: 12rem;
            border-radius: 0.25rem;
        }

        .company-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .company-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .company-logo {
            object-fit: contain;
            width: 9rem;
        }

        .company-detail-wrapper {
            display: flex;
            flex-direction: column;
        }

        .company-detail-wrapper .item {
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 600;
        }

        .company-container .logo {
            object-fit: contain;
            width: 6rem;
        }

        .amount-container {
            display: flex;
            margin-top: 0.5rem;
            color: #047857;
            flex-direction: column;
            gap: 1.25rem;
        }

        .amount-wrapper {
            display: flex;
            padding-bottom: 0.25rem;
            font-size: 1.125rem;
            line-height: 1.75rem;
            font-weight: 600;
            justify-content: space-between;
            width: 100%;
            border-bottom: 2px solid lightgrey;
        }

        .memo-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .memo {
            padding-bottom: 0.25rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 400;
            border-bottom: 1px solid lightgrey;
            width: 50%;
        }

        .memo-intro {
            font-size: 0.75rem;
            line-height: 1rem;
            font-weight: 400;
        }

        .redeem-container {
            display: flex;
            margin-top: 1rem;
            color: #047857;
            flex-direction: column;
        }

        .redeem-wrapper-main {
            display: flex;
            justify-content: space-between;
        }

        .redeem-wrapper {
            display: flex;
            align-items: flex-end;
            gap: 0.25rem;
        }

        .redeem-qr-code {
            padding: 0.125rem;
            background-color: #ffffff;
            width: 3rem;
            height: 3rem;
            border-radius: 0.25rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .redeem-qr-code img {
            object-fit: contain;
            width: 100%;
        }

        .short-url {
            padding: 0.25rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            background-color: #d1fae5;
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            border-radius: 0.25rem;
        }

        .mt-3 {
            margin-top: 0.75rem;
        }
    </style>
@endpush

@section('content')
    <section class="main-wrapper">
        <div class="wrapper">
            <div class="left-wrapper">
                <p class="left-item">Charity</p>
                <p class="left-item">Date</p>
                <p class="left-item">{{ $amount_in_digits }}</p>
                <p class="left-item">Memo</p>
                <div class="left-company-item-wrapper">
                    <div class="text-center">
                        <div class="left-qr-code">{!! $sponsor_qr_code !!}</div>
                        <span class="powered-by">Powered by</span>
                        <img src="{{ $adlee_logo }}" alt="Adlee logo" class="left-logo" />
                    </div>
                </div>
            </div>

            <div class="right-wrapper">
                <div class="coupon-container">
                    <div class="coupon-wrapper">
                        <p class="coupon-title">Coupon No:</p>
                        <p class="coupon-number">{{ $coupon_number }}</p>
                    </div>
                </div>

                <div class="company-container">
                    <div class="company-wrapper">
                        <img src="{{ $sponsor_logo }}" alt="{{ $sponsor_name }}" class="company-logo" />
                        <div class="company-detail-wrapper">
                            <span class="item">{{ $sponsor_name }}</span>
                            <span class="item">{{ $sponsor_address }},</span>
                            <span class="item">{{ $sponsor_city }}, {{ $sponsor_zipcode }}</span>
                        </div>
                    </div>
                    <img src="{{ $adlee_logo }}" alt="Adlee logo" class="logo" />
                </div>

                <div class="amount-container">
                    <p class="amount-wrapper">
                        <span>{{ $amount_in_words }}</span>
                        <span>${{ $amount_in_digits }}</span>
                    </p>
                    <div class="memo-wrapper">
                        <p class="memo">Memo</p>
                        <p class="memo-intro">This is not a check</p>
                    </div>
                </div>

                <div class="redeem-container">
                    <div class="redeem-wrapper-main">
                        <div class="redeem-wrapper">
                            <span style="font-size: 8px">Scan QR code to redeem</span>
                            <div class="redeem-qr-code">{!! $bbo_qr_code !!}</div>
                        </div>
                        <div class="redeem-wrapper">
                            <span style="font-size: 9px">Or go to</span>
                            <p class="short-url">{{ $shorten_url }}</p>
                        </div>
                    </div>
                    <p style="font-size: 9px" class="mt-3">
                        Please follow instructions on back for redemption
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
