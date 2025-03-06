<?php
use App\Enums\UserRole;
use App\Models\AdSpaceOwner;
use App\Models\Setting;
use App\Models\Sponsor;
use Squire\Models\Country;
use Illuminate\Support\Number;

if (!function_exists('settings')) {
    function settings($key)
    {
        $settings = cache()->remember('settings', 3600, fn() => Setting::select(['key', 'value'])->get()->keyBy('key'));
        return isset($settings[$key]) ? $settings[$key]->value : null;
    }
}

if (!function_exists('role_name')) {
    function role_name($role_id = null)
    {
        if (is_null($role_id)) {
            $role_id = auth()->user()->role_id;
        }

        if ($role_id == UserRole::Admin->value) {
            return 'Admin';
        } elseif ($role_id == UserRole::Sponsor->value) {
            return 'Sponsor';
        } elseif ($role_id == UserRole::AdSpaceOwner->value) {
            return 'Ad Space Owner';
        } elseif ($role_id == UserRole::Designer->value) {
            return 'Designer';
        }
    }
}

if (!function_exists('route_name')) {
    function route_name($role_id = null)
    {
        if (is_null($role_id)) {
            $role_id = auth()->user()->role_id;
        }


        if ($role_id == UserRole::Admin->value) {
            return 'admin';
        } elseif ($role_id == UserRole::Sponsor->value) {
            return 'sponsors';
        } elseif ($role_id == UserRole::AdSpaceOwner->value) {
            return 'ad-space-owner';
        }
        elseif ($role_id == UserRole::Designer->value) {
            return 'designer';
        }
    }
}

if (!function_exists('name_alphabetic')) {
    function name_alphabetic($name)
    {
        return array_reduce(
            explode(' ', $name),
            function ($initials, $word) {
                return sprintf('%s%s', $initials, substr($word, 0, 1));
            },
            ''
        );
    }
}

if (!function_exists('code_number')) {
    function code_number()
    {
        $isUnique = false;
        $length = 3;
        $lastId = Sponsor::select(['id'])->latest()->first()?->id;

        if ($lastId) {
            $length = strlen((string) $lastId) > 2 ? strlen((string) $lastId) : $length;
        }

        $number = fake()->randomNumber($length, true);

        do {
            $isUnique = Sponsor::where('code', $number)->exists();
            $number = fake()->randomNumber($length, true);
        } while ($isUnique);

        return $number;
    }
}

