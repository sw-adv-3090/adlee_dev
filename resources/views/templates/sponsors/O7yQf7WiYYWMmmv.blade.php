@extends('layouts.template')

@push('styles')
    <style>
        .main-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background-color: #cccccc;
            border-radius: 5px;
            padding: 10px;
            min-height: 600px;
            background-image: url("https://adlee.io/storage/uploads/dnRdMh3fxFvLI8FGe1Mi5zF1wDWq8mnexmgGRhsY.jpg");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .relative {
            position: relative;
        }

        .person-name-wrapper {
            position: absolute;
            top: 230px;
            right: 340px;
            font-size: 20px;
            font-weight: 600;
        }

        .company-name {
            position: absolute;
            top: 290px;
            right: 340px;
            font-size: 18px;
            font-weight: 600;
        }

        .company-logo {
            width: 100px;
            height: 40px;
            object-fit: contain;
            position: absolute;
            top: 270px;
            right: 320px;
        }

        .honor-wrapper {
            width: 250px;
            position: absolute;
            top: 371px;
            right: 230px;
        }

        .honor-name {
            font-size: 20px;
            font-weight: 700;
        }

        .qr-code {
            width: 65px;
            height: 65px;
            object-fit: contain;
            position: absolute;
            top: 515.5px;
            right: 195.5px;
            border-radius: 10px;
        }

        .qr-code-wrapper {
            width: 65px;
            height: 65px;
            position: absolute;
            top: 515.5px;
            right: 195.5px;
            border-radius: 10px;
        }

        .qr-code-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
@endpush

@section('content')
    <section class="main-wrapper">
        <div class="relative">
            <div class="person-name-wrapper">
                <span>{{ $person_name }}</span>
            </div>

            <h4 class="company-name">{{ $sponsor_name }}</h4>

            <img src="{{ $sponsor_logo }}" alt="{{ $sponsor_name }}" class="company-logo" />

            <div class="honor-wrapper">
                <h4 class="honor-name">{{ $commemoration }}</h4>
            </div>

            <div class="qr-code-wrapper">{!! $qr_code !!}</div>
        </div>
    </section>
@endsection
