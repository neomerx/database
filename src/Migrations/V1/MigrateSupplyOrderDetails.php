<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Support as S;
use \Neomerx\Core\Models\Product;
use \Neomerx\Core\Models\SupplyOrder;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\SupplyOrderDetails as Model;

class MigrateSupplyOrderDetails extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_SUPPLY_ORDER);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_PRICE_WO_TAX)->unsigned();
            $table->unsignedInteger(Model::FIELD_QUANTITY);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_DISCOUNT_RATE)->unsigned()->default(0);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->decimal(Model::FIELD_TAX_RATE)->unsigned()->default(0);
            $table->unsignedInteger(Model::FIELD_ID_PRODUCT);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_SUPPLY_ORDER)->references(SupplyOrder::FIELD_ID)
                ->on(SupplyOrder::TABLE_NAME)->onDelete('cascade');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_PRODUCT)->references(Product::FIELD_ID)
                ->on(Product::TABLE_NAME);
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
