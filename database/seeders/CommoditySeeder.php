<?php

namespace Database\Seeders;

use App\Models\Commodity;
use App\Models\DailyPrice;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Default Admin User
        User::firstOrCreate(
            ['email' => 'admin@sastabazaar.gov.pk'],
            [
                'name' => 'District Admin',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Pre-seed Standard Essential Commodities in Pakistan
        $items = [
            ['name' => 'Wheat Flour (Ata)', 'urdu_name' => 'آٹا', 'unit' => '10 Kg Bag', 'price' => 1350.00],
            ['name' => 'Sugar (Chini)', 'urdu_name' => 'چینی', 'unit' => '1 Kg', 'price' => 145.00],
            ['name' => 'Milk (Doodh)', 'urdu_name' => 'دودھ', 'unit' => '1 Litre', 'price' => 210.00],
            ['name' => 'Onions (Piaz)', 'urdu_name' => 'پیاز', 'unit' => '1 Kg', 'price' => 180.00],
            ['name' => 'Potatoes (Aloo)', 'urdu_name' => 'آلو', 'unit' => '1 Kg', 'price' => 90.00],
            ['name' => 'Tomatoes (Tamatar)', 'urdu_name' => 'ٹماٹر', 'unit' => '1 Kg', 'price' => 120.00],
            ['name' => 'Cooking Oil', 'urdu_name' => 'کوکنگ آئل', 'unit' => '1 Litre', 'price' => 520.00],
            ['name' => 'Daal Chana', 'urdu_name' => 'دال چنا', 'unit' => '1 Kg', 'price' => 260.00],
        ];

        $today = now()->toDateString();

        foreach ($items as $item) {
            $commodity = Commodity::firstOrCreate(
                ['name' => $item['name']],
                [
                    'urdu_name' => $item['urdu_name'],
                    'unit' => $item['unit'],
                ]
            );

            DailyPrice::updateOrCreate(
                [
                    'commodity_id' => $commodity->id,
                    'active_date' => $today,
                ],
                [
                    'official_price' => $item['price'],
                ]
            );
        }

        // 3. Sample Citizen Complaints
        Complaint::firstOrCreate(
            ['citizen_phone' => '03001234567', 'shop_name' => 'Bismillah General Store'],
            [
                'citizen_name' => 'Ali Raza',
                'location_address' => 'Shop #12, Main Bazaar, Lahore',
                'description' => 'Charging 170 PKR per kg for sugar instead of official rate of 145 PKR.',
                'status' => 'Pending',
            ]
        );

        Complaint::firstOrCreate(
            ['citizen_phone' => '03219876543', 'shop_name' => 'Al-Madina Milk Shop'],
            [
                'citizen_name' => 'Usman Khan',
                'location_address' => 'Ghalib Market, Gulberg, Lahore',
                'description' => 'Selling loose milk for 250 PKR per Litre.',
                'status' => 'Resolved',
            ]
        );
    }
}
