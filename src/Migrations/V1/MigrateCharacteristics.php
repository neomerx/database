<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Measurement;
use \Neomerx\Core\Models\Characteristic as Model;
use \Illuminate\Database\Schema\Blueprint;

/**
 * @package Neomerx\Database
 */
class MigrateCharacteristics extends BaseMigrate
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
            $table->string(Model::FIELD_CODE, Model::CODE_MAX_LENGTH)->unique();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_MEASUREMENT)->nullable();

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_MEASUREMENT)
                ->references(Measurement::FIELD_ID)->on(Measurement::TABLE_NAME);
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
