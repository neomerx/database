<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Employee as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateEmployees extends BaseMigrate
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
            $table->string(Model::FIELD_FIRST_NAME, Model::FIRST_NAME_MAX_LENGTH);
            $table->string(Model::FIELD_LAST_NAME, Model::LAST_NAME_MAX_LENGTH);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_EMAIL, Model::EMAIL_MAX_LENGTH)->unique();
            $table->string(Model::FIELD_PASSWORD, Model::PASSWORD_LENGTH);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->boolean(Model::FIELD_ACTIVE)->default(true);
            /** @noinspection PhpUndefinedMethodInspection */
            // instead of standard $table->rememberToken()
            $table->string(Model::FIELD_REMEMBER_TOKEN, Model::REMEMBER_TOKEN_LENGTH)->nullable();

            if (self::usesTimestamps()) {
                $table->timestamps();
            }
            if (self::isSoftDeleting()) {
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
