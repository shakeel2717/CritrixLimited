<?php

use App\Jobs\RemoveFakeTransactionJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new RemoveFakeTransactionJob)->everyTenMinutes();
Schedule::command('send:daily-profit')->twiceDaily();
Schedule::command('fake:transactions')->everyMinute()->when(fn() => rand(1, 5) === 1)->runInBackground();
Schedule::command('fake:transactions')->everyFiveMinutes()->when(fn() => rand(1, 4) === 1)->runInBackground();
Schedule::command('fake:transactions')->everyTenMinutes()->when(fn() => rand(1, 3) === 1)->runInBackground();
Schedule::command('deliver:networking-commission')->runInBackground()->everyMinute();