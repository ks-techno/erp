<?php

namespace Database\Seeders;

use App\Models\PaymentMode;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_payment_modes = [
            ['name'=>'Cash','default'=>1],
            ['name'=>'Bank','default'=>0],
        ];
        foreach ($data_payment_modes as $payment_mode){
            if(!PaymentMode::where('name',$payment_mode['name'])->exists()){
                PaymentMode::create([
                    'uuid' => Uuid::generate()->string,
                    'name' => $payment_mode['name'],
                    'default' => $payment_mode['default'],
                    'status' => 1,
                ]);
            }
        }
    }
}