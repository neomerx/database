<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Neomerx\Core\Models\Role;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Models\Employee;
use \Neomerx\Core\Repositories\Employees\EmployeeRoleRepositoryInterface;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add employee
        $employee = Employee::create([
            Employee::FIELD_FIRST_NAME => 'Admin',
            Employee::FIELD_LAST_NAME  => 'Administrator',
            Employee::FIELD_EMAIL      => 'test@neomerx.com',
            Employee::FIELD_PASSWORD   => 'password',
            Employee::FIELD_ACTIVE     => true,
        ]);

        /** @var Role $role */
        $role = Role::where(Role::FIELD_CODE, 'ADMIN')->firstOrFail();

        /** @var EmployeeRoleRepositoryInterface $employeeRoleRepo */
        $employeeRoleRepo = app(EmployeeRoleRepositoryInterface::class);
        $employeeRoleRepo->instance($employee, $role)->saveOrFail();

        // reserve first 100 IDs, set autoincrement start from 101
        $tableName = Employee::TABLE_NAME;
        DB::unprepared("ALTER TABLE $tableName AUTO_INCREMENT = 101;");
    }
}
