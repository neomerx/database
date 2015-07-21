<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Product;
use \Neomerx\Core\Models\BaseProduct;
use \Neomerx\Core\Models\FeatureValue;
use \Neomerx\Core\Models\Aspect as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateAspects extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_BASE_PRODUCT);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_PRODUCT)->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->tinyInteger(Model::FIELD_POSITION)->unsigned();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_VALUE);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            $table->unique(
                [Model::FIELD_ID_BASE_PRODUCT, Model::FIELD_ID_PRODUCT, Model::FIELD_ID_VALUE],
                'unique_value_for_base_product_and_product'
            );

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_BASE_PRODUCT)
                ->references(BaseProduct::FIELD_ID)
                ->on(BaseProduct::TABLE_NAME)
                ->onDelete('cascade');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_PRODUCT)->references(Product::FIELD_ID)->on(Product::TABLE_NAME)
                ->onDelete('cascade');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_VALUE)->references(FeatureValue::FIELD_ID)
                ->on(FeatureValue::TABLE_NAME);
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
