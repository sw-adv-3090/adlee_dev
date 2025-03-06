<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subscriptions')->delete();
        
        \DB::table('subscriptions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 2,
                'type' => 'default',
                'stripe_id' => 'sub_1PL70qI4xwo1dS3RBr54kACz',
                'stripe_status' => 'active',
                'stripe_price' => 'price_1PKyoHI4xwo1dS3RMwOrD5MD',
                'quantity' => 1,
                'trial_ends_at' => NULL,
                'ends_at' => NULL,
                'created_at' => '2024-05-27 17:07:18',
                'updated_at' => '2024-05-27 17:07:19',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 7,
                'type' => 'default',
                'stripe_id' => 'sub_1PL76jI4xwo1dS3RmPdFPEDS',
                'stripe_status' => 'active',
                'stripe_price' => 'price_1PKymFI4xwo1dS3RnvPL2ByD',
                'quantity' => 1,
                'trial_ends_at' => NULL,
                'ends_at' => NULL,
                'created_at' => '2024-05-27 17:13:21',
                'updated_at' => '2024-05-27 17:13:22',
            ),
        ));
        
        
    }
}