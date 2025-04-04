<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Random\RandomException;

class GenerateApiKeyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and store a new API key in the .env file.';

    /**
     * Execute the console command.
     * @throws RandomException
     */
    public function handle()
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            $this->error('.env file not found!');
            return 1;
        }

        $env = file_get_contents($envPath);
        $keyName = 'API_KEY';
        $newValue = bin2hex(random_bytes(32));
        $keyPattern = "/^{$keyName}=.*/m";

        if (preg_match($keyPattern, $env)) {
            $this->warn("{$keyName} already exists.");

            if (!$this->confirm('Do you want to replace it?')) {
                $this->info('No changes were made.');
                return 0;
            }

            $env = preg_replace($keyPattern, "{$keyName}={$newValue}", $env);
            $this->info("{$keyName} has been updated.");
        } else {
            $env .= "\n{$keyName}={$newValue}";
            $this->info("{$keyName} has been added.");
        }

        file_put_contents($envPath, $env);

        return 0;
    }
}
