<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Country;
use \Neomerx\Core\Models\Region as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateRegions extends BaseMigrate
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
            $table->string(Model::FIELD_NAME, Model::NAME_MAX_LENGTH);
            $table->unsignedInteger(Model::FIELD_ID_COUNTRY);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->smallInteger(Model::FIELD_POSITION)->unsigned();

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_COUNTRY)->references(Country::FIELD_ID)->on(Country::TABLE_NAME);

            $table->unique([Model::FIELD_ID_COUNTRY, Model::FIELD_POSITION]);
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
