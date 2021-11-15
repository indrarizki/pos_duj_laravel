<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {

        DB::table('users')->insert([
            'name' => 'manager_center',
            'email' => 'managercenter' . '@gmail.com',
            'password' => Hash::make('managercenter'),
            'role' => 'manager_center',
            'address' => 'kelapa gading',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // DB::table('users')->insert([
        //     'name' => 'masep',
        //     'email' => 'masep' . '@gmail.com',
        //     'password' => Hash::make('masep'),
        //     'role' => 'resepsionist',
        //     'address' => 'kelapa gading',
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'bossku',
        //     'email' => 'bossku' . '@gmail.com',
        //     'password' => Hash::make('bossku'),
        //     'role' => 'manager',
        //     'address' => 'kelapa gading',
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'kasirku',
        //     'email' => 'kasirku' . '@gmail.com',
        //     'password' => Hash::make('kasirku'),
        //     'role' => 'kasir',
        //     'address' => 'kelapa gading',
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        // ]);


        // DB::table('budgetings')->insert([
        //     'id' => 1,
        //     'name' => 'warung',
        //     'nominal' => '10000000',
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        // ]);


        // DB::table('realizations')->insert([
        //     'name' => 'piring',
        //     'nominal' => '90000',
        //     'budgeting_id' => '1',
        //     //     'address' => 'kelapa muda',
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        // ]);

        // DB::table('customers')->insert([
        //     'name' => 'rasep',
        //     'id' => '350192410121',
        //     'phone' => '08223456222',
        //     'address' => 'kelapa muda',
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        // ]);


        // DB::table('stores')->insert([
        //     'name' => 'toko A',
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);

        // $product_id = Str::random(10);
        // $product_quantity = 10000;
        // $product_name = 'vaksin';
        // $product_price = 5000;

        // DB::table('warehouse_products')->insert([
        //     'id' => $product_id,
        //     'name' => $product_name,
        //     'price' => $product_price,
        //     'quantity' => $product_quantity,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);

        // DB::table('products')->insert([
        //     'store_id' => 1,
        //     'warehouse_product_id' => $product_id,
        //     'price' => $product_price,
        //     'quantity' => 500,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);

        // DB::table('report_products')->insert([
        //     'product_id' => 1,
        //     'in' => 500,
        //     'out' => 0,
        //     'remainder' => 500,
        //     'information' => 'dari markas',
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);

        // $product_id = Str::random(10);
        // $product_quantity = 1000;
        // $product_name = 'sampo';
        // $product_price = 1000;


        // DB::table('warehouse_products')->insert([
        //     'id' => $product_id,
        //     'name' => $product_name,
        //     'price' => $product_price,
        //     'quantity' => $product_quantity,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);

        // DB::table('products')->insert([
        //     'store_id' => 1,
        //     'warehouse_product_id' => $product_id,
        //     'quantity' => 500,
        //     'price' => $product_price,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);


        // DB::table('report_products')->insert([
        //     'product_id' => 1,
        //     'in' => 500,
        //     'out' => 0,
        //     'remainder' => 500,
        //     'information' => 'dari markas',
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);
    }
}
