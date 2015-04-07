<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Neomerx\Core\Models\Role;
use \Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            Role::FIELD_CODE        => 'ADMIN',
            Role::FIELD_DESCRIPTION => 'Administrator',
        ]);

        // reserve first 100 IDs, set autoincrement start from 101
        $tableName = Role::TABLE_NAME;
        DB::unprepared("ALTER TABLE $tableName AUTO_INCREMENT = 101;");
    }
}
