<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\DummyAssessmentResultSeeder;

class CreateDummyAssessment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assessment:create-dummy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create dummy assessment result data for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating dummy assessment data...');

        $seeder = new DummyAssessmentResultSeeder();
        $seeder->setCommand($this);
        $seeder->run();

        $this->newLine();
        $this->info('✅ Dummy assessment data created successfully!');
        $this->info('You can now visit the results page to see the dummy data.');
        $this->newLine();
        $this->info('To view results, visit: ' . route('results.index'));
    }
}
