<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ParticularsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $particulars = [
                        [  'name' => 'Down Payment',   ],
                        [  'name' => 'Instalments',   ],
                        [  'name' => 'Instalment on Balloting',   ],
                        [  'name' => 'Instalment on Possession',   ],
                        [  'name' => 'Location Charges',   ],
                        [  'name' => 'Extra Covered Area',   ],
                        [  'name' => 'Cost Esclation',   ],
                        [  'name' => 'Sub-Division Fee',   ],
                        [  'name' => 'Possession Fee',   ],
                        [  'name' => 'Map Approval',   ],
                        [  'name' => 'Lesco Charges',   ],
                        [  'name' => 'Security & Maintenance',   ],
                        [  'name' => 'Restoration Charges',   ],
                        [  'name' => 'Merging Fee',   ],
                        [  'name' => 'Transfer Fee',   ],
                        [  'name' => 'Other Charges',   ],
                    ];

        DB::table('particulars')->insert($particulars);
    }
}
