<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\CustomerPasswordReset as Model;

class MigrateCustomerPasswordResets extends BaseMigrate
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
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_EMAIL)->index();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_TOKEN)->index();

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }
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
