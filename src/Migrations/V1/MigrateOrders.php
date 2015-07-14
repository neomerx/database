<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Store;
use \Neomerx\Core\Models\Address;
use \Neomerx\Core\Models\Currency;
use \Neomerx\Core\Models\Customer;
use \Neomerx\Core\Models\OrderStatus;
use \Neomerx\Core\Models\Order as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateOrders extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_CUSTOMER);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_BILLING_ADDRESS)->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_SHIPPING_ADDRESS)->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_STORE)->nullable();
            $table->unsignedInteger(Model::FIELD_ID_ORDER_STATUS);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->smallInteger(Model::FIELD_ID_CURRENCY)->unsigned();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_SHIPPING_COST)->unsigned();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_SHIPPING_TAX)->unsigned();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_PRODUCTS_TAX)->unsigned();
            $table->text(Model::FIELD_TAX_DETAILS);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CUSTOMER)->references(Customer::FIELD_ID)->on(Customer::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_BILLING_ADDRESS)->references(Address::FIELD_ID)->on(Address::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_SHIPPING_ADDRESS)->references(Address::FIELD_ID)->on(Address::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_STORE)->references(Store::FIELD_ID)->on(Store::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_ORDER_STATUS)->references(OrderStatus::FIELD_ID)
                ->on(OrderStatus::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CURRENCY)->references(Currency::FIELD_ID)->on(Currency::TABLE_NAME);
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
