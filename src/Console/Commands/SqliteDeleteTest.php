<?php

namespace BrandonBest\Console\Commands;

use BrandonBest\UnittestSqlite\Services\SetupDatabase;
use Illuminate\Console\Command;

class SqliteDeleteTest extends Command
{
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

    public $outputDoesNotExist = 'Base Sqlite does not exist.';

    public $outputSuccessfulPrefix = 'File successfully deleted: ';

    /**
     * @var SetupDatabase
     */
    protected $setupDatabase;

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
    public function handle(SetupDatabase $setupDatabase)
    {
        $this->setupDatabase = $setupDatabase;
        $basepath = $this->setupDatabase->baseSqlite();

        if (!file_exists($basepath)) {
            $this->outputFileDoesNotExist();
            return;
        }

        unlink($basepath);

        $this->outputSuccessful($basepath);
    }

    public function outputFileDoesNotExist()
    {
        $this->warn($this->outputDoesNotExist);
    }

    /**
     * @param string $basepath
     */
    public function outputSuccessful(string $basepath)
    {
        $this->info($this->outputSuccessfulPrefix . $basepath);
    }
}
