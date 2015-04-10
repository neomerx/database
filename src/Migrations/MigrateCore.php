<?php namespace Neomerx\Database\Migrations;

use \Neomerx\Database\Migrations\V1\MigrateRoles;
use \Neomerx\Database\Migrations\V1\MigrateTaxes;
use \Neomerx\Database\Migrations\V1\MigrateOrders;
use \Neomerx\Database\Migrations\V1\MigrateImages;
use \Neomerx\Database\Migrations\V1\MigrateStores;
use \Neomerx\Database\Migrations\V1\MigrateRegions;
use \Neomerx\Database\Migrations\V1\MigrateCarriers;
use \Neomerx\Database\Migrations\V1\MigrateInvoices;
use \Neomerx\Database\Migrations\V1\MigrateProducts;
use \Neomerx\Database\Migrations\V1\MigrateTaxRules;
use \Neomerx\Database\Migrations\V1\MigrateVariants;
use \Neomerx\Database\Migrations\V1\MigrateAddresses;
use \Neomerx\Database\Migrations\V1\MigrateCountries;
use \Neomerx\Database\Migrations\V1\MigrateCustomers;
use \Neomerx\Database\Migrations\V1\MigrateEmployees;
use \Neomerx\Database\Migrations\V1\MigrateImagePath;
use \Neomerx\Database\Migrations\V1\MigrateInventory;
use \Neomerx\Database\Migrations\V1\MigrateLanguages;
use \Neomerx\Database\Migrations\V1\MigrateSuppliers;
use \Neomerx\Database\Migrations\V1\MigrateCategories;
use \Neomerx\Database\Migrations\V1\MigrateCurrencies;
use \Neomerx\Database\Migrations\V1\MigrateWarehouses;
use \Neomerx\Database\Migrations\V1\MigrateObjectTypes;
use \Neomerx\Database\Migrations\V1\MigrateImageFormats;
use \Neomerx\Database\Migrations\V1\MigrateMeasurements;
use \Neomerx\Database\Migrations\V1\MigrateOrderDetails;
use \Neomerx\Database\Migrations\V1\MigrateSupplyOrders;
use \Neomerx\Database\Migrations\V1\MigrateCustomerRisks;
use \Neomerx\Database\Migrations\V1\MigrateCustomerTypes;
use \Neomerx\Database\Migrations\V1\MigrateEmployeeRoles;
use \Neomerx\Database\Migrations\V1\MigrateInvoiceOrders;
use \Neomerx\Database\Migrations\V1\MigrateManufacturers;
use \Neomerx\Database\Migrations\V1\MigrateOrderStatuses;
use \Neomerx\Database\Migrations\V1\MigrateProductImages;
use \Neomerx\Database\Migrations\V1\MigrateOrderHistories;
use \Neomerx\Database\Migrations\V1\MigrateProductRelated;
use \Neomerx\Database\Migrations\V1\MigrateShippingOrders;
use \Neomerx\Database\Migrations\V1\MigrateSpecifications;
use \Neomerx\Database\Migrations\V1\MigrateCharacteristics;
use \Neomerx\Database\Migrations\V1\MigrateImageProperties;
use \Neomerx\Database\Migrations\V1\MigrateInvoicePayments;
use \Neomerx\Database\Migrations\V1\MigrateProductTaxTypes;
use \Neomerx\Database\Migrations\V1\MigrateCarrierPostcodes;
use \Neomerx\Database\Migrations\V1\MigrateOrderStatusRules;
use \Neomerx\Database\Migrations\V1\MigrateRolesObjectTypes;
use \Neomerx\Database\Migrations\V1\MigrateTaxRulePostcodes;
use \Neomerx\Database\Migrations\V1\MigrateCarrierProperties;
use \Neomerx\Database\Migrations\V1\MigrateCountryProperties;
use \Neomerx\Database\Migrations\V1\MigrateCustomerAddresses;
use \Neomerx\Database\Migrations\V1\MigrateProductCategories;
use \Neomerx\Database\Migrations\V1\MigrateProductProperties;
use \Neomerx\Database\Migrations\V1\MigrateVariantProperties;
use \Neomerx\Database\Migrations\V1\MigrateCarrierTerritories;
use \Neomerx\Database\Migrations\V1\MigrateCategoryProperties;
use \Neomerx\Database\Migrations\V1\MigrateCurrencyProperties;
use \Neomerx\Database\Migrations\V1\MigrateSupplierProperties;
use \Neomerx\Database\Migrations\V1\MigrateSupplyOrderDetails;
use \Neomerx\Database\Migrations\V1\MigrateTaxRuleTerritories;
use \Neomerx\Database\Migrations\V1\MigrateTaxRuleProductTypes;
use \Neomerx\Database\Migrations\V1\MigrateCarrierCustomerTypes;
use \Neomerx\Database\Migrations\V1\MigrateCharacteristicValues;
use \Neomerx\Database\Migrations\V1\MigrateTaxRuleCustomerTypes;
use \Neomerx\Database\Migrations\V1\MigrateMeasurementProperties;
use \Neomerx\Database\Migrations\V1\MigrateShippingOrderStatuses;
use \Neomerx\Database\Migrations\V1\MigrateCustomerPasswordResets;
use \Neomerx\Database\Migrations\V1\MigrateEmployeePasswordResets;
use \Neomerx\Database\Migrations\V1\MigrateManufacturerProperties;
use \Neomerx\Database\Migrations\V1\MigrateCharacteristicProperties;
use \Neomerx\Database\Migrations\V1\MigrateCharacteristicValueProperties;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MigrateCore
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public static function up()
    {
        MigrateEmployees::up();
        MigrateLanguages::up();
        MigrateCategories::up();
        MigrateCategoryProperties::up();
        MigrateCountries::up();
        MigrateCountryProperties::up();
        MigrateRegions::up();
        MigrateAddresses::up();
        MigrateManufacturers::up();
        MigrateManufacturerProperties::up();
        MigrateCarriers::up();
        MigrateCarrierProperties::up();
        MigrateImages::up();
        MigrateImageProperties::up();
        MigrateImageFormats::up();
        MigrateImagePath::up();
        MigrateProductTaxTypes::up();
        MigrateProducts::up();
        MigrateVariants::up();
        MigrateVariantProperties::up();
        MigrateProductCategories::up();
        MigrateProductRelated::up();
        MigrateProductImages::up();
        MigrateProductProperties::up();
        MigrateStores::up();
        MigrateWarehouses::up();
        MigrateInventory::up();
        MigrateMeasurements::up();
        MigrateMeasurementProperties::up();
        MigrateCharacteristics::up();
        MigrateCharacteristicProperties::up();
        MigrateCharacteristicValues::up();
        MigrateCharacteristicValueProperties::up();
        MigrateSpecifications::up();
        MigrateCustomerRisks::up();
        MigrateCustomerTypes::up();
        MigrateCustomers::up();
        MigrateOrderStatuses::up();
        MigrateOrderStatusRules::up();
        MigrateOrders::up();
        MigrateShippingOrderStatuses::up();
        MigrateShippingOrders::up();
        MigrateOrderHistories::up();
        MigrateOrderDetails::up();
        MigrateSuppliers::up();
        MigrateSupplierProperties::up();
        MigrateCarrierCustomerTypes::up();
        MigrateCarrierTerritories::up();
        MigrateCarrierPostcodes::up();
        MigrateInvoices::up();
        MigrateInvoiceOrders::up();
        MigrateInvoicePayments::up();
        MigrateRoles::up();
        MigrateEmployeeRoles::up();
        MigrateCurrencies::up();
        MigrateCurrencyProperties::up();
        MigrateSupplyOrders::up();
        MigrateSupplyOrderDetails::up();
        MigrateCustomerAddresses::up();
        MigrateTaxes::up();
        MigrateTaxRules::up();
        MigrateTaxRuleTerritories::up();
        MigrateTaxRuleCustomerTypes::up();
        MigrateTaxRulePostcodes::up();
        MigrateTaxRuleProductTypes::up();
        MigrateCustomerPasswordResets::up();
        MigrateEmployeePasswordResets::up();
        MigrateObjectTypes::up();
        MigrateRolesObjectTypes::up();

        // <-- add new migrations here
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public static function down()
    {
        // <-- add new migrations here

        MigrateRolesObjectTypes::down();
        MigrateObjectTypes::down();
        MigrateEmployeePasswordResets::down();
        MigrateCustomerPasswordResets::down();
        MigrateTaxRuleProductTypes::down();
        MigrateTaxRulePostcodes::down();
        MigrateTaxRuleCustomerTypes::down();
        MigrateTaxRuleTerritories::down();
        MigrateTaxRules::down();
        MigrateTaxes::down();
        MigrateCustomerAddresses::down();
        MigrateSupplyOrderDetails::down();
        MigrateSupplyOrders::down();
        MigrateCurrencyProperties::down();
        MigrateCurrencies::down();
        MigrateEmployeeRoles::down();
        MigrateRoles::down();
        MigrateInvoicePayments::down();
        MigrateInvoiceOrders::down();
        MigrateInvoices::down();
        MigrateCarrierPostcodes::down();
        MigrateCarrierTerritories::down();
        MigrateCarrierCustomerTypes::down();
        MigrateSupplierProperties::down();
        MigrateSuppliers::down();
        MigrateOrderDetails::down();
        MigrateOrderHistories::down();
        MigrateShippingOrders::down();
        MigrateShippingOrderStatuses::down();
        MigrateOrders::down();
        MigrateOrderStatusRules::down();
        MigrateOrderStatuses::down();
        MigrateCustomers::down();
        MigrateCustomerTypes::down();
        MigrateCustomerRisks::down();
        MigrateSpecifications::down();
        MigrateCharacteristicValueProperties::down();
        MigrateCharacteristicValues::down();
        MigrateCharacteristicProperties::down();
        MigrateCharacteristics::down();
        MigrateMeasurementProperties::down();
        MigrateMeasurements::down();
        MigrateInventory::down();
        MigrateWarehouses::down();
        MigrateStores::down();
        MigrateProductProperties::down();
        MigrateProductImages::down();
        MigrateProductRelated::down();
        MigrateProductCategories::down();
        MigrateVariantProperties::down();
        MigrateVariants::down();
        MigrateProducts::down();
        MigrateProductTaxTypes::down();
        MigrateImagePath::down();
        MigrateImageFormats::down();
        MigrateImageProperties::down();
        MigrateImages::down();
        MigrateCarrierProperties::down();
        MigrateCarriers::down();
        MigrateManufacturerProperties::down();
        MigrateManufacturers::down();
        MigrateAddresses::down();
        MigrateRegions::down();
        MigrateCountryProperties::down();
        MigrateCountries::down();
        MigrateCategoryProperties::down();
        MigrateCategories::down();
        MigrateLanguages::down();
        MigrateEmployees::down();
    }
}
