<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Category;
use \Neomerx\Core\Models\BaseProduct;
use \Neomerx\Core\Models\ProductTaxType;
use \Neomerx\Core\Models\Product as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateProducts extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_CATEGORY_DEFAULT);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_SKU, Model::SKU_MAX_LENGTH)->unique();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_PRICE_WO_TAX)->unsigned()->nullable();
            $table->unsignedInteger(Model::FIELD_ID_PRODUCT_TAX_TYPE);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_BASE_PRODUCT)
                ->references(BaseProduct::FIELD_ID)
                ->on(BaseProduct::TABLE_NAME)
                ->onDelete('cascade');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CATEGORY_DEFAULT)->references(Category::FIELD_ID)
                ->on(Category::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_PRODUCT_TAX_TYPE)->references(ProductTaxType::FIELD_ID)
                ->on(ProductTaxType::TABLE_NAME);
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