if (!function_exists('next_number')) {
    function next_number($number, $digits = 4)
    {
        $number = (int) $number;
        $length = strlen((string) $number);
        $length = $length > $digits ? $length : $digits;
        $nextNumber = $number + 1;

        return str_pad($nextNumber, $length, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('sponsorId')) {
    function sponsorId($userId = null)
    {
        if (is_null($userId)) {
            $userId = auth()->id();
        }

        return Sponsor::select(['id'])->where('user_id', $userId)->first()?->id;
    }
}
if (!function_exists('adSpaceOwnerId')) {
    function adSpaceOwnerId($userId = null)
    {
        if (is_null($userId)) {
            $userId = auth()->id();
        }

        return AdSpaceOwner::select(['id'])->where('user_id', $userId)->first()?->id;
    }
}

if (!function_exists('countries')) {
    function countries()
    {
        return cache()->remember('countries', 3600, fn() => Country::select(['name', 'code_2'])->get());
    }
}

function getStateIsoCode($stateName)
{
    $states = [
        'Alabama' => 'AL',
        'Alaska' => 'AK',
        'Arizona' => 'AZ',
        'Arkansas' => 'AR',
        'California' => 'CA',
        'Colorado' => 'CO',
        'Connecticut' => 'CT',
        'Delaware' => 'DE',
        'Florida' => 'FL',
        'Georgia' => 'GA',
        'Hawaii' => 'HI',
        'Idaho' => 'ID',
        'Illinois' => 'IL',
        'Indiana' => 'IN',
        'Iowa' => 'IA',
        'Kansas' => 'KS',
        'Kentucky' => 'KY',
        'Louisiana' => 'LA',
        'Maine' => 'ME',
        'Maryland' => 'MD',
        'Massachusetts' => 'MA',
        'Michigan' => 'MI',
        'Minnesota' => 'MN',
        'Mississippi' => 'MS',
        'Missouri' => 'MO',
        'Montana' => 'MT',
        'Nebraska' => 'NE',
        'Nevada' => 'NV',
        'New Hampshire' => 'NH',
        'New Jersey' => 'NJ',
        'New Mexico' => 'NM',
        'New York' => 'NY',
        'North Carolina' => 'NC',
        'North Dakota' => 'ND',
        'Ohio' => 'OH',
        'Oklahoma' => 'OK',
        'Oregon' => 'OR',
        'Pennsylvania' => 'PA',
        'Rhode Island' => 'RI',
        'South Carolina' => 'SC',
        'South Dakota' => 'SD',
        'Tennessee' => 'TN',
        'Texas' => 'TX',
        'Utah' => 'UT',
        'Vermont' => 'VT',
        'Virginia' => 'VA',
        'Washington' => 'WA',
        'West Virginia' => 'WV',
        'Wisconsin' => 'WI',
        'Wyoming' => 'WY',
    ];

    return $states[$stateName] ?? $stateName;
}

if (!function_exists('number_abbreviate')) {
    function number_abbreviate($number)
    {
        return Number::abbreviate($number, precision: 2);
    }
}

if (!function_exists('page_number')) {
    function page_number($iteration, $collection)
    {
        return $iteration + $collection->firstItem() - 1;
    }
}
if (!function_exists('role_name')) {
    function role_name($iteration, $collection)
    {
        return $iteration + $collection->firstItem() - 1;
    }
}

if (!function_exists('country_name')) {
    function country_name($code)
    {
        $country = Country::where('code_2', $code)->first();
        return $country ? $country->name : $code;
    }
}

if (!function_exists('ach_enabled')) {
    function ach_enabled()
    {
        $support = false;
        $sponsor = Sponsor::select(['ach_support'])->where('user_id', auth()->id())->first();
        if ($sponsor && $sponsor->ach_support) {
            $support = true;
        }

        return $support;
    }
}

if (!function_exists('coupons_filters')) {
    function coupons_filters()
    {
        return [
            [
                'text' => 'Coupon Type',
                'value' => 'coupon_type',
                'type' => 'select',
                'options' => [
                    ['text' => 'Virtual', 'value' => 'virtual'],
                    ['text' => 'Physical', 'value' => 'physical'],
                    ['text' => 'Both', 'value' => 'both'],
                ]
            ],
            [
                'text' => 'Booklet Cost',
                'value' => 'booklet_cost',
                'type' => 'select',
                'options' => [
                    ['text' => 'Free', 'value' => 'free'],
                    ['text' => 'Paid', 'value' => 'paid'],
                    ['text' => 'Both', 'value' => 'both'],
                ]
            ],
            [
                'text' => 'Language',
                'value' => 'language',
                'type' => 'select',
                'options' => [
                    ['text' => 'English', 'value' => 'english'],
                    ['text' => 'Hebrew', 'value' => 'hebrew'],
                    ['text' => 'Both', 'value' => 'both'],
                ]
            ],
            [
                'text' => 'Booklet/Coupon Title',
                'value' => 'title',
                'type' => 'input',
            ],
            [
                'text' => 'Booklet/Coupon Number',
                'value' => 'number',
                'type' => 'input',
            ],
            [
                'text' => 'Booklet/Coupon Creation Date',
                'value' => 'created_at',
                'type' => 'date',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Booklet/Coupon Activate Date',
                'value' => 'activated_at',
                'type' => 'date',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Coupon Status',
                'value' => 'status',
                'type' => 'select',
                'options' => [
                    ['text' => 'Invited to Redeem', 'value' => 'invited_to_redeem'],
                    ['text' => 'Activated', 'value' => 'activated'],
                    ['text' => 'Redeemed', 'value' => 'redeemed'],
                    ['text' => 'Signed', 'value' => 'signed'],
                    ['text' => 'Partial Paid Out', 'value' => 'partial_paid_out'],
                    ['text' => 'Paid Out', 'value' => 'paid_out'],
                ]
            ],
            [
                'text' => 'Coupon Redeemed',
                'value' => 'redeemed',
                'type' => 'select',
                'options' => [
                    ['text' => 'Yes', 'value' => 'yes'],
                    ['text' => 'No', 'value' => 'no'],
                ]
            ],
            [
                'text' => 'Redeemed By',
                'value' => 'Redeemed_by',
                'type' => 'input',
            ],
            [
                'text' => 'Redeemed Date',
                'value' => 'redeemed',
                'type' => 'date',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'E-signed Date',
                'value' => 'signed_at',
                'type' => 'date',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Printed Date',
                'value' => 'printed_at',
                'type' => 'date',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Payment Applied',
                'value' => 'payment_applied',
                'type' => 'select',
                'options' => [
                    ['text' => 'Yes', 'value' => 'yes'],
                    ['text' => 'No', 'value' => 'no'],
                    ['text' => 'Both', 'value' => 'both'],
                ]
            ],
            [
                'text' => 'Original Amount',
                'value' => 'amount',
                'type' => 'input',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Paid Amount',
                'value' => 'paid_amount',
                'type' => 'input',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Payment Date (Scheduled Due Date)',
                'value' => 'payment_date',
                'type' => 'date',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Coupon Balance',
                'value' => 'coupon_balance',
                'type' => 'input',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Payout Completed Date',
                'value' => 'payout_completed_date',
                'type' => 'date',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Due By',
                'value' => 'due_by',
                'type' => 'select',
                'options' => [
                    ['text' => '7', 'value' => '7'],
                    ['text' => '14', 'value' => '14'],
                    ['text' => '30', 'value' => '30'],
                    ['text' => '60', 'value' => '60'],
                    ['text' => '90', 'value' => '90'],
                ]
            ],
            [
                'text' => 'Transaction Fee Payer',
                'value' => 'paying_commission',
                'type' => 'select',
                'options' => [
                    ['text' => 'Sponsor', 'value' => 'sponsor'],
                    ['text' => 'Ad Space Owner', 'value' => 'ad_space_owner'],
                    ['text' => 'Either', 'value' => 'either'],
                ]
            ],
            [
                'text' => 'Transaction Fee Percentage',
                'value' => 'transaction_fee_percentage',
                'type' => 'input',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Transaction Fee Cost',
                'value' => 'transaction_fee_cost',
                'type' => 'input',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Credit Card Percentage',
                'value' => 'credit_card_fee_percentage',
                'type' => 'input',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Credit Card Cost',
                'value' => 'credit_card_fee_cost',
                'type' => 'input',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'ACH Percentage',
                'value' => 'credit_card_fee_percentage',
                'type' => 'input',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'ACH Cost',
                'value' => 'credit_card_fee_cost',
                'type' => 'input',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],
            [
                'text' => 'Total Coupon Original Amount ',
                'value' => 'total_coupon_original_amount',
                'type' => 'input',
            ],
            [
                'text' => 'Total Paid Amount',
                'value' => 'total_paid_amount',
                'type' => 'input',
            ],
            [
                'text' => 'Total Balance',
                'value' => 'total_balance',
                'type' => 'input',
            ],
        ];
    }
}

if (!function_exists('accounts_filters')) {
    function accounts_filters()
    {
        return [
            [
                'text' => 'Search Operators',
                'value' => 'created_at',
                'type' => 'date',
                'options' => [
                    ['text' => 'Equal', 'value' => 'equal'],
                    ['text' => 'Before', 'value' => 'before'],
                    ['text' => 'After', 'value' => 'after'],
                    ['text' => 'Between', 'value' => 'between'],
                ]
            ],

        ];
    }
}

if (!function_exists('coupon_report_columns')) {
    function coupon_report_columns()
    {
        return [
            [
                'key' => 'sponsor',
                'name' => 'Sponsor',
            ],
            [
                'key' => 'type',
                'name' => 'Type',
            ],
            [
                'key' => 'language',
                'name' => 'Language',
            ],
            [
                'key' => 'title',
                'name' => 'Title',
            ],
            [
                'key' => 'booklet_number',
                'name' => 'Booklet Number',
            ],
            [
                'key' => 'coupon_number',
                'name' => 'Coupon Number',
            ],
            [
                'key' => 'original_amount',
                'name' => 'Original Amount',
            ],
            [
                'key' => 'paid_amount',
                'name' => 'Paid Amount',
            ],
            [
                'key' => 'coupon_balance',
                'name' => 'Coupon Balance',
            ],
            [
                'key' => 'status',
                'name' => 'Status',
            ],
            [
                'key' => 'coupon_created_at',
                'name' => 'Coupon Creation Date',
            ],
            [
                'key' => 'coupon_activated_at',
                'name' => 'Activated Coupon Date',
            ],
            [
                'key' => 'coupon_redeemed',
                'name' => 'Coupon Redeemed',
            ],
            [
                'key' => 'coupon_redeemed_by',
                'name' => 'Redeemed By',
            ],
            [
                'key' => 'coupon_redeemed_at',
                'name' => 'Redeemed Date',
            ],
            [
                'key' => 'coupon_signed_at',
                'name' => 'E-signed Date',
            ],
            [
                'key' => 'coupon_printed_at',
                'name' => 'Printed Date',
            ],
            [
                'key' => 'coupon_booklet_cost',
                'name' => 'Coupon Booklet Cost',
            ],
            [
                'key' => 'payment_applied',
                'name' => 'Payment Applied',
            ],
            [
                'key' => 'coupon_payout_on',
                'name' => 'Scheduled Due Date',
            ],
            [
                'key' => 'coupon_payout_at',
                'name' => 'Payout Completed Date',
            ],
            [
                'key' => 'coupon_due_by',
                'name' => 'Due By',
            ],
            [
                'key' => 'transaction_method',
                'name' => 'Transaction Method',
            ],
            [
                'key' => 'transaction_fee_payer',
                'name' => 'Transaction Fee Payer',
            ],
            [
                'key' => 'transaction_fee',
                'name' => 'Transaction Fee',
            ],
            [
                'key' => 'transaction_fee_cost',
                'name' => 'Transaction Fee Cost',
            ],
            [
                'key' => 'credit_card_fee',
                'name' => 'Credit Card Fee',
            ],
            [
                'key' => 'credit_card_fee_cost',
                'name' => 'Credit Card Fee Cost',
            ],
            [
                'key' => 'ach_fee',
                'name' => 'ACH Fee',
            ],
            [
                'key' => 'ach_fee_cost',
                'name' => 'ACH Fee Cost',
            ],
            [
                'key' => 'total_coupon_amount',
                'name' => 'Total Coupon Amount',
            ],
            [
                'key' => 'total_paid_amount',
                'name' => 'Total Paid Amount',
            ],
            [
                'key' => 'total_balance',
                'name' => 'Total Balance',
            ],
        ];
    }
}

if (!function_exists('sponsors_coupon_report_columns')) {
    function sponsors_coupon_report_columns()
    {
        return [
            [
                'key' => 'type',
                'name' => 'Type',
            ],
            [
                'key' => 'language',
                'name' => 'Language',
            ],
            [
                'key' => 'title',
                'name' => 'Title',
            ],
            [
                'key' => 'booklet_number',
                'name' => 'Booklet Number',
            ],
            [
                'key' => 'coupon_number',
                'name' => 'Coupon Number',
            ],
            [
                'key' => 'original_amount',
                'name' => 'Original Amount',
            ],
            [
                'key' => 'paid_amount',
                'name' => 'Paid Amount',
            ],
            [
                'key' => 'coupon_balance',
                'name' => 'Coupon Balance',
            ],
            [
                'key' => 'status',
                'name' => 'Status',
            ],
            [
                'key' => 'coupon_created_at',
                'name' => 'Coupon Creation Date',
            ],
            [
                'key' => 'coupon_activated_at',
                'name' => 'Activated Coupon Date',
            ],
            [
                'key' => 'coupon_redeemed',
                'name' => 'Coupon Redeemed',
            ],
            [
                'key' => 'coupon_redeemed_at',
                'name' => 'Redeemed Date',
            ],
            [
                'key' => 'coupon_signed_at',
                'name' => 'E-signed Date',
            ],
            [
                'key' => 'coupon_printed_at',
                'name' => 'Printed Date',
            ],
            [
                'key' => 'coupon_booklet_cost',
                'name' => 'Coupon Booklet Cost',
            ],
            [
                'key' => 'payment_applied',
                'name' => 'Payment Applied',
            ],
            [
                'key' => 'coupon_payout_on',
                'name' => 'Scheduled Due Date',
            ],
            [
                'key' => 'coupon_payout_at',
                'name' => 'Payout Completed Date',
            ],
            [
                'key' => 'coupon_due_by',
                'name' => 'Due By',
            ],
            [
                'key' => 'transaction_method',
                'name' => 'Transaction Method',
            ],
            [
                'key' => 'transaction_fee_payer',
                'name' => 'Transaction Fee Payer',
            ],
            [
                'key' => 'transaction_fee',
                'name' => 'Transaction Fee',
            ],
            [
                'key' => 'transaction_fee_cost',
                'name' => 'Transaction Fee Cost',
            ],
            [
                'key' => 'credit_card_fee',
                'name' => 'Credit Card Fee',
            ],
            [
                'key' => 'credit_card_fee_cost',
                'name' => 'Credit Card Fee Cost',
            ],
            [
                'key' => 'ach_fee',
                'name' => 'ACH Fee',
            ],
            [
                'key' => 'ach_fee_cost',
                'name' => 'ACH Fee Cost',
            ],
        ];
    }
}

if (!function_exists('bbo_coupon_report_columns')) {
    function bbo_coupon_report_columns()
    {
        return [
            [
                'key' => 'type',
                'name' => 'Type',
            ],
            [
                'key' => 'language',
                'name' => 'Language',
            ],
            [
                'key' => 'title',
                'name' => 'Title',
            ],
            // [
            //     'key' => 'booklet_number',
            //     'name' => 'Booklet Number',
            // ],
            [
                'key' => 'coupon_number',
                'name' => 'Coupon Number',
            ],
            [
                'key' => 'original_amount',
                'name' => 'Original Amount',
            ],
            [
                'key' => 'paid_amount',
                'name' => 'Paid Amount',
            ],
            [
                'key' => 'coupon_balance',
                'name' => 'Coupon Balance',
            ],
            // [
            //     'key' => 'status',
            //     'name' => 'Status',
            // ],
            // [
            //     'key' => 'coupon_created_at',
            //     'name' => 'Coupon Creation Date',
            // ],
            // [
            //     'key' => 'coupon_activated_at',
            //     'name' => 'Activated Coupon Date',
            // ],
            // [
            //     'key' => 'coupon_redeemed',
            //     'name' => 'Coupon Redeemed',
            // ],
            [
                'key' => 'coupon_redeemed_at',
                'name' => 'Redeemed Date',
            ],
            [
                'key' => 'coupon_signed_at',
                'name' => 'E-signed Date',
            ],
            [
                'key' => 'coupon_printed_at',
                'name' => 'Printed Date',
            ],
            // [
            //     'key' => 'coupon_booklet_cost',
            //     'name' => 'Coupon Booklet Cost',
            // ],
            // [
            //     'key' => 'payment_applied',
            //     'name' => 'Payment Applied',
            // ],
            // [
            //     'key' => 'coupon_payout_on',
            //     'name' => 'Scheduled Due Date',
            // ],
            [
                'key' => 'coupon_payout_at',
                'name' => 'Payout Completed Date',
            ],
            [
                'key' => 'coupon_due_by',
                'name' => 'Due By',
            ],
            // [
            //     'key' => 'transaction_method',
            //     'name' => 'Transaction Method',
            // ],
            [
                'key' => 'transaction_fee_payer',
                'name' => 'Transaction Fee Payer',
            ],
            [
                'key' => 'transaction_fee',
                'name' => 'Transaction Fee',
            ],
            [
                'key' => 'transaction_fee_cost',
                'name' => 'Transaction Fee Cost',
            ],
            // [
            //     'key' => 'credit_card_fee',
            //     'name' => 'Credit Card Fee',
            // ],
            // [
            //     'key' => 'credit_card_fee_cost',
            //     'name' => 'Credit Card Fee Cost',
            // ],
            // [
            //     'key' => 'ach_fee',
            //     'name' => 'ACH Fee',
            // ],
            // [
            //     'key' => 'ach_fee_cost',
            //     'name' => 'ACH Fee Cost',
            // ],
        ];
    }
}

if (!function_exists('packet_not_picked_status')) {
    function packet_not_picked_status()
    {
        return ["Not Yet In System", "in_transit", "In Transit", "IT", "NY"];
    }
}
if (!function_exists('packet_delivered_status')) {
    function packet_delivered_status()
    {
        return ["Delivered", "delivered", "DE"];

    }
}
if (!function_exists('tracking_status')) {
    function tracking_status($code)
    {
        $tracking_status = [
            'AC' => 'accepted',
            'IT' => 'in_transit',
            'DE' => 'delivered',
            'EX' => 'error',
            'UN' => 'unknown',
            'AT' => 'delivery_attempt',
            'NY' => 'in_transit',
            'SP' => 'delivered_to_service_point',
        ];

        return $tracking_status[$code];
    }
}
