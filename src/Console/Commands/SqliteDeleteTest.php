<?php

namespace BrandonBest\Console\Commands;

use BrandonBest\UnittestSqlite\Traits\SetupDatabase;
use Illuminate\Console\Command;

class SqliteDeleteTest extends Command
{
    use SetupDatabase;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sqlite:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the test sqlite file.';

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
     * @return mixed
     */
    public function handle()
    {
        $basepath = $this->baseSqlite();

        if (!file_exists($basepath)) {
            $this->warn('Base Sqlite does not exist.');
            return;
        }

        unlink($basepath);

        $this->info('File successfully deleted: ' . $basepath);
    }
}
