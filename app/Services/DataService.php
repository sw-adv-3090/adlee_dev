<?php

namespace App\Services;

use App\Models\Coupon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Class DataService.
 */
class DataService
{

    public function template(Coupon $coupon, $commemoration, $type = "preview")
    {
        // <img src="data:image/png;base64,{{ $qr_code }}">
        $sponsor = $coupon->sponsor;
        $user = $coupon->user;
        $qr_code = QrCode::format('svg')->size(65)->generate("https://adlee.io");
        return [
            'adlee_logo' => "https://adlee.io/demo/adlee-logo.png",
            'person_title' => '',
            'person_name' => $user->name,
            'sponsor_logo' => asset($sponsor->company_logo),
            'sponsor_name' => $sponsor->company_name,
            'commemoration' => $commemoration,
            'qr_code' => $type === "preview" ? $qr_code : '<img src="data:image/png;base64,' . base64_encode($qr_code) . '">',
        ];
    }

    public function coupon(Coupon $coupon, $type = "preview")
    {
        $template = $coupon->template;
        $sponsor = $coupon->sponsor;

        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $sponsor_qr_code = QrCode::size(80)->style('round')->generate($coupon->shorten_url_activate);
        $bbo_qr_code = QrCode::size(50)->style('round')->generate($coupon->shorten_url_redeem);
        return [
            'adlee_logo' => "https://adlee.io/demo/adlee-logo.png",
            'book_number' => '',
            'coupon_number' => $coupon->number,
            'sponsor_logo' => asset($sponsor->company_logo),
            'sponsor_name' => $sponsor->company_name,
            'sponsor_address' => $sponsor->address,
            'sponsor_city' => $sponsor->city,
            'sponsor_zipcode' => $sponsor->postal_code,
            'amount_in_words' => ucwords(str_replace('-', " ", $f->format($coupon->amount)) . ' dollars'),
            'amount_in_digits' => $coupon->amount,
            'sponsor_qr_code' => $type === "preview" ? $sponsor_qr_code : '<img src="data:image/png;base64,' . base64_encode($sponsor_qr_code) . '">',
            'bbo_qr_code' => $type === "preview" ? $bbo_qr_code : '<img src="data:image/png;base64,' . base64_encode($bbo_qr_code) . '">',
            'shorten_url' => str_replace(config('services.replace_url'), '', $coupon->shorten_url_redeem),
        ];
    }
}
