<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use AshAllenDesign\ShortURL\Facades\ShortURL;

/**
 * Class TestDataService.
 */
class TestDataService
{
    public function template()
    {
        $sponsor = auth()->user()->sponsor;

        $faker = fake();

        if ($sponsor) {
            $title = $faker->title();
            $personName = $faker->firstName() . ' ' . $faker->lastName();
            $sponsorLogo = asset($sponsor->company_logo);
            $comapnyName = $sponsor->company_name;
            $commemoration = $faker->name();
            $sponsorAddress = $sponsor->address;
            $sponsorCity = $sponsor->city;
            $sponsorPostalCode = $sponsor->postal_code;
        } else {
            $title = $faker->title();
            $personName = $faker->firstName() . ' ' . $faker->lastName();
            $sponsorLogo = "https://adlee.io/demo/company-logo-3.png";
            $comapnyName = $faker->company();
            $commemoration = $faker->name();
            $sponsorAddress = $faker->words(3, true);
            $sponsorCity = $faker->city();
            $sponsorPostalCode = $faker->randomNumber(5);
        }

        $amount = $faker->randomNumber(3, true);

        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);

        $shortUrl = ShortURL::destinationUrl($faker->url())->make()->default_short_url;

        return [
            'adlee_logo' => "https://adlee.io/demo/adlee-logo.png",
            'person_title' => $title,
            'person_name' => $personName,
            'sponsor_logo' => $sponsorLogo,
            'sponsor_name' => $comapnyName,
            'commemoration' => $commemoration,
            // 'qr_code' => base64_encode(QrCode::size(70)->style('round')->generate($faker->url())),
            'qr_code' => QrCode::size(70)->style('round')->generate($faker->url()),
            'book_number' => $faker->randomNumber(3),
            'coupon_number' => $faker->randomNumber(6, true),
            'sponsor_address' => $sponsorAddress,
            'sponsor_city' => $sponsorCity,
            'sponsor_zipcode' => $sponsorPostalCode,
            'amount_in_words' => ucwords(str_replace('-', " ", $f->format($amount)) . ' dollars'),
            'amount_in_digits' => $amount,
            // 'sponsor_qr_code' => base64_encode(QrCode::size(80)->style('round')->generate($faker->url())),
            'sponsor_qr_code' => QrCode::size(80)->style('round')->generate($faker->url()),
            // 'bbo_qr_code' => base64_encode(QrCode::size(50)->style('round')->generate($faker->url())),
            'bbo_qr_code' => QrCode::size(50)->style('round')->generate($faker->url()),
            'shorten_url' => str_replace(config('services.replace_url'), '', $shortUrl),
        ];
    }
}
