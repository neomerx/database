<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Models\Employee;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            Employee::FIELD_FIRST_NAME => 'Admin',
            Employee::FIELD_LAST_NAME  => 'Administrator',
            Employee::FIELD_EMAIL      => 'test@neomerx.com',
            Employee::FIELD_PASSWORD   => 'password',
            Employee::FIELD_ACTIVE     => true,
        ]);

        // reserve first 100 IDs, set autoincrement start from 101
        $tableName = Employee::TABLE_NAME;
        DB::unprepared("ALTER TABLE $tableName AUTO_INCREMENT = 101;");
    }
}
