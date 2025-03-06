<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SponsorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sponsors')->delete();
        
        \DB::table('sponsors')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 2,
                'company_name' => 'Jones Trading',
            'company_phone' => '(923) 061-0253',
                'company_logo' => 'storage/uploads/5obiRunW7l9bmCVoiTe7H9vLpIEMxyUXyMlLTK1A.png',
                'ein_number' => '888666',
                'ein_number_verified' => 1,
                'ein_number_verify_tries' => 0,
                'ein_number_verify_last_try' => '2024-05-28 06:12:02',
                'paying_commission' => 0,
                'default_coupon_payout' => 30,
                'address' => '920 5th Ave',
                'postal_code' => '98104',
                'city' => 'Seattle',
                'state' => 'Washington',
                'country' => 'United States',
                'shipping_address' => '920 5th Ave',
                'shipping_postal_code' => '98104',
                'shipping_city' => 'Seattle',
                'shipping_state' => 'Washington',
                'shipping_country' => 'United States',
                'created_at' => '2024-05-28 04:37:47',
                'updated_at' => '2024-05-28 07:59:53',
            ),
        ));
        
        
    }
}