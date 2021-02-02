<?php

namespace App\Common\Commands;

use Illuminate\Console\Command;

class DatabaseConnectionCommand extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MSSQL database connection';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:connect';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        config(['database.default' => 'sqlsrv']);
        dd(\DB::select("SELECT * FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_NAME LIKE '%'"));
    }
}
