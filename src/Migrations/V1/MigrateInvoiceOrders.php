<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Order;
use \Neomerx\Core\Models\Invoice;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\InvoiceOrder as Model;

class MigrateInvoiceOrders extends BaseMigrate
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

            $table->unsignedInteger(Model::FIELD_ID_INVOICE);

            // one invoice can include more than one order,
            // however order could be included to only one invoice
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_ORDER)->unique();
            $table->unique([Model::FIELD_ID_INVOICE, Model::FIELD_ID_ORDER]);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_INVOICE)->references(Invoice::FIELD_ID)->on(Invoice::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_ORDER)->references(Order::FIELD_ID)->on(Order::TABLE_NAME);
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
