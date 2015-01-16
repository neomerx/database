<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Address;
use \Neomerx\Core\Models\Customer;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\CustomerAddress as Model;

class MigrateCustomerAddresses extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_CUSTOMER);
            $table->unsignedInteger(Model::FIELD_ID_ADDRESS);
            $table->enum(Model::FIELD_TYPE, [Model::TYPE_BILLING, Model::TYPE_SHIPPING]);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->enum(Model::FIELD_IS_DEFAULT, [Model::IS_DEFAULT])->nullable();

            $table->unique([Model::FIELD_ID_CUSTOMER, Model::FIELD_ID_ADDRESS, Model::FIELD_TYPE]);
            $table->unique([Model::FIELD_ID_CUSTOMER, Model::FIELD_TYPE, Model::FIELD_IS_DEFAULT]);

            if (self::usesTimestamps()) {
                $table->timestamps();
            }
            if (self::isSoftDeleting()) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CUSTOMER)->references(Customer::FIELD_ID)->on(Customer::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_ADDRESS)->references(Address::FIELD_ID)->on(Address::TABLE_NAME);
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
