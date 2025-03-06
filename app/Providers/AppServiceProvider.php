<?php

namespace App\Providers;

use App\Macro\QueryMacros;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Carbon;
use Cmixin\BusinessDay;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });

        BusinessDay::enable(Carbon::class);
        Carbon::setHolidaysRegion('us-national');

        Builder::mixin(new QueryMacros);

        // Cashier::calculateTaxes();
    }
}
