<?php

namespace DeSilva\Laradocgen;

use Illuminate\Console\Command;
use Throwable;

/**
 * Artisan Command to trigger Static Site Build
 */
class BuildCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradocgen:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile the Markdown Documentation to HTML';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int exit code
     */
    public function handle(): int
    {
        $this->info("Starting build process.");

        $this->line('Source directory is ' . Laradocgen::getSourcePath());
        $this->line('Output directory is ' . Laradocgen::getBuildPath());
        $this->line('Server host is ' . config('laradocgen.serverHost', 'http://localhost:8000'));

        $this->line("Validating source files");
        try {
            Laradocgen::validateSourceFiles();
        } catch (Throwable $th) {
            $this->error("Error: " . $th->getMessage());
            return 1;
        }

        Laradocgen::build();
        return 0;
    }
}
