<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Support as S;
use \Neomerx\Core\Models\Order;
use \Neomerx\Core\Models\Product;
use \Neomerx\Core\Models\ShippingOrder;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\OrderDetails as Model;

class MigrateOrderDetails extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_ORDER);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_SHIPPING_ORDER)->nullable();
            $table->unsignedInteger(Model::FIELD_ID_PRODUCT);
            $table->unsignedBigInteger(Model::FIELD_PRICE_WO_TAX);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->smallInteger(Model::FIELD_QUANTITY)->unsigned();

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_ORDER)->references(Order::FIELD_ID)->on(Order::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_PRODUCT)->references(Product::FIELD_ID)->on(Product::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_SHIPPING_ORDER)->references(ShippingOrder::FIELD_ID)
                ->on(ShippingOrder::TABLE_NAME)->onDelete('set null');
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
