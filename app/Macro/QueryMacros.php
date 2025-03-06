<?php

namespace App\Macro;

use Carbon\Carbon;

class QueryMacros
{
    // todays results
    public function today()
    {
        return function ($column = 'datetime') {
            return $this->whereDate($column, date("Y-m-d", strtotime("today")));
        };
    }

    // yesterday results
    public function yesterday()
    {
        return function ($column = 'datetime') {
            return $this->whereDate($column, date("Y-m-d", strtotime("yesterday")));
        };
    }

    // week results
    public function week()
    {
        return function ($column = 'created_at') {
            return $this->whereBetween(
                $column,
                [Carbon::now()->subDays(7), Carbon::now()]
            );
        };
    }

    // month results
    // public function month()
    // {
    //     return function ($column = 'created_at') {
    //         return $this->whereBetween(
    //             $column,
    //             [Carbon::now()->subDays(30), Carbon::now()]
    //         );
    //     };
    // }
    public function month()
    {
        return function ($column = 'created_at') {
            return $this->whereBetween(
                $column,
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            );
        };
    }

    // querter results
    public function querter()
    {
        return function ($column = 'created_at') {
            return $this->whereBetween(
                $column,
                [Carbon::now()->subMonths(4), Carbon::now()]
            );
        };
    }

    // halfYear results
    public function halfYear()
    {
        return function ($column = 'created_at') {
            return $this->whereBetween(
                $column,
                [Carbon::now()->subMonths(6), Carbon::now()]
            );
        };
    }

    // year results
    public function year()
    {
        return function ($column = 'created_at') {
            return $this->whereBetween(
                $column,
                [Carbon::now()->subMonths(12), Carbon::now()]
            );
        };
    }
}
