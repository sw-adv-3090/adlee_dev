<?php

namespace App\Main;


class SidebarPanel
{
    public static function plans()
    {
        return [
            'title' => 'Plans',
            'items' => [
                [
                    'plans_overview' => [
                        'title' => 'Overview',
                        'route_name' => 'admin.plans.index',
                    ],
                ],
            ]
        ];
    }

    public static function templates()
    {
        return [
            'title' => 'Templates',
            'items' => [
                // [
                //     'templates_overview' => [
                //         'title' => 'Overview',
                //         'route_name' => 'admin.templates.index',
                //     ],
                //     'templates_sponsors' => [
                //         'title' => 'Sponsors',
                //         'route_name' => 'admin.templates.sponsors.index',
                //     ],
                //     'templates_coupons' => [
                //         'title' => 'Coupons',
                //         'route_name' => 'admin.templates.coupons.index',
                //     ],
                //     'templates_categories' => [
                //         'title' => 'Categories',
                //         'route_name' => 'admin.templates.categories.index',
                //     ],
                // ],
                [
                    'templates_overview' => [
                        'title' => 'Overview',
                        'route_name' => 'admin.templates.index',
                    ],
                ],
                [
                    'templates_sponsors' => [
                        'title' => 'Sponsors',
                        'route_name' => 'admin.templates.sponsors.index',
                    ],
                ],
                [
                    'templates_coupons' => [
                        'title' => 'Coupons',
                        'route_name' => 'admin.templates.coupons.index',
                    ],
                ],
                [
                    'templates_categories' => [
                        'title' => 'Categories',
                        'route_name' => 'admin.templates.categories.index',
                    ],
                ],
            ]
        ];
    }

    public static function jobs()
    {
        return [
            'title' => 'Jobs',
            'items' => [
                [
                    'overview' => [
                        'title' => 'Booklets Print Requests',
                        'route_name' => 'admin.jobs.booklet-prints',
                    ],
                ],

            ]
        ];
    }
    public static function settings()
    {
        return [
            'title' => 'Settings',
            'items' => [
                [
                    'print-emails' => [
                        'title' => 'Print Emails',
                        'route_name' => 'admin.settings.print-booklet-emails',
                    ],
                ],
                [
                    'shipment Carrier' => [
                        'title' => 'Shipment Carrier',
                        'route_name' => 'admin.settings.shipment.carrier',
                    ],
                ],
                [
                    'ship-from-address' => [
                        'title' => 'Ship From Address',
                        'route_name' => 'admin.settings.ship-from-address',
                    ],
                ],

            ]
        ];
    }

    public static function dashboards()
    {
        return [
            'title' => 'Dashboard',
            'items' => [
                [
                    'home' => [
                        'title' => 'Home',
                        'route_name' => 'admin.dashboard',
                    ],
                    'reports' => [
                        'title' => 'Reports',
                        'route_name' => 'admin.reports',
                    ],
                    'accounts_reports' => [
                        'title' => 'Account Report',
                        'route_name' => 'admin.reports.accounts',
                    ],
                    'coupon_reports' => [
                        'title' => 'Coupon Management',
                        'route_name' => 'admin.reports.coupons',
                    ],
                    'coupons' => [
                        'title' => 'Coupons',
                        'route_name' => 'admin.coupons.index',
                    ],
                ],
            ]
        ];
    }

    public static function users()
    {
        return [
            'title' => 'Customers',
            'items' => [
                [
                    'sponsors' => [
                        'title' => 'Sponsors',
                        'route_name' => 'admin.users.sponsors',
                    ],
                    'ad-space-owners' => [
                        'title' => 'Ad Space Owners',
                        'route_name' => 'admin.users.ad-space-owners',
                    ],
                ],
            ]
        ];
    }

    public static function all()
    {
        return [self::dashboards(), self::templates()];
    }
}
