<?php

namespace App\Main;


class AdSpaceOwnerSidebarPanel
{
    public static function dashboards()
    {
        return [
            'title' => 'Dashboard',
            'items' => [
                [
                    'dashboard' => [
                        'title' => 'Home',
                        'route_name' => 'ad-space-owner.dashboard',
                    ],
                    'transactions' => [
                        'title' => 'Transactions',
                        'route_name' => 'ad-space-owner.transactions',
                    ],
                    // 'coupon_reports' => [
                    //     'title' => 'Coupon Management',
                    //     'route_name' => 'ad-space-owner.reports.coupons',
                    // ],
                ]
            ]
        ];
    }

    public static function basicSettings()
    {
        return [
            'title' => 'Onboarding Process',
            'items' => [
                [
                    'basic_settings' => [
                        'title' => 'Company Information',
                        'route_name' => 'ad-space-owner.basic-settings.index',
                    ],
                    'ein_verification' => [
                        'title' => 'EIN Verification',
                        'route_name' => 'ad-space-owner.basic-settings.ein.index',
                    ],
                    'stripe_onboarding' => [
                        'title' => 'Stripe Onboarding',
                        'route_name' => 'ad-space-owner.basic-settings.onboarding.index',
                    ],
                ],
            ]
        ];
    }

    public static function coupons()
    {
        return [
            'title' => 'Coupons',
            'items' => [
                [
                    'overview' => [
                        'title' => 'Coupons',
                        'route_name' => 'ad-space-owner.coupons.index',
                    ],
                    'coupon_reports' => [
                        'title' => 'Coupon Management',
                        'route_name' => 'ad-space-owner.reports.coupons',
                    ],
                ],

            ]
        ];
    }

    public static function all()
    {
        return [self::dashboards(), self::basicSettings()];
    }
}
