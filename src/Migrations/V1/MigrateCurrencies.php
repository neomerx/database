<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Currency as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateCurrencies extends BaseMigrate
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
            $table->unsignedSmallInteger(Model::FIELD_NUMBER)->unique();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_CODE, Model::CODE_MAX_LENGTH)->unique();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->tinyInteger(Model::FIELD_DECIMAL_DIGITS)->unsigned();
            $table->string(Model::FIELD_DECIMAL_POINTS_SEPARATOR, 1);
            $table->string(Model::FIELD_THOUSANDS_SEPARATOR, 1);

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
