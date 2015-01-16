<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Support as S;
use \Neomerx\Core\Models\Region;
use \Neomerx\Core\Models\Country;
use \Neomerx\Core\Models\Carrier;
use \Illuminate\Support\Facades\DB;
use \Neomerx\Core\Models\CarrierPostcode;
use \Neomerx\Core\Models\Carrier as Model;
use \Neomerx\Core\Models\CarrierTerritory;
use \Neomerx\Core\Models\CarrierCustomerType;
use \Illuminate\Database\Schema\Blueprint;

class MigrateCarriers extends BaseMigrate
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
        return self::$model = self::$model ?: new Model();
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
            /** @noinspection PhpUndefinedMethodInspection */
            $table->text(Model::FIELD_SETTINGS)->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->text(Model::FIELD_DATA)->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->text(Model::FIELD_CACHE)->nullable();
            $table->text(Model::FIELD_FACTORY);
            $table->boolean(Model::FIELD_IS_TAXABLE);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->double(Model::FIELD_MIN_WEIGHT)->unsigned()->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->double(Model::FIELD_MAX_WEIGHT)->unsigned()->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->double(Model::FIELD_MIN_COST)->unsigned()->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->double(Model::FIELD_MAX_COST)->unsigned()->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->double(Model::FIELD_MIN_DIMENSION)->unsigned()->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->double(Model::FIELD_MAX_DIMENSION)->unsigned()->nullable();

            if (self::usesTimestamps()) {
                $table->timestamps();
            }
            if (self::isSoftDeleting()) {
                $table->softDeletes();
            }
        });

        /** @noinspection PhpUndefinedMethodInspection */
        DB::unprepared('DROP PROCEDURE IF EXISTS `spSelectCarriers`');
        /** @noinspection PhpUndefinedMethodInspection */
        DB::unprepared(self::getCreateSpStatement());
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
        DB::unprepared('DROP PROCEDURE IF EXISTS `spSelectCarriers`');
    }

    /**
     * @return string
     */
    private static function getCreateSpStatement()
    {
        $typeRegion     = S\nameToDbEnum(Region::BIND_NAME);
        $typeCountry    = S\nameToDbEnum(Country::BIND_NAME);
        $crTable        = Carrier::TABLE_NAME;
        $crIdCarrier    = Carrier::FIELD_ID;
        $crMinWeight    = Carrier::FIELD_MIN_WEIGHT;
        $crMaxWeight    = Carrier::FIELD_MAX_WEIGHT;
        $crMinDimension = Carrier::FIELD_MIN_DIMENSION;
        $crMaxDimension = Carrier::FIELD_MAX_DIMENSION;
        $crMinCost      = Carrier::FIELD_MIN_COST;
        $crMaxCost      = Carrier::FIELD_MAX_COST;
        $cTable         = CarrierCustomerType::TABLE_NAME;
        $cIdCarrier     = CarrierCustomerType::FIELD_ID_CARRIER;
        $cIdType        = CarrierCustomerType::FIELD_ID_CUSTOMER_TYPE;
        $tTable         = CarrierTerritory::TABLE_NAME;
        $tIdCarrier     = CarrierTerritory::FIELD_ID_CARRIER;
        $tTerritoryId   = CarrierTerritory::FIELD_TERRITORY_ID;
        $tTerritoryType = CarrierTerritory::FIELD_TERRITORY_TYPE;
        $zTable         = CarrierPostcode::TABLE_NAME;
        $zIdCarrier     = CarrierPostcode::FIELD_ID_CARRIER;
        $zFrom          = CarrierPostcode::FIELD_POSTCODE_FROM;
        $zTo            = CarrierPostcode::FIELD_POSTCODE_TO;
        $zMask          = CarrierPostcode::FIELD_POSTCODE_MASK;

        return <<<EOD
CREATE PROCEDURE `spSelectCarriers`(
	IN countryId INT,
	IN regionId INT,
    IN postcode VARCHAR(12),
	IN customerTypeId INT,
    IN pkgWeight FLOAT,
    IN maxDimension FLOAT,
    IN pkgCost FLOAT
)
BEGIN

SELECT DISTINCT cr.* FROM $crTable AS cr

JOIN ($tTable AS t, $cTable AS c, $zTable AS z)

	ON (cr.$crIdCarrier = t.$tIdCarrier AND
		cr.$crIdCarrier = c.$cIdCarrier AND
		cr.$crIdCarrier = z.$zIdCarrier)

WHERE

	(c.$cIdType = customerTypeId OR c.$cIdType IS NULL)

	AND

	((t.$tTerritoryId = regionId AND t.$tTerritoryType = '$typeRegion') OR
	(t.$tTerritoryId IS NULL AND t.$tTerritoryType = '$typeRegion') OR
	(t.$tTerritoryId = countryId AND t.$tTerritoryType = '$typeCountry') OR
	(t.$tTerritoryId IS NULL AND t.$tTerritoryType = '$typeCountry'))

    AND

	(z.$zFrom <= postcode OR z.$zFrom IS NULL) AND
	(z.$zTo   >= postcode OR z.$zTo   IS NULL) AND
	(postcode REGEXP z.$zMask OR z.$zMask IS NULL)

    AND

    (cr.$crMinWeight <= pkgWeight OR cr.$crMinWeight IS NULL)

    AND

    (pkgWeight <= cr.$crMaxWeight OR cr.$crMaxWeight IS NULL)

    AND

    (cr.$crMinDimension <= maxDimension OR cr.$crMinDimension IS NULL)

    AND

    (maxDimension <= cr.$crMaxDimension OR cr.$crMaxDimension IS NULL)

    AND

    (cr.$crMinCost <= pkgCost OR cr.$crMinCost IS NULL)

    AND

    (pkgCost <= cr.$crMaxCost OR cr.$crMaxCost IS NULL);

END
EOD;
    }
}
