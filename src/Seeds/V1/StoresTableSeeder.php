<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Carbon\Carbon;
use \Neomerx\Core\Models\Region;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Models\Address;
use \Neomerx\Core\Models\Store as Model;
use \Neomerx\Core\Support\Translate as T;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default store with address should be filled in during install

        $regionId = DB::table(Region::TABLE_NAME)
            ->where(Region::FIELD_CODE, 'CA')->first([Region::FIELD_ID])->{Region::FIELD_ID};

        $now = Carbon::now();
        $addressId = DB::table(Address::TABLE_NAME)->insertGetId([
            Address::FIELD_ADDRESS1   => '123 Widget Street',
            Address::FIELD_CITY       => 'Acmeville',
            Address::FIELD_POSTCODE   => 12345,
            Address::FIELD_ID_REGION  => $regionId,
            Address::FIELD_CREATED_AT => $now,
            Address::FIELD_UPDATED_AT => $now,
        ]);

        $tableName = Model::TABLE_NAME;
        DB::table($tableName)->insert([
            Model::FIELD_CODE       => Model::DEFAULT_CODE,
            Model::FIELD_NAME       => T::trans(T::KEY_MSG_STORE_DEFAULT_NAME),
            Model::FIELD_ID_ADDRESS => $addressId,
        ]);
    }
}
