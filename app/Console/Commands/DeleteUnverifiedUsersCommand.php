<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteUnverifiedUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete-unverified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all unverified users, after expired verify time.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoff = Carbon::now()->subDays(config('auth.account_verify_expire', 14));

        $users = User::whereNull('email_verified_at')
            ->where('created_at', '<', $cutoff)
            ->get();

        $count = $users->count();

        foreach ($users as $user) {
            $user->forceDelete();
        }

        $this->info("{$count} unverified users deleted.");
        Log::info("{$count} unverified users deleted.");
    }
}
