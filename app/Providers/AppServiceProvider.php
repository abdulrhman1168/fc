<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         if ($this->app->environment('local')) {
           $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
         }

         Validator::extend('phone_number', function ($attribute, $value, $parameters, $validator) {
           return  preg_match('/^(05)([0-9]{8})$/', $value);
        });

        Validator::extend('national_id', function ($attribute, $value, $parameters, $validator) {
          // Check if value is not numeric or 10 digits long
          if (!is_numeric($value) || strlen($value) != 10) {
            return false;
          }

          // Check if starting digit is not either 1 or 2
          if (substr($value, 0, 1) != 1 && substr($value, 0, 1) != 2) {
            return false;
          }

          // Do check sum
          $sum = 0;
          $num = str_split($value);

          for ($i = 0; $i < 10; $i++) {
            if ($i % 2 == 0) {
              $s = $num[$i] * 2;
              $sum += $s % 10 + floor($s / 10);
            } else {
              $sum += $num[$i];
            }
          }
          return ($sum % 10 == 0);
       });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
