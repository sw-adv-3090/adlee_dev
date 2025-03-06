<?php

namespace App\Main;


class SponsorSidebarPanel
{
    public static function dashboards()
    {
        return [
            'title' => 'Dashboard',
            'items' => [
                [
                    'dashboard' => [
                        'title' => 'Home',
                        'route_name' => 'sponsors.dashboard',
                    ],
                    'transactions' => [
                        'title' => 'Transactions',
                        'route_name' => 'sponsors.transactions',
                    ],
                    // 'coupon_reports' => [
                    //     'title' => 'Coupon Management',
                    //     'route_name' => 'sponsors.reports.coupons',
                    // ],
                ]
            ]
        ];
    }

    public static function banks()
    {
        return [
            'title' => 'Bank Accounts',
            'items' => [
                [
                    'index' => [
                        'title' => 'Home',
                        'route_name' => 'sponsors.banks.index',
                    ],
                    'create' => [
                        'title' => 'Add New Account',
                        'route_name' => 'sponsors.banks.create',
                    ],
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
                    'plans' => [
                        'title' => 'Subscription Plan',
                        'route_name' => 'sponsors.plans.index',
                    ],
                    'basic_settings' => [
                        'title' => 'Basic Setttings',
                        'route_name' => 'sponsors.basic-settings',
                    ],
                    'basic_settings_address' => [
                        'title' => 'Shipping Address',
                        'route_name' => 'sponsors.basic-settings.address',
                    ],
                    'basic_settings_templates' => [
                        'title' => 'Select Templates',
                        'route_name' => 'sponsors.basic-settings.templates',
                    ],
                ],
            ]
        ];
    }

    public static function coupons()
    {
        return [
            'title' => 'Virtual Coupons & Booklets',
            'items' => [
                // [
                //     'overview' => [
                //         'title' => 'Overview',
                //         'route_name' => 'sponsors.coupons.index',
                //     ],
                // ],
                // [
                //     'create' => [
                //         'title' => 'Create new Coupon',
                //         'route_name' => 'sponsors.coupons.create',
                //     ],
                // ],
                [
                    'overview' => [
                        'title' => 'Virtual Coupons',
                        'route_name' => 'sponsors.coupons.index',
                    ],
                    'create' => [
                        'title' => 'Create new Virtual Coupon',
                        'route_name' => 'sponsors.coupons.create',
                    ],
                ],
                [
                    'overview' => [
                        'title' => 'Booklets',
                        'route_name' => 'sponsors.booklets.index',
                    ],
                    'create' => [
                        'title' => 'Create new Booklet',
                        'route_name' => 'sponsors.booklets.create',
                    ],
                    // 'jobs' => [
                    //     'title' => 'Active Print Jobs',
                    //     'route_name' => 'sponsors.booklets.active-jobs',
                    // ],
                ],
                [
                    'coupon_reports' => [
                        'title' => 'Coupon Management',
                        'route_name' => 'sponsors.reports.coupons',
                    ],
                    
                ],

            ]
        ];
    }

    public static function jobs()
    {
        return [
            'title' => 'Print Jobs',
            'items' => [
                [
                    'jobs' => [
                        'title' => 'Active Print Jobs',
                        'route_name' => 'sponsors.active-jobs',
                    ],
                ]
            ]
        ];
    }
    public static function all()
    {
        return [self::dashboards(), self::basicSettings()];
    }
}
