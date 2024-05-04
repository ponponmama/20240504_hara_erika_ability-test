<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Hash;




class FortifyServiceProvider extends ServiceProvider
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

        Fortify::viewPrefix('');

        Fortify::createUsersUsing(CreateNewUser::class);


        Fortify::registerView(function () {
            return view('register');
        });

        Fortify::loginView(function () {

            return view('login');
        });


        Fortify::authenticateUsing(function (Request $request) {

            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });

        RateLimiter::for('login', function (Request $request) {

            $email = (string) $request->email;

         return Limit::perMinute(10)->by($email .   $request->ip());
         });

        Validator::extend('starts_with_john', function ($attribute, $value, $parameters, $validator) {
        return strpos($value, 'John') === 0;
    });
    }
}