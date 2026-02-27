<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TiersTableSeeder::class,
            BankAccountsTableSeeder::class,
            UserSeeder::class,
            // Two Course Seeder - creates 2 courses with 51 Meta Programs each
            TwoCourseSeeder::class,
            // Assessment Course Seeder - creates Assessment Basic, Premium, Elite
            AssessmentCourseSeeder::class,
            // DummyAssessmentResultSeeder::class, // Run manually when needed
        ]);
    }
}
