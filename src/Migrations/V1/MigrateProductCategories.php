<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Product;
use \Neomerx\Core\Models\Category;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\ProductCategory as Model;

class MigrateProductCategories extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_PRODUCT);
            $table->unsignedInteger(Model::FIELD_ID_CATEGORY);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->smallInteger(Model::FIELD_POSITION)->unsigned();

            if (self::usesTimestamps()) {
                $table->timestamps();
            }
            if (self::isSoftDeleting()) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_PRODUCT)->references(Product::FIELD_ID)->on(Product::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CATEGORY)->references(Category::FIELD_ID)->on(Category::TABLE_NAME);
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
