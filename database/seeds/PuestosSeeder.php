<?php

use Illuminate\Database\Seeder;

class PuestosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('charges')->insert([
            'tuition'          => 0,
            'inscription'      => 1,
            'defaulter'        => 0,
            'charge_limit'     => '2017-02-10',
            'quantity'         => 4000,
            'increase'         => 15,
            'state'            => 1,
            'idinscription'    => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);
    }
}
