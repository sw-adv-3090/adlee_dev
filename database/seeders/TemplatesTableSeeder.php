<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('templates')->delete();

        \DB::table('templates')->insert(
            array(
                0 =>
                    array(
                        'id' => 1,
                        'uuid' => '8343296b-73b6-466b-bf46-2ffcdf5cc8c9',
                        'type' => 'sponsor',
                        'title' => 'Template 1',
                        'styling' => '<style>
.main-wrapper {
max-width: 800px;
margin: 0 auto;
background-color: #cccccc;
border-radius: 5px;
padding: 10px;
min-height: 600px;
background-image: url("https://adlee.io/storage/uploads/GDRYFvumTjsX9Zh5iRdSyFtNt73IGL353r8Not0r.jpg");
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
</style>',
                        'content' => '
<section class="main-wrapper">
<div class="relative">
<div class="person-name-wrapper">
<span>{{ $person_name }}</span>
</div>

<h4 class="company-name">{{ $sponsor_name }}</h4>

<img
src="{{ $sponsor_logo }}"
alt="{{ $sponsor_name }}"
class="company-logo"
/>

<div class="honor-wrapper">
<h4 class="honor-name">{{ $commemoration }}</h4>
</div>

<div class="qr-code-wrapper">{!! $qr_code !!}</div>
</div>
</section>
',
                        'preview' => 'storage/uploads/gBsiIbkJdGhgWFIIl8SPi0SadECk0a1q3IGTTHjd.png',
                        'active' => 1,
                        'publish_at' => '2024-05-25',
                        'view' => 'templates/sponsors/O7yQf7WiYYWMmmv',
                        'language' => 'english',
                        'category_id' => 8,
                        'sub_category_id' => NULL,
                        'created_at' => '2024-05-25 15:18:45',
                        'updated_at' => '2024-05-25 15:18:45',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'uuid' => 'd2550a89-032c-4dbe-a5e3-664476c80d85',
                        'type' => 'coupon',
                        'title' => 'Template 1',
                        'styling' => '<style>
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
background-color: #d1fae580;
padding-top: 1.7rem;
padding-bottom: 2rem;
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
</style>',
                        'content' => '
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
<img
src="{{ $adlee_logo }}"
alt="Adlee logo"
class="left-logo"
/>
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
<img
src="{{ $sponsor_logo }}"
alt="{{ $sponsor_name }}"
class="company-logo"
/>
<div class="company-detail-wrapper">
<span class="item">{{ $sponsor_name }}</span>
<span class="item">{{ $sponsor_address }},</span>
<span class="item"
>{{ $sponsor_city }}, {{ $sponsor_zipcode }}</span
>
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
',
                        'preview' => 'storage/uploads/tk6BFDYik1dMumXaPnwyliEi1lwXZuQdJ7Tr5jrE.png',
                        'active' => 1,
                        'publish_at' => '2024-05-25',
                        'view' => 'templates/coupons/oW659tMThyhVwXR',
                        'language' => 'english',
                        'category_id' => NULL,
                        'sub_category_id' => NULL,
                        'created_at' => '2024-05-25 15:30:07',
                        'updated_at' => '2024-05-25 15:30:30',
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'uuid' => '52264e9e-6a05-4fd0-94f3-9579c244a927',
                        'type' => 'sponsor',
                        'title' => 'Commodi ea',
                        'styling' => '<style>
.main-wrapper {
max-width: 800px;
margin: 0 auto;
background-color: #cccccc;
border-radius: 5px;
padding: 10px;
min-height: 600px;
background-image: url("https://adlee.io/storage/uploads/GDRYFvumTjsX9Zh5iRdSyFtNt73IGL353r8Not0r.jpg");
background-repeat: no-repeat;
background-position: center;
background-size: cover;
}
.relative {
position: relative;
}
.person-name-wrapper {
position: absolute;
top: 160px;
right: 340px;
font-size: 20px;
font-weight: 600;
}
.company-name {
position: absolute;
top: 210px;
right: 340px;
font-size: 18px;
font-weight: 600;
}
.company-logo {
width: 100px;
height: 40px;
object-fit: contain;
position: absolute;
top: 280px;
right: 300px;
}
.honor-wrapper {
width: 250px;
position: absolute;
top: 400px;
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
</style>',
                        'content' => '
<section class="main-wrapper">
<div class="relative">
<div class="person-name-wrapper">
<span>{{ $person_name }}</span>
</div>

<h4 class="company-name">{{ $sponsor_name }}</h4>

<img
src="{{ $sponsor_logo }}"
alt="{{ $sponsor_name }}"
class="company-logo"
/>

<div class="honor-wrapper">
<h4 class="honor-name">{{ $commemoration }}</h4>
</div>

<div class="qr-code-wrapper">{!! $qr_code !!}</div>
</div>
</section>
',
                        'preview' => 'storage/uploads/j0Q5TogROIOAOxT4vhFS2oNkv2OFnRhKE0PTGa9F.png',
                        'active' => 1,
                        'publish_at' => '2024-05-27',
                        'view' => 'templates/sponsors/djON98iB5XrZAeH',
                        'language' => 'english',
                        'category_id' => 2,
                        'sub_category_id' => NULL,
                        'created_at' => '2024-05-28 11:46:47',
                        'updated_at' => '2024-05-28 12:58:53',
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'uuid' => '3c4b797b-00f6-405f-bad3-683f0d005bf0',
                        'type' => 'sponsor',
                        'title' => 'Non volup',
                        'styling' => '<style>
.main-wrapper {
max-width: 800px;
margin: 0 auto;
background-color: #cccccc;
border-radius: 5px;
padding: 10px;
min-height: 600px;
background-image: url("https://adlee.io/storage/uploads/GDRYFvumTjsX9Zh5iRdSyFtNt73IGL353r8Not0r.jpg");
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
</style>',
                        'content' => '
<section class="main-wrapper">
<div class="relative">
<div class="person-name-wrapper">
<span>{{ $person_name }}</span>
</div>

<h4 class="company-name">{{ $sponsor_name }}</h4>

<img
src="{{ $sponsor_logo }}"
alt="{{ $sponsor_name }}"
class="company-logo"
/>

<div class="honor-wrapper">
<h4 class="honor-name">{{ $commemoration }}</h4>
</div>

<div class="qr-code-wrapper">{!! $qr_code !!}</div>
</div>
</section>
',
                        'preview' => 'storage/uploads/dUEUmRm6b14aUgbQgVbjneXIZQEZaSaSq3bG3ago.png',
                        'active' => 1,
                        'publish_at' => '2024-05-28',
                        'view' => 'templates/sponsors/jc1K7bSGU7jEvO3',
                        'language' => 'english',
                        'category_id' => 2,
                        'sub_category_id' => NULL,
                        'created_at' => '2024-05-28 13:23:52',
                        'updated_at' => '2024-05-28 13:23:52',
                    ),
            )
        );


    }
}
