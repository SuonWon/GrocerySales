<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\UnitMeasurement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $customer1 = Customer::factory()->create([
            'CustomerCode'=>'CS-00001',
            'CustomerName'=>'Davis',
            'NRCNo' => '9/AHMAZA(N)000000',
            'CompanyName' => 'Best',
            'Street' => '12 Road',
            'City' => 'Mandalay',
            'Region' => 'Mandalay',
            'ContactNo'=> '083128312',
            'OfficeNo' => '09987654321',
            'Email' => 'davis@gmail.com',
            'IsActive' => 1,
            'CreatedBy' => 'admin'

        ]);

        $customer2 = Customer::factory()->create([
            'CustomerCode'=>'CS-00002',
            'CustomerName'=>'Htet Wai Aung',
            'NRCNo' => '9/AHMAZA(N)000000',
            'CompanyName' => 'Best',
            'Street' => '12 Road',
            'City' => 'Mandalay',
            'Region' => 'Mandalay',
            'ContactNo'=> '083128312',
            'OfficeNo' => '09987654321',
            'Email' => 'davis@gmail.com',
            'IsActive' => 1,
            'CreatedBy' => 'admin'

        ]);
        $unit = UnitMeasurement::factory()->create([
            'UnitCode' => 'kg',
            'UnitDesc' => 'ကီလိုဂရမ်',
            'CreatedBy' => 'aungaung'
        ]);


        $category1 = ItemCategory::factory()->create([
            'ItemCategoryCode' => 'IT-00001',
            'ItemCategoryName' => 'vegetable',
            'CreatedBy' => 'aungaung'
        ]);


        $item = Item::factory()->create([
             'ItemCode' => 'I-00001',
             'ItemName' => 'apple',
             'ItemCategoryCode' => 'IT-00001',
             'BaseUnit' => 'kg',
             'UnitPrice' => 500,
             'DefSalesUnit' => 'kg',
             'DefPurUnit' => 'kg',
             'LastPurPrice' => 500,
             'Discontinued' => 1,
             'Remark' => 'ahah',
             'CreatedBy' => 'aungaung'
        ]);


    }
}
