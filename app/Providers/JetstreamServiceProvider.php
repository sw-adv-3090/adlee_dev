<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Notifications\SendTwoFactorCode;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;

class JetstreamServiceProvider extends ServiceProvider
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
        $this->configurePermissions();

        // Fortify::authenticateUsing(function (Request $request) {
        //     $user = User::where('email', $request->email)->first();

        //     if (
        //         $user &&
        //         Hash::check($request->password, $user->password)
        //     ) {
        //         $user->generateTwoFactorCode();
        //         $user->notify(new SendTwoFactorCode());

        //         return $user;
        //     }
        // });

        Jetstream::deleteUsersUsing(DeleteUser::class);

        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
