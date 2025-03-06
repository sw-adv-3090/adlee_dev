<?php
use App\Enums\TemplateLanguage;
use App\Models\BookletPrint;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Support\Facades\Http;

if (!function_exists('coupon_payouts_durations')) {
    function coupon_payouts_durations($single = false)
    {
        return [
            !$single ? 'Every Monday' : '7 Days' => 7,
            '15 Days' => 15,
            '30 Days' => 30,
            '60 Days' => 60,
            '90 Days' => 90,
        ];
    }
}

if (!function_exists('languages')) {
    function languages()
    {
        return TemplateLanguage::cases();
    }
}

if (!function_exists('category_name')) {
    function category_name($id)
    {
        return Category::find($id)?->name ?? 'No Name';
    }
}

if (!function_exists('templates_colors')) {
    function templates_colors()
    {
        return ['info', 'secondary', 'success', 'error', 'primary', 'warning'];
    }
}

if (!function_exists('random_color')) {
    function random_color()
    {
        return templates_colors()[(array_rand(templates_colors(), 1))];
    }
}

if (!function_exists('is_already_printed')) {
    function is_already_printed($id)
    {
        return BookletPrint::where('booklet_id', $id)->exists();
    }
}

if (!function_exists('coupon_return_url')) {
    function coupon_return_url($coupon)
    {
        return is_null($coupon->booklet_id) ? route('sponsors.coupons.index') : route('sponsors.booklets.show', $coupon->booklet_id);
    }
}

if (!function_exists('sign_task')) {
    function sign_task(Coupon $coupon)
    {
        // check if task is already signed then return
        if (!is_null($coupon->task->signed_at)) {
            return true;
        }

        $url = "https://api.boldsign.com/v1/document/properties?documentId=" . $coupon->task->document_id;

        $headers = [
            'Accept' => 'application/json',
            'X-API-Key' => config('services.boldsign.api_key')
        ];
        $response = Http::withHeaders($headers)->get($url)->json();

        if (!isset($response['status']) || $response['status'] !== "Completed") {
            // if document is decliend so clear the document id to re asign the task if needed
            if ($response['status'] === "Declined") {
                $coupon->task->update(['document_id' => null]);
            }

            return false;
        }

        $coupon->task->update(['signed_at' => now(), 'status' => 'signed']);

        return true;
    }
}

