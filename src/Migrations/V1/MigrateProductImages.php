<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Image;
use \Neomerx\Core\Models\Product;
use \Neomerx\Core\Models\BaseProduct;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\ProductImage as Model;

class MigrateProductImages extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_IMAGE)->unique();
            $table->unsignedTinyInteger(Model::FIELD_POSITION);
            $table->boolean(Model::FIELD_IS_COVER);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_BASE_PRODUCT)
                ->references(BaseProduct::FIELD_ID)
                ->on(BaseProduct::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_PRODUCT)->references(Product::FIELD_ID)->on(Product::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_IMAGE)->references(Image::FIELD_ID)->on(Image::TABLE_NAME);
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
