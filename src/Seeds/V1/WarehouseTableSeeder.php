<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Models\Warehouse as Model;

class WarehouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reserve first 100 IDs, set autoincrement start from 101
        $tableName = Model::TABLE_NAME;
        DB::table($tableName)->insert([
            Model::FIELD_CODE => Model::DEFAULT_CODE,
            Model::FIELD_NAME => trans('nm::application.warehouse_default_name'),
        ]);

        DB::unprepared("ALTER TABLE $tableName AUTO_INCREMENT = 101;");
    }
}
