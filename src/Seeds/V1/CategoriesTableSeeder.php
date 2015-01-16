<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Carbon\Carbon;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Models\Category as Model;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $tableName = Model::TABLE_NAME;
        DB::table($tableName)->insert([
            Model::FIELD_ID_ANCESTOR => 1,
            Model::FIELD_CODE        => Model::ROOT_CODE,
            Model::FIELD_LINK        => '/',
            Model::FIELD_ENABLED     => true,
            Model::FIELD_LFT         => 1,
            Model::FIELD_RGT         => 2,
            Model::FIELD_CREATED_AT  => $now,
            Model::FIELD_UPDATED_AT  => $now,
        ]);

        // reserve first 100 IDs, set autoincrement start from 101
        DB::unprepared("ALTER TABLE $tableName AUTO_INCREMENT = 101;");
    }
}
