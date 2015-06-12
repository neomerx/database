<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Carbon\Carbon;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Models\Country;
use \Neomerx\Core\Models\Region as Model;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ISO 3166

        // format: code, name, position, country code
        $data = [
            ['AL', 'Alabama',                   1,  'US'],
            ['AK', 'Alaska',                    2,  'US'],
            ['AZ', 'Arizona',                   3,  'US'],
            ['AR', 'Arkansas',                  4,  'US'],
            ['CA', 'California',                5,  'US'],
            ['CO', 'Colorado',                  6,  'US'],
            ['CT', 'Connecticut',               7,  'US'],
            ['DE', 'Delaware',                  8,  'US'],
            ['FL', 'Florida',                   9,  'US'],
            ['GA', 'Georgia',                   10, 'US'],
            ['HI', 'Hawaii',                    11, 'US'],
            ['ID', 'Idaho',                     12, 'US'],
            ['IL', 'Illinois',                  13, 'US'],
            ['IN', 'Indiana',                   14, 'US'],
            ['IA', 'Iowa',                      15, 'US'],
            ['KS', 'Kansas',                    16, 'US'],
            ['KY', 'Kentucky',                  17, 'US'],
            ['LA', 'Louisiana',                 18, 'US'],
            ['ME', 'Maine',                     19, 'US'],
            ['MD', 'Maryland',                  20, 'US'],
            ['MA', 'Massachusetts',             21, 'US'],
            ['MI', 'Michigan',                  22, 'US'],
            ['MN', 'Minnesota',                 23, 'US'],
            ['MS', 'Mississippi',               24, 'US'],
            ['MO', 'Missouri',                  25, 'US'],
            ['MT', 'Montana',                   26, 'US'],
            ['NE', 'Nebraska',                  27, 'US'],
            ['NV', 'Nevada',                    28, 'US'],
            ['NH', 'New Hampshire',             29, 'US'],
            ['NJ', 'New Jersey',                30, 'US'],
            ['NM', 'New Mexico',                31, 'US'],
            ['NY', 'New York',                  32, 'US'],
            ['NC', 'North Carolina',            33, 'US'],
            ['ND', 'North Dakota',              34, 'US'],
            ['OH', 'Ohio',                      35, 'US'],
            ['OK', 'Oklahoma',                  36, 'US'],
            ['OR', 'Oregon',                    37, 'US'],
            ['PA', 'Pennsylvania',              38, 'US'],
            ['RI', 'Rhode Island',              39, 'US'],
            ['SC', 'South Carolina',            40, 'US'],
            ['SD', 'South Dakota',              41, 'US'],
            ['TN', 'Tennessee',                 42, 'US'],
            ['TX', 'Texas',                     43, 'US'],
            ['UT', 'Utah',                      44, 'US'],
            ['VT', 'Vermont',                   45, 'US'],
            ['VA', 'Virginia',                  46, 'US'],
            ['WA', 'Washington',                47, 'US'],
            ['DC', 'Washington, D.C.',          48, 'US'],
            ['WV', 'West Virginia',             49, 'US'],
            ['WI', 'Wisconsin',                 50, 'US'],
            ['WY', 'Wyoming',                   51, 'US'],
            ['AS', 'American Samoa',            52, 'US'],
            ['GU', 'Guam',                      53, 'US'],
            ['MP', 'Northern Mariana Islands',  54, 'US'],
            ['PR', 'Puerto Rico',               55, 'US'],
            ['VI', 'Virgin Islands',            56, 'US'],
        ];

        foreach ($data as $regionData) {
            $countryId = DB::table(Country::TABLE_NAME)
                ->where(Country::FIELD_CODE, $regionData[3])->first([Country::FIELD_ID])->{Country::FIELD_ID};

            $now = Carbon::now();
            DB::table(Model::TABLE_NAME)->insert([
                Model::FIELD_ID_COUNTRY => $countryId,
                Model::FIELD_CODE       => $regionData[0],
                Model::FIELD_NAME       => $regionData[1],
                Model::FIELD_POSITION   => $regionData[2],
                Model::FIELD_CREATED_AT => $now,
                Model::FIELD_UPDATED_AT => $now,
            ]);
        }
    }
}
