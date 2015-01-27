<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Product;
use \Neomerx\Core\Models\Variant;
use \Neomerx\Core\Models\CharacteristicValue;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\Specification as Model;

class MigrateSpecifications extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_PRODUCT);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_VARIANT)->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->tinyInteger(Model::FIELD_POSITION)->unsigned();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_CHARACTERISTIC_VALUE);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            $table->unique(
                [Model::FIELD_ID_PRODUCT, Model::FIELD_ID_VARIANT, Model::FIELD_ID_CHARACTERISTIC_VALUE],
                'unique_value_for_product_and_variant'
            );

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_PRODUCT)->references(Product::FIELD_ID)->on(Product::TABLE_NAME)
                ->onDelete('cascade');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_VARIANT)->references(Variant::FIELD_ID)->on(Variant::TABLE_NAME)
                ->onDelete('cascade');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CHARACTERISTIC_VALUE)->references(CharacteristicValue::FIELD_ID)
                ->on(CharacteristicValue::TABLE_NAME);
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
