<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Support\Translate as T;
use \Neomerx\Core\Models\CustomerType as Model;

class CustomerTypeTableSeeder extends Seeder
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
            [
                Model::FIELD_CODE => 'GENERAL',
                Model::FIELD_NAME => T::trans(T::KEY_MSG_CUSTOMER_TYPE_GENERAL)
            ],
            [
                Model::FIELD_CODE => 'MEMBER',
                Model::FIELD_NAME => T::trans(T::KEY_MSG_CUSTOMER_TYPE_MEMBER)
            ],
            [
                Model::FIELD_CODE => 'NOT-LOGGED-IN',
                Model::FIELD_NAME => T::trans(T::KEY_MSG_CUSTOMER_TYPE_GUEST)
            ],
            [
                Model::FIELD_CODE => 'PRIVATE',
                Model::FIELD_NAME => T::trans(T::KEY_MSG_CUSTOMER_TYPE_PRIVATE)
            ],
            [
                Model::FIELD_CODE => 'RETAIL',
                Model::FIELD_NAME => T::trans(T::KEY_MSG_CUSTOMER_TYPE_RETAIL)
            ],
            [
                Model::FIELD_CODE => 'WHOLESALE',
                Model::FIELD_NAME => T::trans(T::KEY_MSG_CUSTOMER_TYPE_WHOLESALE)
            ],
        ]);

        // reserve first 100 IDs, set autoincrement start from 101
        DB::unprepared("ALTER TABLE $tableName AUTO_INCREMENT = 101;");
    }
}
