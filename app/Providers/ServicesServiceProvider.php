<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\User\UserServiceInterface;
use App\Services\Transaction\UserService;
use App\Services\Transaction\TransactionServiceInterface;
use App\Services\Transaction\TransactionService;


class ServicesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            TransactionServiceInterface::class,
            TransactionService::class
        );

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );
    }

    public function boot()
    {
        //
    }
}
