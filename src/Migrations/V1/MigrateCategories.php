<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Category as Model;
use \Illuminate\Database\Schema\Blueprint;

/**
 * @package Neomerx\Database
 */
class MigrateCategories extends BaseMigrate
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
        $tableName = Model::TABLE_NAME;
        Schema::create($tableName, function (Blueprint $table) {
            $table->increments(Model::FIELD_ID);
            $table->unsignedInteger(Model::FIELD_ID_ANCESTOR);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_CODE, Model::CODE_MAX_LENGTH)->unique();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_LINK, Model::LINK_MAX_LENGTH)->unique();
            $table->boolean(Model::FIELD_ENABLED);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_LFT)->unique();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_RGT)->unique();

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_ANCESTOR)->references(Model::FIELD_ID)->on(Model::TABLE_NAME);

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
