<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Tax;
use \Neomerx\Core\Support as S;
use \Neomerx\Core\Models\Region;
use \Neomerx\Core\Models\Country;
use \Neomerx\Core\Models\TaxRule;
use \Neomerx\Core\Models\Tax as Model;
use \Illuminate\Support\Facades\DB;
use \Neomerx\Core\Models\TaxRulePostcode;
use \Neomerx\Core\Models\TaxRuleTerritory;
use \Neomerx\Core\Models\TaxRuleProductType;
use \Neomerx\Core\Models\TaxRuleCustomerType;
use \Illuminate\Database\Schema\Blueprint;

class MigrateTaxes extends BaseMigrate
{
    /**
     * @var Model
     */
    private static $model = null;

    /**
     * @return Model
     */
    protected static function getModel()
    {
        return self::$model = (self::$model !== null ? self::$model : new Model());
    }

    /**
     * Run the migrations.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public static function up()
    {
        Schema::create(Model::TABLE_NAME, function (Blueprint $table) {
            $table->increments(Model::FIELD_ID);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_CODE, Model::CODE_MAX_LENGTH)->unique();
            $table->text(Model::FIELD_EXPRESSION);
            $table->text(Model::FIELD_EXPRESSION_SERIALIZED);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }
        });

        $typeRegion     = S\nameToDbEnum(Region::BIND_NAME);
        $typeCountry    = S\nameToDbEnum(Country::BIND_NAME);
        $taxesTable     = Tax::TABLE_NAME;
        $taxIdTax       = Tax::FIELD_ID;
        $rTable         = TaxRule::TABLE_NAME;
        $rIdTax         = TaxRule::FIELD_ID_TAX;
        $rIdRule        = TaxRule::FIELD_ID;
        $rPriority      = TaxRule::FIELD_PRIORITY;
        $tTable         = TaxRuleTerritory::TABLE_NAME;
        $tIdRule        = TaxRuleTerritory::FIELD_ID_TAX_RULE;
        $tTerritoryId   = TaxRuleTerritory::FIELD_TERRITORY_ID;
        $tTerritoryType = TaxRuleTerritory::FIELD_TERRITORY_TYPE;
        $zTable         = TaxRulePostcode::TABLE_NAME;
        $zIdRule        = TaxRulePostcode::FIELD_ID_TAX_RULE;
        $zFrom          = TaxRulePostcode::FIELD_POSTCODE_FROM;
        $zTo            = TaxRulePostcode::FIELD_POSTCODE_TO;
        $zMask          = TaxRulePostcode::FIELD_POSTCODE_MASK;
        $cTable         = TaxRuleCustomerType::TABLE_NAME;
        $cIdType        = TaxRuleCustomerType::FIELD_ID_CUSTOMER_TYPE;
        $pTable         = TaxRuleProductType::TABLE_NAME;
        $pIdType        = TaxRuleProductType::FIELD_ID_PRODUCT_TAX_TYPE;

        $spSelectTaxes = <<<EOD
CREATE PROCEDURE `spSelectTaxes` (
	IN countryId INT,
	IN regionId INT,
    IN postcode VARCHAR(12),
	IN customerTypeId INT,
	IN productTypeId INT
)
BEGIN

SELECT DISTINCT $taxesTable.* FROM $rTable AS r

JOIN ($tTable AS t, $zTable AS z, $cTable AS c, $pTable AS p, $taxesTable)

	ON (r.$rIdRule = t.$tIdRule AND
		r.$rIdRule = z.$zIdRule AND
		r.$rIdRule = c.id_tax_rule AND
		r.$rIdRule = p.id_tax_rule AND
		r.$rIdTax  = $taxesTable.$taxIdTax)

WHERE

	(c.$cIdType = customerTypeId OR c.$cIdType IS NULL)

    AND

	(p.$pIdType = productTypeId OR p.$pIdType IS NULL)

    AND

	((t.$tTerritoryId = regionId AND t.$tTerritoryType = '$typeRegion') OR
	(t.$tTerritoryId IS NULL AND t.$tTerritoryType = '$typeRegion') OR
	(t.$tTerritoryId = countryId AND t.$tTerritoryType = '$typeCountry') OR
	(t.$tTerritoryId IS NULL AND t.$tTerritoryType = '$typeCountry'))

    AND

	(z.$zFrom <= postcode OR z.$zFrom IS NULL) AND
	(z.$zTo   >= postcode OR z.$zTo   IS NULL) AND
	(postcode REGEXP z.$zMask OR z.$zMask IS NULL)

ORDER BY r.$rPriority;

END
EOD;
        /** @noinspection PhpUndefinedMethodInspection */
        DB::unprepared('DROP PROCEDURE IF EXISTS `spSelectTaxes`');
        /** @noinspection PhpUndefinedMethodInspection */
        DB::unprepared($spSelectTaxes);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public static function down()
    {
        Schema::dropIfExists(Model::TABLE_NAME);
        /** @noinspection PhpUndefinedMethodInspection */
        DB::unprepared('DROP PROCEDURE IF EXISTS `spSelectTaxes`');
    }
}
