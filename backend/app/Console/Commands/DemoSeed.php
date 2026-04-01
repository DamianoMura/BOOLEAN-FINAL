<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class DemoSeed extends Command
{
    protected $signature = 'demo:seed';
    protected $description = 'Prepare the base SQLite database for demo mode';

    public function handle(): int
    {
        $basePath = database_path('base.sqlite');
        $sessionsDir = database_path('sessions');

        // Remove old base if exists
        if (file_exists($basePath)) {
            unlink($basePath);
            $this->info('Removed old base.sqlite');
        }

        // Create fresh file
        touch($basePath);

        // Point the sqlite connection to base.sqlite
        Config::set('database.default', 'sqlite');
        Config::set('database.connections.sqlite.database', $basePath);
        app('db')->purge('sqlite');

        $this->info('Running migrations on base.sqlite...');
        Artisan::call('migrate:fresh', [
            '--database' => 'sqlite',
            '--force' => true,
        ]);
        $this->info(Artisan::output());

        $this->info('Seeding demo data...');
        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\DemoSeeder',
            '--database' => 'sqlite',
            '--force' => true,
        ]);
        $this->info(Artisan::output());

        // Clean up old session databases
        if (is_dir($sessionsDir)) {
            $files = glob($sessionsDir . '/demo_*.sqlite');
            foreach ($files as $file) {
                unlink($file);
            }
            $this->info('Cleaned up ' . count($files) . ' old session databases.');
        }

        $this->info('Base demo database created at: ' . $basePath);
        return Command::SUCCESS;
    }
}
