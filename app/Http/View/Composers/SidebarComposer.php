<?php

namespace App\Http\View\Composers;

use App\Main\AdSpaceOwnerSidebarPanel;
use App\Main\SidebarPanel;
use App\Main\SponsorSidebarPanel;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        if (!is_null(request()->route())) {
            $pageName = request()->route()->getName();
            $role = explode('.', $pageName)[0] ?? '';
            $routePrefix = explode('.', $pageName)[1] ?? '';

            if ($role === 'admin') {
                switch ($routePrefix) {
                    case 'dashboard':
                        $view->with('sidebarMenu', SidebarPanel::dashboards());
                        break;
                    case 'templates':
                        $view->with('sidebarMenu', SidebarPanel::templates());
                        break;
                    case 'plans':
                        $view->with('sidebarMenu', SidebarPanel::plans());
                        break;
                    case 'jobs':
                        $view->with('sidebarMenu', SidebarPanel::jobs());
                        break;
                    case 'users':
                        $view->with('sidebarMenu', SidebarPanel::users());
                        break;
                    case 'settings':
                        $view->with('sidebarMenu', SidebarPanel::settings());
                        break;
                    default:
                        $view->with('sidebarMenu', SidebarPanel::dashboards());
                }
            } elseif ($role === 'sponsors') {
                switch ($routePrefix) {
                    case 'dashboard':
                        $view->with('sidebarMenu', SponsorSidebarPanel::dashboards());
                        break;
                    case 'coupons':
                        $view->with('sidebarMenu', SponsorSidebarPanel::coupons());
                        break;
                    case 'reports':
                            $view->with('sidebarMenu', SponsorSidebarPanel::coupons());
                    break;
                    case 'booklets':
                        $view->with('sidebarMenu', SponsorSidebarPanel::coupons());
                        break;
                    case 'basic-settings':
                        $view->with('sidebarMenu', SponsorSidebarPanel::basicSettings());
                        break;
                    case 'plans':
                        $view->with('sidebarMenu', SponsorSidebarPanel::basicSettings());
                        break;
                    case 'active-jobs':
                        $view->with('sidebarMenu', SponsorSidebarPanel::jobs());
                        break;
                    case 'banks':
                        $view->with('sidebarMenu', SponsorSidebarPanel::banks());
                        break;
                    default:
                        $view->with('sidebarMenu', SponsorSidebarPanel::dashboards());
                }
            } else if ($role === 'ad-space-owner') {
                switch ($routePrefix) {
                    case 'dashboard':
                        $view->with('sidebarMenu', AdSpaceOwnerSidebarPanel::dashboards());
                        break;
                    case 'basic-settings':
                        $view->with('sidebarMenu', AdSpaceOwnerSidebarPanel::basicSettings());
                        break;
                    case 'coupons':
                        $view->with('sidebarMenu', AdSpaceOwnerSidebarPanel::coupons());
                        break;
                    case 'reports':
                            $view->with('sidebarMenu', AdSpaceOwnerSidebarPanel::coupons());
                            break;
                    default:
                        $view->with('sidebarMenu', AdSpaceOwnerSidebarPanel::dashboards());
                }

            } else {
                $view->with('sidebarMenu', SponsorSidebarPanel::dashboards());
            }


            $view->with('allSidebarItems', SidebarPanel::all());
            $view->with('pageName', $pageName);
            $view->with('routePrefix', $routePrefix);
        }
    }
}
