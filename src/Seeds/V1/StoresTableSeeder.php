<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Models\Address;
use \Neomerx\Core\Models\Region;
use \Neomerx\Core\Models\Store as Model;

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

        $addressId = DB::table(Address::TABLE_NAME)->insertGetId([
            Address::FIELD_ADDRESS1  => '123 Widget Street',
            Address::FIELD_CITY      => 'Acmeville',
            Address::FIELD_POSTCODE  => 12345,
            Address::FIELD_ID_REGION => $regionId,
        ]);

        $tableName = Model::TABLE_NAME;
        DB::table($tableName)->insert([
            Model::FIELD_CODE       => Model::DEFAULT_CODE,
            Model::FIELD_NAME       => trans('nm::application.store_default_name'),
            Model::FIELD_ID_ADDRESS => $addressId,
        ]);
    }
}
