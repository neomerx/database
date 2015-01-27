<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Order;
use \Neomerx\Core\Models\Carrier;
use \Neomerx\Core\Models\ShippingOrderStatus;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\ShippingOrder as Model;

class MigrateShippingOrders extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_CARRIER);
            $table->unsignedInteger(Model::FIELD_ID_SHIPPING_ORDER_STATUS);
            $table->string(Model::FIELD_TRACKING_NUMBER, Model::TRACKING_NUMBER_MAX);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_ORDER)->references(Order::FIELD_ID)->on(Order::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CARRIER)->references(Carrier::FIELD_ID)->on(Carrier::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_SHIPPING_ORDER_STATUS)->references(ShippingOrderStatus::FIELD_ID)
                ->on(ShippingOrderStatus::TABLE_NAME);
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
