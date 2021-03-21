<?php

namespace App\Console\Commands;

use App\Jobs\AutoScoreUpdate;
use Illuminate\Console\Command;

class UpdateScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scoring:updateScores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves JSON and searches for winners and losers to update DB';

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
        dispatch(new AutoScoreUpdate());
    }
}
