<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Region;
use \Neomerx\Core\Models\Address as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateAddresses extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_REGION)->nullable();
            $table->string(Model::FIELD_CITY, Model::CITY_MAX_LENGTH);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_POSTCODE, Model::POSTCODE_MAX_LENGTH)->nullable();
            $table->string(Model::FIELD_ADDRESS1, Model::ADDRESS_1_MAX_LENGTH);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_ADDRESS2, Model::ADDRESS_2_MAX_LENGTH)->nullable();

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_REGION)->references(Region::FIELD_ID)->on(Region::TABLE_NAME);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public static function down()
    {
        Schema::dropIfExists(Model::TABLE_NAME);
    }
}
