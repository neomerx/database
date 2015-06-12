<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Carbon\Carbon;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Models\Language as Model;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ISO 639

        // format: iso code, name
        $data = [
            ['eng', 'English'],
        ];

        $now = Carbon::now();
        foreach ($data as $languageData) {
            DB::table(Model::TABLE_NAME)->insert([
                Model::FIELD_ISO_CODE => $languageData[0],
                Model::FIELD_NAME     => $languageData[1],
                Model::FIELD_CREATED_AT  => $now,
                Model::FIELD_UPDATED_AT  => $now,
            ]);
        }
    }
}
