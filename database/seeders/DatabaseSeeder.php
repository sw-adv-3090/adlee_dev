<?php

namespace Database\Seeders;

use App\Models\User;
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
            RoleSeeder::class,
            UserSeeder::class,
            PlanSeeder::class,
            CategorySeeder::class
        ]);
        $this->call(TemplatesTableSeeder::class);
        $this->call(SponsorsTableSeeder::class);
        $this->call(SubscriptionsTableSeeder::class);
        $this->call(SubscriptionItemsTableSeeder::class);
    }
}
