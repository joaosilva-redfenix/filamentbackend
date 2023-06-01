<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pro:user {UserEmail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'promotes user to admin and owner';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user_email = $this->argument('UserEmail');
        User::where('email', $user_email)
        ->update([
            'is_admin' => 1,
            'is_owner' => 1
        ]);
        $this->info("\n{$user_email} is now admin and owner!");
    }
}