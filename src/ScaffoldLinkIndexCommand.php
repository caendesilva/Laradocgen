<?php

namespace Caendesilva\Docgen;

use Illuminate\Console\Command;

class ScaffoldLinkIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docgen:scaffold  {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the linkIndex.yml scaffolding based on the markdown files in the source directory';

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
        $this->info('Generating linkIndex scaffolding.');

        try {
            (GeneratesLinkIndexScaffold::generate((bool) $this->option('force')));
            
            $this->info('Done. Created file ' . resource_path() . '/docs/src/linkIndex.yml');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }

        return 0;
    }
}
