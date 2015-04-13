<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Support\Translate as T;
use \Neomerx\Core\Models\ProductTaxType as Model;

class ProductTaxTypesTableSeeder extends Seeder
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
                // this should be #1 see ProductTaxType::SHIPPING_ID
                Model::FIELD_CODE => Model::SHIPPING_CODE,
                Model::FIELD_NAME => T::trans(T::KEY_MSG_PRODUCT_TAX_TYPE_SHIPPING)
            ],
            [
                // this should be #2 see ProductTaxType::EXEMPT_ID
                Model::FIELD_CODE => Model::EXEMPT_CODE,
                Model::FIELD_NAME => T::trans(T::KEY_MSG_PRODUCT_TAX_TYPE_EXEMPT)
            ],
            [
                // this should be #3 see ProductTaxType::TAXABLE_ID
                Model::FIELD_CODE => Model::TAXABLE_CODE,
                Model::FIELD_NAME => T::trans(T::KEY_MSG_PRODUCT_TAX_TYPE_TAXABLE)
            ],
        ]);

        // reserve first 100 IDs, set autoincrement start from 101
        DB::unprepared("ALTER TABLE $tableName AUTO_INCREMENT = 101;");
    }
}
