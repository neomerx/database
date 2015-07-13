<?php namespace Neomerx\Database\Seeds\V1;

use \DB;
use \Neomerx\Core\Models\Role;
use \Neomerx\Core\Models as M;
use \Illuminate\Database\Seeder;
use \Neomerx\Core\Auth\Permission;
use \Neomerx\Core\Models\ObjectType;
use \Neomerx\Core\Models\RoleObjectType;
use \Neomerx\Core\Repositories\Auth\ObjectTypeRepositoryInterface;
use \Neomerx\Core\Repositories\Auth\RoleObjectTypeRepositoryInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Role $adminRole */
        $adminRole = Role::create([
            Role::FIELD_CODE        => 'ADMIN',
            Role::FIELD_DESCRIPTION => 'Administrator',
        ]);

        // reserve first 100 IDs, set autoincrement start from 101
        $tableName = Role::TABLE_NAME;
        DB::unprepared("ALTER TABLE $tableName AUTO_INCREMENT = 101;");

        // Fill object type table and link those records with admin role

        /** @var ObjectTypeRepositoryInterface $objectRepo */
        $objectRepo = app(ObjectTypeRepositoryInterface::class);
        /** @var RoleObjectTypeRepositoryInterface $relationRepo */
        $relationRepo = app(RoleObjectTypeRepositoryInterface::class);

        $adminPermissions = $this->getAdminPermissions();
        foreach ($adminPermissions as $adminPermission) {
            $objectType = $objectRepo->instance([ObjectType::FIELD_TYPE => $adminPermission[0]]);
            $objectType->saveOrFail();
            $relationRepo->instance($adminRole, $objectType, [
                RoleObjectType::FIELD_ALLOW_MASK => $adminPermission[1],
                RoleObjectType::FIELD_DENY_MASK  => $adminPermission[2],
            ])->saveOrFail();
        }

        // reserve first 10000 IDs, set autoincrement start from 10001
        $tableName = ObjectType::TABLE_NAME;
        DB::unprepared("ALTER TABLE $tableName AUTO_INCREMENT = 10001;");

    }

    /**
     * @return array[]
     */
    private function getAdminPermissions()
    {
        $noPermissions  = 0;
        $allPermissions = Permission::CREATE | Permission::VIEW | Permission::EDIT |
            Permission::DELETE | Permission::RESTORE;

        $adminPermissions = [
            // object type,                      allowed permissions, denied permissions
            [M\Address::class,                       $allPermissions, $noPermissions],
            [M\BaseProduct::class,                   $allPermissions, $noPermissions],
            [M\BaseProductProperties::class,         $allPermissions, $noPermissions],
            [M\Carrier::class,                       $allPermissions, $noPermissions],
            [M\CarrierCustomerType::class,           $allPermissions, $noPermissions],
            [M\CarrierPostcode::class,               $allPermissions, $noPermissions],
            [M\CarrierProperties::class,             $allPermissions, $noPermissions],
            [M\CarrierTerritory::class,              $allPermissions, $noPermissions],
            [M\Category::class,                      $allPermissions, $noPermissions],
            [M\CategoryProperties::class,            $allPermissions, $noPermissions],
            [M\Characteristic::class,                $allPermissions, $noPermissions],
            [M\CharacteristicProperties::class,      $allPermissions, $noPermissions],
            [M\CharacteristicValue::class,           $allPermissions, $noPermissions],
            [M\CharacteristicValueProperties::class, $allPermissions, $noPermissions],
            [M\Country::class,                       $allPermissions, $noPermissions],
            [M\CountryProperties::class,             $allPermissions, $noPermissions],
            [M\Currency::class,                      $allPermissions, $noPermissions],
            [M\CurrencyProperties::class,            $allPermissions, $noPermissions],
            [M\Customer::class,                      $allPermissions, $noPermissions],
            [M\CustomerAddress::class,               $allPermissions, $noPermissions],
            [M\CustomerRisk::class,                  $allPermissions, $noPermissions],
            [M\CustomerType::class,                  $allPermissions, $noPermissions],
            [M\Employee::class,                      $allPermissions, $noPermissions],
            [M\EmployeePasswordReset::class,         $allPermissions, $noPermissions],
            [M\EmployeeRole::class,                  $allPermissions, $noPermissions],
            [M\Image::class,                         $allPermissions, $noPermissions],
            [M\ImageFormat::class,                   $allPermissions, $noPermissions],
            [M\ImagePath::class,                     $allPermissions, $noPermissions],
            [M\ImageProperties::class,               $allPermissions, $noPermissions],
            [M\Inventory::class,                     $allPermissions, $noPermissions],
            [M\Invoice::class,                       $allPermissions, $noPermissions],
            [M\InvoiceOrder::class,                  $allPermissions, $noPermissions],
            [M\InvoicePayment::class,                $allPermissions, $noPermissions],
            [M\Language::class,                      $allPermissions, $noPermissions],
            [M\Manufacturer::class,                  $allPermissions, $noPermissions],
            [M\ManufacturerProperties::class,        $allPermissions, $noPermissions],
            [M\Measurement::class,                   $allPermissions, $noPermissions],
            [M\MeasurementProperties::class,         $allPermissions, $noPermissions],
            [M\ObjectType::class,                    $allPermissions, $noPermissions],
            [M\Order::class,                         $allPermissions, $noPermissions],
            [M\OrderDetails::class,                  $allPermissions, $noPermissions],
            [M\OrderHistory::class,                  $allPermissions, $noPermissions],
            [M\OrderStatus::class,                   $allPermissions, $noPermissions],
            [M\OrderStatusRule::class,               $allPermissions, $noPermissions],
            [M\Product::class,                       $allPermissions, $noPermissions],
            [M\ProductCategory::class,               $allPermissions, $noPermissions],
            [M\ProductImage::class,                  $allPermissions, $noPermissions],
            [M\ProductProperties::class,             $allPermissions, $noPermissions],
            [M\ProductRelated::class,                $allPermissions, $noPermissions],
            [M\ProductTaxType::class,                $allPermissions, $noPermissions],
            [M\Region::class,                        $allPermissions, $noPermissions],
            [M\Role::class,                          $allPermissions, $noPermissions],
            [M\RoleObjectType::class,                $allPermissions, $noPermissions],
            [M\ShippingOrder::class,                 $allPermissions, $noPermissions],
            [M\ShippingOrderStatus::class,           $allPermissions, $noPermissions],
            [M\Specification::class,                 $allPermissions, $noPermissions],
            [M\Store::class,                         $allPermissions, $noPermissions],
            [M\Supplier::class,                      $allPermissions, $noPermissions],
            [M\SupplierProperties::class,            $allPermissions, $noPermissions],
            [M\SupplyOrder::class,                   $allPermissions, $noPermissions],
            [M\SupplyOrderDetails::class,            $allPermissions, $noPermissions],
            [M\Tax::class,                           $allPermissions, $noPermissions],
            [M\TaxRule::class,                       $allPermissions, $noPermissions],
            [M\TaxRuleCustomerType::class,           $allPermissions, $noPermissions],
            [M\TaxRulePostcode::class,               $allPermissions, $noPermissions],
            [M\TaxRuleProductType::class,            $allPermissions, $noPermissions],
            [M\TaxRuleTerritory::class,              $allPermissions, $noPermissions],
            [M\Warehouse::class,                     $allPermissions, $noPermissions],
        ];

        return $adminPermissions;
    }
}
