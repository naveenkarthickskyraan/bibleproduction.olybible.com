<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class testCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testCron:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every five minutes delete user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::all();
        foreach($user as $all)
        {
            Mail::raw('This is Auto Genrated Mail', function ($message) {
                $message->from('sekarguna534@gmail.com', 'Gunasekar M');
                $message->to($all->email)->subject("Test Cron Jobs");
            });
        }
        $this->info('Email Has been send Successfully');
        $this->info('Cron Job Started');
    }
}
