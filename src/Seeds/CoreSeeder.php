<?php namespace Neomerx\Database\Seeds;

use \Illuminate\Database\Seeder;
use \Neomerx\Database\Seeds\V1\RoleTableSeeder;
use \Neomerx\Database\Seeds\V1\StoresTableSeeder;
use \Neomerx\Database\Seeds\V1\RegionsTableSeeder;
use \Neomerx\Database\Seeds\V1\EmployeeTableSeeder;
use \Neomerx\Database\Seeds\V1\CountriesTableSeeder;
use \Neomerx\Database\Seeds\V1\LanguagesTableSeeder;
use \Neomerx\Database\Seeds\V1\WarehouseTableSeeder;
use \Neomerx\Database\Seeds\V1\CategoriesTableSeeder;
use \Neomerx\Database\Seeds\V1\CustomerTypeTableSeeder;
use \Neomerx\Database\Seeds\V1\OrderStatusesTableSeeder;
use \Neomerx\Database\Seeds\V1\ProductTaxTypesTableSeeder;

class CoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguagesTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(OrderStatusesTableSeeder::class);
        $this->call(ProductTaxTypesTableSeeder::class);
        $this->call(CustomerTypeTableSeeder::class);
        $this->call(WarehouseTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(StoresTableSeeder::class);
    }
}
