<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HomeworkTableClassA;
use App\Models\HomeworkTableClassB;
use App\Models\HomeworkTableClassC;
use App\Models\HomepackageTableClassA;
use App\Models\HomepackageTableClassB;
use App\Models\HomepackageTableClassC;

class DeleteOldAssignments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assignments:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete assignments older than 10 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Models with assignments
        $models = [
            HomeworkTableClassA::class,
            HomeworkTableClassB::class,
            HomeworkTableClassC::class,
            HomepackageTableClassA::class,
            HomepackageTableClassB::class,
            HomepackageTableClassC::class,
        ];

        foreach ($models as $model) {
            $deleted = $model::where('created_at', '<', now()->subDays(10))->delete();
            $this->info("Deleted {$deleted} records from {$model}");
        }
    }
}
