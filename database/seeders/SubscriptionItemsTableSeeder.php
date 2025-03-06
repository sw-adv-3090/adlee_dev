<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubscriptionItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subscription_items')->delete();
        
        \DB::table('subscription_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'subscription_id' => 1,
                'stripe_id' => 'si_QBTyXXN9ePn9gZ',
                'stripe_product' => 'prod_QBLVrFNOJlIjzu',
                'stripe_price' => 'price_1PKyoHI4xwo1dS3RMwOrD5MD',
                'quantity' => 1,
                'created_at' => '2024-05-27 17:07:18',
                'updated_at' => '2024-05-27 17:07:18',
            ),
            1 => 
            array (
                'id' => 2,
                'subscription_id' => 2,
                'stripe_id' => 'si_QBU4lSwfrIbweM',
                'stripe_product' => 'prod_QBLTisOQue3BMO',
                'stripe_price' => 'price_1PKymFI4xwo1dS3RnvPL2ByD',
                'quantity' => 1,
                'created_at' => '2024-05-27 17:13:21',
                'updated_at' => '2024-05-27 17:13:21',
            ),
        ));
        
        
    }
}