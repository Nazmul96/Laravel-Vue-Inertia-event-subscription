<?php

namespace App\Console;

use App\Jobs\SendEventEmailJob;
use App\Mail\EventMail;
use App\Models\EventRegistration;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            
            Log::info('Attempting to send email.');
//now()->addMinutes(10)->format('Y-m-d H:i:00')
            $event_register = EventRegistration::whereHas('event', function ($query) {
                $query->where('start_date','=','2023-12-24 00:35:00');
            })->with('event')->get();

            $event_register->each(function ($registration) {
                dispatch(new SendEventEmailJob($registration));
            });
            
            Log::info('Email sent successfully.');
            
       })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
