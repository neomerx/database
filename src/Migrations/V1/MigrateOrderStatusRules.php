<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\OrderStatus;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\OrderStatusRule as Model;

class MigrateOrderStatusRules extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_ORDER_STATUS_FROM);
            $table->unsignedInteger(Model::FIELD_ID_ORDER_STATUS_TO);

            if (self::usesTimestamps()) {
                $table->timestamps();
            }
            if (self::isSoftDeleting()) {
                $table->softDeletes();
            }

            $table->unique(
                [Model::FIELD_ID_ORDER_STATUS_FROM, Model::FIELD_ID_ORDER_STATUS_TO],
                'order_status_rules_from_and_to_unique'
            );

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_ORDER_STATUS_FROM)->references(OrderStatus::FIELD_ID)
                ->on(OrderStatus::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_ORDER_STATUS_TO)->references(OrderStatus::FIELD_ID)
                ->on(OrderStatus::TABLE_NAME);
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
