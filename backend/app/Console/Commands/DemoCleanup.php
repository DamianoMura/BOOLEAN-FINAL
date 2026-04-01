<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoCleanup extends Command
{
    protected $signature = 'demo:cleanup {--max-age=120 : Max age in minutes before a session DB is deleted}';
    protected $description = 'Clean up old demo session databases';

    public function handle(): int
    {
        $sessionsDir = database_path('sessions');

        if (!is_dir($sessionsDir)) {
            $this->info('No sessions directory found.');
            return Command::SUCCESS;
        }

        $maxAge = (int) $this->option('max-age');
        $cutoff = time() - ($maxAge * 60);
        $deleted = 0;

        $files = glob($sessionsDir . '/demo_*.sqlite');
        foreach ($files as $file) {
            if (filemtime($file) < $cutoff) {
                unlink($file);
                $deleted++;
            }
        }

        $this->info("Cleaned up {$deleted} expired session databases.");
        return Command::SUCCESS;
    }
}
