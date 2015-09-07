<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Carbon\Carbon;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Models\Language;
use \Neomerx\Core\Models\Country as Model;
use \Neomerx\Core\Models\CountryProperty as Properties;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languageId = DB::table(Language::TABLE_NAME)
            ->where(Language::FIELD_ISO_CODE, 'eng')->first([Language::FIELD_ID])->{Language::FIELD_ID};

        // ISO 3166

        $now = Carbon::now();
        $countryId = DB::table(Model::TABLE_NAME)->insertGetId([
            Model::FIELD_CODE       => 'US',
            Model::FIELD_CREATED_AT => $now,
            Model::FIELD_UPDATED_AT => $now,
        ]);

        DB::table(Properties::TABLE_NAME)->insert([
            Properties::FIELD_ID_COUNTRY  => $countryId,
            Properties::FIELD_ID_LANGUAGE => $languageId,
            Properties::FIELD_NAME        => 'United States',
            Properties::FIELD_DESCRIPTION => 'United States of America',
        ]);
    }
}
