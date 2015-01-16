<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Currency;
use \Neomerx\Core\Models\Language;
use \Neomerx\Core\Models\Supplier;
use \Neomerx\Core\Models\Warehouse;
use \Neomerx\Core\Models\SupplyOrder as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateSupplyOrders extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_SUPPLIER);
            $table->unsignedInteger(Model::FIELD_ID_WAREHOUSE);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->smallInteger(Model::FIELD_ID_CURRENCY)->unsigned();
            $table->unsignedInteger(Model::FIELD_ID_LANGUAGE);
            $table->timestamp(Model::FIELD_EXPECTED_AT);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->enum(Model::FIELD_STATUS, [Model::STATUS_DRAFT, Model::STATUS_VALIDATED, Model::STATUS_CANCELLED])
                ->default(Model::STATUS_DRAFT);

            if (self::usesTimestamps()) {
                $table->timestamps();
            }
            if (self::isSoftDeleting()) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_SUPPLIER)->references(Supplier::FIELD_ID)->on(Supplier::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_WAREHOUSE)->references(Warehouse::FIELD_ID)->on(Warehouse::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CURRENCY)->references(Currency::FIELD_ID)->on(Currency::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_LANGUAGE)->references(Language::FIELD_ID)->on(Language::TABLE_NAME);
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
