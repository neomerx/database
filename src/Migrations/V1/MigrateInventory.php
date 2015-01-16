<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Product;
use \Neomerx\Core\Models\Warehouse;
use \Neomerx\Core\Models\Inventory as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateInventory extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_WAREHOUSE);
            $table->string(Model::FIELD_SKU, Product::SKU_MAX_LENGTH);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedBigInteger(Model::FIELD_IN)->default(0);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedBigInteger(Model::FIELD_OUT)->default(0);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_RESERVED)->default(0);

            if (self::usesTimestamps()) {
                $table->timestamps();
            }
            if (self::isSoftDeleting()) {
                $table->softDeletes();
            }

            $table->unique([Model::FIELD_SKU, Model::FIELD_ID_WAREHOUSE]);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_WAREHOUSE)->references(Warehouse::FIELD_ID)->on(Warehouse::TABLE_NAME);

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
