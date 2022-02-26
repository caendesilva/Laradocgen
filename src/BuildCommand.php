<?php

namespace DeSilva\Laradocgen;

use Illuminate\Console\Command;

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
    protected $description = 'Compile all the files to HTML';

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
     * @return int
     */
    public function handle()
    {
        Laradocgen::build();
    }
}
