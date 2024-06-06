<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanUpTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-up-temp-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old temporary files';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $files = Storage::disk('local')->allFiles('temp');
        $now = now();

        foreach ($files as $file) {
            // Assuming files are named with a timestamp or we can use the last modified time
            if ($now->diffInMinutes(Storage::lastModified($file)) > 60) {
                Storage::delete($file);
            }
        }

        $this->info('Old temporary files cleaned up.');
    }
}
