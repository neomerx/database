<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Manufacturer;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\BaseProduct as Model;

class MigrateBaseProducts extends BaseMigrate
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
            $table->string(Model::FIELD_SKU, Model::SKU_MAX_LENGTH)->unique();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_LINK, Model::LINK_MAX_LENGTH)->unique();
            $table->unsignedInteger(Model::FIELD_ID_MANUFACTURER);
            $table->boolean(Model::FIELD_ENABLED);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_PRICE_WO_TAX)->unsigned();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_PKG_HEIGHT)->unsigned()->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_PKG_WIDTH)->unsigned()->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_PKG_LENGTH)->unsigned()->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_PKG_WEIGHT)->unsigned()->nullable();

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_MANUFACTURER)->references(Manufacturer::FIELD_ID)
                ->on(Manufacturer::TABLE_NAME);
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
