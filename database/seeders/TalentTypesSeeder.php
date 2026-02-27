<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TalentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Since talent types are defined in config, we don't need to seed database
        // This seeder is just for documentation purposes
        $this->command->info('Talent types are configured in config/talent_types.php');
        $this->command->info('No database seeding required for talent types');
    }
}
