<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // basic plan
        Plan::create([
            'type' => UserType::SPONSOR->value,
            'name' => 'Basic',
            'price' => 29.99,
            'ach_transaction_fee' => 0.08,
            'credit_card_transaction_fee' => 3,
            'transaction_service_fee' => 3,
            'free_booklets' => 0,
            'booklet_fee' => 30,
            'booklet_pages' => 50,
            'specifications' => [],
            'stripe_product_id' => 'prod_QBLTisOQue3BMO',
            'stripe_price_id' => 'price_1PKymFI4xwo1dS3RnvPL2ByD',
        ]);

        // premier plan
        Plan::create([
            'type' => UserType::SPONSOR->value,
            'name' => 'Premier',
            'price' => 79.99,
            'ach_transaction_fee' => 0.08,
            'credit_card_transaction_fee' => 3,
            'transaction_service_fee' => 1,
            'free_booklets' => 1,
            'booklet_fee' => 30,
            'booklet_pages' => 50,
            'specifications' => [],
            'stripe_product_id' => 'prod_QBLVrFNOJlIjzu',
            'stripe_price_id' => 'price_1PKyoHI4xwo1dS3RMwOrD5MD',
        ]);
    }
}
