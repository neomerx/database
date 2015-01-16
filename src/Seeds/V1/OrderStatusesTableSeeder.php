<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Models\OrderStatus as Model;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableName = Model::TABLE_NAME;
        DB::table($tableName)->insert([
            Model::FIELD_CODE => Model::STATUS_NEW_ORDER,
            Model::FIELD_NAME => trans('nm::application.order_status_new')
        ]);

        // reserve first 100 IDs, set autoincrement start from 101
        DB::unprepared("ALTER TABLE $tableName AUTO_INCREMENT = 101;");
    }
}
